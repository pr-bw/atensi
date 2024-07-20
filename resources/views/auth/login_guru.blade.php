<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Atensi - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-light"
    style="background-image: url('/assets/img/login/blue-abstract-gradient-wave-wallpaper.jpg'); background-size: cover;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-3">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="/assets/img/login/logo-smpislamparung.png" style="width: 180px"
                                            class="logo-smpislamparung">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang</h1>

                                        {{-- <p>
                                            @php
                                                echo Hash::make('aditya123');
                                            @endphp
                                        </p> --}}
                                    </div>
                                    <!-- Posisi pesan kesalahan -->
                                    <div class="text-center mb-3">
                                        @php
                                            $message_warning = Session::get('warning');
                                        @endphp
                                        @if (Session::get('warning'))
                                            <div class="alert alert-warning" role="alert">
                                                {{ $message_warning }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Akhir dari posisi pesan kesalahan -->

                                    <form action="{{ route('guru.login.process') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="nuptk" class="form-control form-control-user"
                                                id="nuptk" aria-describedby="emailHelp" placeholder="NUPTK">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" id="password"
                                                placeholder="Kata Sandi">
                                        </div>
                                        {{-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> --}}
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>

                                    <!-- Back Button -->
                                    <div class="text-center mt-3 col-6 mx-auto">
                                        <button type="button" class="btn btn-secondary btn-user btn-block">
                                            <a href="/" class="text-white">Kembali</a>
                                        </button>
                                    </div>
                                    <!-- End Back Button -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
