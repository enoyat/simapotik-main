@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <div class="container-fluid">

            {{-- STATISTIK --}}
            <div class="row">

                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon">
                            <i class="fas fa-history"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Aktivitas Hari Ini</span>
                            <span class="info-box-number">
                                {{ number_format($totalAktivitasHariIni) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-success">
                        <span class="info-box-icon">
                            <i class="fas fa-users"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Karyawan Aktif</span>
                            <span class="info-box-number">
                                {{ number_format($totalUserAktifHariIni) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon">
                            <i class="fas fa-check-circle"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Aktivitas Berhasil</span>
                            <span class="info-box-number">
                                {{ number_format($totalAktivitasBerhasil) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Aktivitas Gagal</span>
                            <span class="info-box-number">
                                {{ number_format($totalAktivitasGagal) }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i>
                        Filter Aktivitas
                    </h3>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('monitoring.activity') }}">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>

                                    <input type="date" name="tanggal_mulai" class="form-control"
                                        value="{{ request('tanggal_mulai') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>

                                    <input type="date" name="tanggal_selesai" class="form-control"
                                        value="{{ request('tanggal_selesai') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Karyawan</label>

                                    <select name="user_id" class="form-control">

                                        <option value="">Semua Karyawan</option>

                                        @foreach ($users as $user)
                                            <option value="{{ $user->user_id }}"
                                                {{ request('user_id') == $user->user_id ? 'selected' : '' }}>

                                                {{ $user->user_name ?? $user->username }}

                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Modul</label>

                                    <select name="module" class="form-control">

                                        <option value="">Semua Modul</option>

                                        @foreach ($modules as $module)
                                            <option value="{{ $module }}"
                                                {{ request('module') == $module ? 'selected' : '' }}>

                                                {{ $module }}

                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Aktivitas</label>

                                    <select name="activity" class="form-control">

                                        <option value="">Semua Aktivitas</option>

                                        @foreach ($activities as $activity)
                                            <option value="{{ $activity }}"
                                                {{ request('activity') == $activity ? 'selected' : '' }}>

                                                {{ $activity }}

                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>

                                    <select name="status" class="form-control">

                                        <option value="">Semua Status</option>

                                        <option value="SUCCESS" {{ request('status') == 'SUCCESS' ? 'selected' : '' }}>
                                            SUCCESS
                                        </option>

                                        <option value="FAILED" {{ request('status') == 'FAILED' ? 'selected' : '' }}>
                                            FAILED
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cabang</label>

                                    <select name="branch_id" class="form-control">

                                        <option value="">Semua Cabang</option>

                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch }}"
                                                {{ request('branch_id') == $branch ? 'selected' : '' }}>

                                                Cabang {{ $branch }}

                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">

                                <div class="form-group">

                                    <button type="submit" class="btn btn-primary">

                                        <i class="fas fa-search"></i>
                                        Filter

                                    </button>

                                    <a href="{{ route('monitoring.activity') }}" class="btn btn-secondary">

                                        <i class="fas fa-sync"></i>
                                        Reset

                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>
            </div>

            {{-- TABEL ACTIVITY LOG --}}
            <div class="card card-outline card-primary">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Riwayat Aktivitas
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-primary">
                            {{ $logs->total() }} Data
                        </span>
                    </div>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped table-hover mb-0">

                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th width="150">Waktu</th>
                                    <th width="180">Karyawan</th>
                                    <th width="80">Cabang</th>
                                    <th width="120">Modul</th>
                                    <th width="120">Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th width="130">IP Address</th>
                                    <th width="100">Status</th>
                                    <th width="70" class="text-center">Detail</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($logs as $log)
                                    <tr>

                                        <td class="text-center">
                                            {{ $logs->firstItem() + $loop->index }}
                                        </td>

                                        <td>
                                            <small>
                                                {{ $log->created_at->format('d/m/Y') }}
                                            </small>
                                            <br>
                                            <strong>
                                                {{ $log->created_at->format('H:i:s') }}
                                            </strong>
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $log->user_name ?? ($log->username ?? 'Unknown') }}
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                User ID: {{ $log->user_id ?? '-' }}
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            {{ $log->branch_id ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="badge badge-info">
                                                {{ $log->module }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $log->activity }}
                                        </td>

                                        <td>
                                            {{ $log->description }}
                                        </td>

                                        <td>
                                            <small>
                                                {{ $log->ip_address ?? '-' }}
                                            </small>
                                        </td>

                                        <td class="text-center">

                                            @if ($log->status == 'SUCCESS')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i>
                                                    SUCCESS
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    {{ $log->status }}
                                                </span>
                                            @endif

                                        </td>

                                        <td class="text-center">

                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#detail{{ $log->id }}" title="Lihat detail">

                                                <i class="fas fa-eye"></i>

                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="10" class="text-center py-4">

                                            <i class="fas fa-info-circle text-muted"></i>

                                            <br>

                                            <span class="text-muted">
                                                Belum ada aktivitas yang tercatat.
                                            </span>

                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- PAGINATION --}}
                <div class="card-footer clearfix">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div class="text-muted mb-2 mb-md-0">
                            Menampilkan
                            <strong>{{ $logs->firstItem() ?? 0 }}</strong>
                            sampai
                            <strong>{{ $logs->lastItem() ?? 0 }}</strong>
                            dari
                            <strong>{{ $logs->total() }}</strong>
                            aktivitas
                        </div>

                        <div>
                            {{ $logs->links() }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- MODAL DETAIL --}}
            @foreach ($logs as $log)
                <div class="modal fade" id="detail{{ $log->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="detailLabel{{ $log->id }}" aria-hidden="true">

                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

                        <div class="modal-content">

                            <div class="modal-header bg-info">

                                <h5 class="modal-title" id="detailLabel{{ $log->id }}">

                                    <i class="fas fa-history mr-2"></i>

                                    Detail Aktivitas #{{ $log->id }}

                                </h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    <span aria-hidden="true">&times;</span>

                                </button>

                            </div>

                            <div class="modal-body">

                                {{-- INFORMASI AKTIVITAS --}}
                                <h6 class="text-primary">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Informasi Aktivitas
                                </h6>

                                <table class="table table-sm table-bordered">

                                    <tr>
                                        <th width="30%">Waktu</th>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>

                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <td>{{ $log->user_name ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Username</th>
                                        <td>{{ $log->username ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>User ID</th>
                                        <td>{{ $log->user_id ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Cabang</th>
                                        <td>{{ $log->branch_id ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Modul</th>
                                        <td>{{ $log->module }}</td>
                                    </tr>

                                    <tr>
                                        <th>Aktivitas</th>
                                        <td>{{ $log->activity }}</td>
                                    </tr>

                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $log->description }}</td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $log->status }}</td>
                                    </tr>

                                </table>

                                {{-- INFORMASI REQUEST --}}
                                <h6 class="text-primary mt-3">
                                    <i class="fas fa-network-wired mr-1"></i>
                                    Informasi Request
                                </h6>

                                <table class="table table-sm table-bordered">

                                    <tr>
                                        <th width="30%">IP Address</th>
                                        <td>{{ $log->ip_address ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Route</th>
                                        <td>{{ $log->route ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Method</th>
                                        <td>{{ $log->method ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Request ID</th>
                                        <td>{{ $log->request_id ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Subject</th>
                                        <td>
                                            {{ $log->subject_type ?? '-' }}
                                            /
                                            {{ $log->subject_id ?? '-' }}
                                        </td>
                                    </tr>

                                </table>

                                {{-- DATA SEBELUM --}}
                                <h6 class="text-primary mt-3">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Data Sebelum
                                </h6>

                                <div class="bg-light border rounded p-3">

                                    <pre class="mb-0" style="white-space: pre-wrap; word-break: break-word;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

                                </div>

                                {{-- DATA SESUDAH --}}
                                <h6 class="text-primary mt-3">
                                    <i class="fas fa-arrow-right mr-1"></i>
                                    Data Sesudah
                                </h6>

                                <div class="bg-light border rounded p-3">

                                    <pre class="mb-0" style="white-space: pre-wrap; word-break: break-word;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

                                </div>

                                {{-- PROPERTIES --}}
                                <h6 class="text-primary mt-3">
                                    <i class="fas fa-cogs mr-1"></i>
                                    Properties
                                </h6>

                                <div class="bg-light border rounded p-3">

                                    <pre class="mb-0" style="white-space: pre-wrap; word-break: break-word;">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

                                </div>

                                {{-- USER AGENT --}}
                                <h6 class="text-primary mt-3">
                                    <i class="fas fa-desktop mr-1"></i>
                                    User Agent
                                </h6>

                                <div class="bg-light border rounded p-3">

                                    <small style="word-break: break-word;">
                                        {{ $log->user_agent ?? '-' }}
                                    </small>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                    <i class="fas fa-times mr-1"></i>
                                    Tutup

                                </button>

                            </div>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    </div>
@endsection
