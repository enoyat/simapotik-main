<?php

namespace App\Http\Controllers;

use App\Models\M_detailbayar;
use App\Models\M_detailpenjualan;
use App\Models\M_detailresep;
use App\Models\M_jurnalumum;
use App\Models\M_mstransaksi;
use App\Models\M_pendingdetailpenjualan;
use App\Models\M_pendingpenjualan;
use App\Models\M_penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogService;

class ApiPenjualan extends Controller
{
    public function index()
    {
        $barang = M_penjualan::where('kdpst', '')->get();
        return $data = [
            'status' => 'success',
            'data' => $barang,
        ];
    }
    public function show($id)
    {
        $barang = M_penjualan::find($id);
        return $data = [
            'status' => 'success',
            'data' => $barang,
        ];
    }
    public function gennotrans()
    {
        $kode = DB::table('jurnalumum')->max('notrans');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "JUM";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    public function store(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();


        $items = $request->Items ?? $request->items;

        // VALIDASI ITEMS
        if (empty($items)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Items tidak ditemukan'
            ], 400);
        }

        DB::beginTransaction();

        try {

            // ==========================================
            // 1. CEK KETERSEDIAAN STOK
            // ==========================================

            $stokKurang = [];

            foreach ($items as $item) {

                $barang = DB::table('stok')
                    ->where('kdbarang', $item['kdbarang'])
                    ->where('idlokasi', $item['idlokasi'])
                    ->lockForUpdate()
                    ->first();

                if (!$barang) {
                    $stokKurang[] = [
                        'kdbarang' => $item['kdbarang'],
                        'stok' => 0,
                        'diminta' => $item['qty']
                    ];

                    continue;
                }

                if ($barang->stok < $item['qty']) {
                    $stokKurang[] = [
                        'kdbarang' => $item['kdbarang'],
                        'stok' => $barang->stok,
                        'diminta' => $item['qty']
                    ];
                }
            }

            // JIKA STOK TIDAK MENCUKUPI
            if (!empty($stokKurang)) {

                DB::rollBack();

                return response()->json([
                    'status' => 'stok_tidak_cukup',
                    'items' => $stokKurang
                ]);
            }

            // ==========================================
            // 2. PERSIAPAN TRANSAKSI
            // ==========================================

            $jam = date('H:i');

            $jenispenjualan = ($request->idcustomer == 'P0001')
                ? 'R'
                : 'N';

            // ==========================================
            // 3. SIMPAN HEADER PENJUALAN
            // ==========================================

            $penjualanId = DB::table('penjualan')->insertGetId([
                'idcustomer' => $request->idcustomer,
                'total' => $request->total,
                'email' => $request->email,
                'modebayar' => $request->modebayar,
                'tgltrans' => date('Y-m-d'),
                'tipepenjualan' => $request->tipepenjualan,
                'jam' => $jam,
                'jenispenjualan' => $jenispenjualan,
            ]);

            // ==========================================
            // 4. IDENTITAS AUDIT STOK
            // ==========================================

            DB::statement("
            SET
                @audit_user_id = NULL,
                @audit_username = ?,
                @audit_ip_address = ?,
                @audit_activity = ?,
                @audit_ref_id = ?,
                @audit_description = ?
        ", [
                $request->email,
                $request->ip(),
                'PENJUALAN',
                $penjualanId,
                'Stok berkurang melalui transaksi penjualan aplikasi desktop'
            ]);

            // ==========================================
            // 5. SIMPAN DETAIL PENJUALAN
            // ==========================================

            foreach ($items as $item) {

                DB::table('detailpenjualan')->insert([
                    'idpenjualan' => $penjualanId,
                    'kdbarang' => $item['kdbarang'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'diskonpersen' => $item['diskonpersen'],
                    'diskon' => $item['diskon'],
                    'jumlah' => $item['jumlah'],
                    'idlokasi' => $item['idlokasi'],
                ]);

                /*
             * Trigger t_jual otomatis mengurangi stok.
             *
             * Trigger trg_audit_stok_update otomatis
             * mencatat perubahan stok.
             */
            }

            // ==========================================
            // 6. RESET IDENTITAS AUDIT
            // ==========================================

            DB::statement("
            SET
                @audit_user_id = NULL,
                @audit_username = NULL,
                @audit_ip_address = NULL,
                @audit_activity = NULL,
                @audit_ref_id = NULL,
                @audit_description = NULL
        ");
            // ==========================================
            // 7. ACTIVITY LOG PENJUALAN
            // ==========================================


            app(ActivityLogService::class)->record(
                'PENJUALAN',
                'CREATE',
                'Transaksi penjualan melalui aplikasi desktop',
                [
                    'email' => $request->email,
                    'subject_type' => 'penjualan',
                    'subject_id' => $penjualanId,

                    'new_values' => [
                        'idpenjualan' => $penjualanId,
                        'idcustomer' => $request->idcustomer,
                        'total' => $request->total,
                        'email' => $request->email,
                        'modebayar' => $request->modebayar,
                        'tgltrans' => date('Y-m-d'),
                        'tipepenjualan' => $request->tipepenjualan,
                        'jenispenjualan' => $jenispenjualan,
                        'jumlah_item' => count($items),
                    ],

                    'properties' => [
                        'sumber' => 'APLIKASI_DESKTOP',
                        'email_kasir' => $request->email,
                        'idcustomer' => $request->idcustomer,
                        'jumlah_item' => count($items),
                        'lokasi_penjualan' => collect($items)
                            ->pluck('idlokasi')
                            ->unique()
                            ->values()
                            ->toArray(),
                    ],
                ]
            );
            // ==========================================
            // 7. COMMIT TRANSAKSI
            // ==========================================

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'id_penjualan' => $penjualanId
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            // RESET AUDIT JIKA TERJADI ERROR
            try {
                DB::statement("
                SET
                    @audit_user_id = NULL,
                    @audit_username = NULL,
                    @audit_ip_address = NULL,
                    @audit_activity = NULL,
                    @audit_ref_id = NULL,
                    @audit_description = NULL
            ");
            } catch (\Throwable $resetError) {
                // Abaikan error reset
            }

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storepending(Request $request)
    {
        DB::beginTransaction();
        try {



            $jam = date("h:i");
            $penjualan = new M_pendingpenjualan;
            $penjualan->tgltrans = date("Y-m-d");
            $penjualan->jam = $jam;
            $penjualan->idcustomer = $request->idcustomer;
            $penjualan->total = $request->total;
            $penjualan->email = $request->email;
            $penjualan->modebayar = $request->modebayar;
            $penjualan->tipepenjualan = $request->tipepenjualan;
            $penjualan->save();
            $lastid = $penjualan->id;

            DB::commit();
            return $data = [
                'status' => 'success',
                'data' => [
                    'lastid' => $lastid,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return $data = [
                'status' => 'error',
                'data' => [
                    'status' => 'error',
                    $e->getMessage()
                ],
            ];
        }
    }

    public function storependingitem(Request $request)
    {
        DB::beginTransaction();
        try {
            M_pendingdetailpenjualan::create([
                'idpenjualan' => $request->idpenjualan,
                'kdbarang' => $request->kdbarang,
                'qty' => $request->qty,
                'harga' => $request->harga,
                'diskonpersen' => $request->diskonpersen,
                'diskon' => $request->diskon,
                'jumlah' => $request->jumlah,
                'idlokasi' => $request->idlokasi,
            ]);

            DB::commit();
            return $data = [
                'status' => 'success',
                'data' => [
                    'lastid' =>  $request->lastid,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return $data = [
                'status' => 'error',
                'data' => [
                    'status' => 'error',
                    $e->getMessage()
                ],
            ];
        }
    }
    public function getpending(Request $request)
    {
        $pending = M_pendingpenjualan::with('get_customer')->where('email', $request->email)->get();
        return $data = [
            'status' => 'success',
            'data' => $pending,
        ];
    }
    public function getpendingitem(Request $request)
    {
        $pending = M_pendingpenjualan::with('get_customer')->where('id', $request->id)->get();
        return $data = [
            'status' => 'success',
            'data' => $pending,
        ];
    }
    public function getitempending(Request $request)
    {
        $itempending = M_pendingdetailpenjualan::with('get_barang')->where('idpenjualan', $request->id)->get();
        return $data = [
            'status' => 'success',
            'data' => $itempending,
        ];
    }
    public function hapuspending(Request $request)
    {
        $pending = M_pendingpenjualan::where('id', $request->id)->delete();
        $itempending = M_pendingdetailpenjualan::where('idpenjualan', $request->id)->delete();
        return $data = [
            'status' => 'success',
            'data' => [],
        ];
    }

    public function storeresep(Request $request)
    {
        DB::beginTransaction();
        try {

            $detailresep = new M_detailresep();
            $detailresep->idpenjualan = $request->idpenjualan;
            $detailresep->idjenispasien = $request->idjenispasien;
            $detailresep->namapasien = $request->namapasien;
            $detailresep->iddokter = $request->iddokter;
            $detailresep->idpoly = $request->idpoly;
            $detailresep->noresep = $request->idpenjualan;
            $detailresep->admresep = '0';
            $detailresep->admracik = '0';
            $detailresep->save();

            DB::commit();
            return $data = [
                'status' => 'success',
                'data' => [
                    'lastid' => $request->idpenjualan,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return $data = [
                'status' => 'error',
                'data' => [
                    'status' => 'error',
                    $e->getMessage()
                ],
            ];
        }
    }
}
