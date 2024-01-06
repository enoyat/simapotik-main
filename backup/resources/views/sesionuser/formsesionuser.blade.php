@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>sesionuser</h1>
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
                                        <form action="{{ route('sesionuser.store') }}" method="POST" role="form"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nama User</label>
                                                <select name="email" id="email" class="form-control" required ></select>

                                            </div>

                                            <div class="form-group">
                                                <label>Token</label>
                                                <input type="text" class="form-control" id="token"
                                                    name="token" placeholder="token"
                                                    value="{{ $token }}" required="">
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
        <script>
            $("#email").select2({
                    placeholder: 'Pilih email user',
                    ajax: {
                        url: "{{ route('sesionuser.getuser') }}",
                        type: "GET",
                        dataType: 'JSON',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term,
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });
        </script>
    @endsection
