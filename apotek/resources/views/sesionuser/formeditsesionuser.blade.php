@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>edit sesionuser</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        @if ($message = Session::get('success'))
                                            <div class="alert alert-success">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="{{ route('sesionuser.update',$datasesionuser->id) }}" method="POST" role="form"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="text" name="tgltrans" id="tgltrans" class="form-control" value =" {{ $datasesionuser->tgltrans }}" readonly></input>

                                            </div>
                                            <div class="form-group">
                                                <label>Nama User</label>
                                                <input type="text" name="email" id="email" class="form-control" value =" {{ $datasesionuser->email }}" readonly ></input>

                                            </div>

                                            <div class="form-group">
                                                <label>Token</label>
                                                <input type="text" class="form-control" id="token"
                                                    name="token" placeholder="token"
                                                    value="{{ $datasesionuser->token }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Aktif</label>
                                                <select name="f_status" id="f_status" class="form-control" required>
                                                    <option value="1" {{ $datasesionuser->f_status == 1 ? 'selected' : '' }}>Aktif</option>
                                                    <option value="0" {{ $datasesionuser->f_status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                                </select>
                                            </div>


                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <a href="{{ route('sesionuser') }}">
                                                <div class="btn btn-primary">Kembali</div>
                                            </a>

                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    @endsection
