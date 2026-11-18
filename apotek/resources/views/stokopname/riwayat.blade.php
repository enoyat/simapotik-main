@extends('template.master-dashboard-administrator')

@section('contents')
    <style>
        .pagination {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 0;
        }

        .pagination .page-link {
            padding: 5px 10px !important;
            font-size: 12px !important;
            line-height: 1.5 !important;
        }

        .pagination .page-link svg {
            width: 16px !important;
            height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        .pagination svg {
            max-width: 16px !important;
            max-height: 16px !important;
        }

        .pagination .page-item {
            margin: 0 !important;
        }

        nav[aria-label="Pagination Navigation"] svg,
        .pagination svg {
            width: 14px !important;
            height: 14px !important;
        }
    </style>
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Riwayat Adjustment Stok</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Stok</li>
                            <li class="breadcrumb-item active">Riwayat Adjustment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                {{-- NOTIFIKASI --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- FILTER --}}
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-filter"></i>
                            Filter Riwayat Adjustment
                        </h3>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('stokopname.riwayat') }}">

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <input type="date" name="tglmulai" class="form-control"
                                            value="{{ request('tglmulai') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" name="tglakhir" class="form-control"
                                            value="{{ request('tglakhir') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <select name="idlokasi" class="form-control">
                                            <option value="">Semua Lokasi</option>
                                            @foreach ($lokasi as $l)
                                                <option value="{{ $l->idlokasi }}"
                                                    {{ request('idlokasi') == $l->idlokasi ? 'selected' : '' }}>
                                                    {{ $l->namalokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-info">
                                                <i class="fas fa-search"></i>
                                                Tampilkan
                                            </button>

                                            <a href="{{ route('stokopname.riwayat') }}" class="btn btn-secondary">
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                {{-- TABEL RIWAYAT --}}
                <div class="card card-outline card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history"></i>
                            Daftar Riwayat Stok Opname
                        </h3>
                    </div>

                    <div class="card-body table-responsive">

                        <table class="table table-bordered table-hover" id="mydata">

                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Lokasi</th>
                                    <th>Stok Sistem</th>
                                    <th>Stok Fisik</th>
                                    <th>Selisih</th>
                                    <th>Kasir</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($opname as $key)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            {{ date('d/m/Y H:i', strtotime($key->tanggal)) }}
                                        </td>

                                        <td>{{ $key->kdbarang }}</td>

                                        <td>{{ $key->namabarang ?? '-' }}</td>

                                        <td>{{ $key->namalokasi ?? '-' }}</td>

                                        <td class="text-right">
                                            {{ number_format($key->stoksistem, 0, ',', '.') }}
                                        </td>

                                        <td class="text-right">
                                            {{ number_format($key->stokfisik, 0, ',', '.') }}
                                        </td>

                                        <td class="text-right">
                                            @if ($key->selisih > 0)
                                                <span class="badge badge-success">
                                                    +{{ number_format($key->selisih, 0, ',', '.') }}
                                                </span>
                                            @elseif($key->selisih < 0)
                                                <span class="badge badge-danger">
                                                    {{ number_format($key->selisih, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">0</span>
                                            @endif
                                        </td>

                                        <td>{{ $key->email ?? '-' }}</td>

                                        <td>{{ $key->keterangan }}</td>

                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#modal_hapus{{ $key->id }}">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Menampilkan {{ $opname->firstItem() ?? 0 }}
                                - {{ $opname->lastItem() ?? 0 }}
                                dari {{ $opname->total() }} data
                            </small>

                            <div>
                                {{ $opname->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL HAPUS --}}
                @foreach ($opname as $key)
                    <div class="modal fade" id="modal_hapus{{ $key->id }}" tabindex="-1" role="dialog">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title">
                                        Konfirmasi Hapus Adjustment
                                    </h5>

                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('stokopname.hapus', $key->id) }}">

                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-body">

                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Perhatian! Penghapusan data ini akan
                                            membalikkan adjustment stok secara otomatis.
                                        </div>

                                        <p>Apakah Anda yakin ingin menghapus data berikut?</p>

                                        <table class="table table-sm">
                                            <tr>
                                                <th>Barang</th>
                                                <td>{{ $key->namabarang }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi</th>
                                                <td>{{ $key->namalokasi }}</td>
                                            </tr>
                                            <tr>
                                                <th>Stok Sistem</th>
                                                <td>{{ $key->stoksistem }}</td>
                                            </tr>
                                            <tr>
                                                <th>Stok Fisik</th>
                                                <td>{{ $key->stokfisik }}</td>
                                            </tr>
                                            <tr>
                                                <th>Selisih</th>
                                                <td>{{ $key->selisih }}</td>
                                            </tr>
                                        </table>

                                        <input type="hidden" name="email" value="{{ auth()->user()->email ?? '' }}">

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Batal
                                        </button>

                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                            Ya, Hapus Adjustment
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    </div>

    <script>
        $(function() {
            $('#mydata').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                scrollX: true,
                order: [
                    [1, 'desc']
                ]
            });
        });
    </script>
@endsection
