<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public function record($module, $activity, $description, $options = [])
    {
        // Prioritas: user dari Auth, kemudian user dari options
        $user = $options['user'] ?? Auth::user();

        // Jika belum ditemukan, cari berdasarkan email desktop
        if (!$user && !empty($options['email'])) {
            $user = User::where('email', $options['email'])->first();
        }

        $branchId = $options['branch_id']
            ?? ($user ? $user->branch_id : null);

        if (empty($branchId) || $branchId <= 0) {
            $branchId = null;
        }

        return ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'username' => $user ? $user->email : null,

            'branch_id' => $branchId,

            'module' => $module,
            'activity' => $activity,
            'description' => $description,

            'subject_type' => $options['subject_type'] ?? null,
            'subject_id' => isset($options['subject_id'])
                ? (string) $options['subject_id'] : null,

            'old_values' => $options['old_values'] ?? null,
            'new_values' => $options['new_values'] ?? null,
            'properties' => $options['properties'] ?? null,

            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'request_id' => request()->header('X-Request-ID'),

            'route' => request()->route()
                ? request()->route()->getName() : null,

            'method' => request()->method(),
            'status' => $options['status'] ?? 'SUCCESS',
        ]);
    }
}
