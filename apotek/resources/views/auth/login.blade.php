@extends('template.master-login')

@section('content')

@include('sweetalert::alert')
<!-- Jumbotron -->
<div class="jumbotron-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card border-0 card-login shadow-none p-3">
                    <div class="card-header border-bottom-0" style="text-align: center">
                        <img class="mt-4" style="width: 50px; border-radius: 10px;"
                            src="{{asset('assets/img/logoapotik.png')}}">
                        <div style="margin-top: 5px">SIM Apotik</div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card-body">
                            <div style="text-align: center"><strong>SIM Apotik </strong>
                                <p></p>
                            </div>
                            <div class="form-group mb-4">
                                <h6>Email</h6>
                                <input id="email" type="email"
                                    class="form-control form-control-login rounded-right @error('email') is-invalid @enderror"
                                    placeholder="Email" name="email" value="{{ old('email') }}" required
                                    autocomplete="email">
                                <div class="invalid-feedback">
                                    @error('email')
                                    <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal Login!',
                                        text: 'Cek email dan password!'
                                    })
                                    </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <h6>Password</h6>
                                <input id="password" type="password"
                                    class="form-control form-control-login rounded-right @error('password') is-invalid @enderror"
                                    placeholder="Password" name="password" required autocomplete="current-password">
                                <div class="invalid-feedback">
                                    @error('password')
                                    <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal Login!',
                                        text: 'Cek email dan password!'
                                    })
                                    </script>
                                    @enderror
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn-primary float-right rounded-pill w-50">Sign In</button>

                            @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Jumbotron -->
@endsection
