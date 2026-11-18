<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityMonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['role:super-admin|admin|manager|staff']);
    }
    public function index(Request $request)
    {
        $user = auth()->user();

        // QUERY DASAR
        $query = ActivityLog::query();

        // PEMBATASAN CABANG
        // User cabang hanya melihat aktivitas cabangnya.
        // User tanpa branch_id sementara dianggap memiliki akses seluruh cabang.
        if ($user && !empty($user->branch_id) && $user->branch_id > 0) {
            $query->where('branch_id', $user->branch_id);
        }

        // FILTER TANGGAL
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->tanggal_selesai
            );
        }

        // FILTER USER
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // FILTER MODUL
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // FILTER AKTIVITAS
        if ($request->filled('activity')) {
            $query->where('activity', $request->activity);
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER CABANG
        if (
            $request->filled('branch_id') &&
            (!$user || empty($user->branch_id) || $user->branch_id <= 0)
        ) {
            $query->where('branch_id', $request->branch_id);
        }

        // ==========================================
        // STATISTIK HARI INI
        // ==========================================

        $statistikQuery = ActivityLog::query();

        if ($user && !empty($user->branch_id) && $user->branch_id > 0) {
            $statistikQuery->where('branch_id', $user->branch_id);
        }

        $statistikQuery->whereDate('created_at', today());

        $totalAktivitasHariIni = (clone $statistikQuery)
            ->count();

        $totalUserAktifHariIni = (clone $statistikQuery)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $totalAktivitasBerhasil = (clone $statistikQuery)
            ->where('status', 'SUCCESS')
            ->count();

        $totalAktivitasGagal = (clone $statistikQuery)
            ->where('status', 'FAILED')
            ->count();

        // ==========================================
        // DATA FILTER
        // ==========================================

        $modules = ActivityLog::select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        $activities = ActivityLog::select('activity')
            ->distinct()
            ->orderBy('activity')
            ->pluck('activity');

        $users = ActivityLog::select(
            'user_id',
            'user_name',
            'username'
        )
            ->whereNotNull('user_id')
            ->distinct()
            ->orderBy('username')
            ->get();

        $branches = ActivityLog::select('branch_id')
            ->whereNotNull('branch_id')
            ->distinct()
            ->orderBy('branch_id')
            ->pluck('branch_id');

        // ==========================================
        // DAFTAR AKTIVITAS
        // ==========================================

        $logs = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('monitoring.activity.index', compact(
            'logs',
            'modules',
            'activities',
            'users',
            'branches',
            'totalAktivitasHariIni',
            'totalUserAktifHariIni',
            'totalAktivitasBerhasil',
            'totalAktivitasGagal'
        ));
    }
}
