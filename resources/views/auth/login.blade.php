{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('login') }}"> @csrf
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    autocomplete="current-email" required/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu"
                                    autocomplete="current-password" required/>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="showPassword"
                                            id="showPassword" style="width : 18px; height : 18px;">

                                        <label class="form-check-label" for="remember" style="font-size:18px; font-weight:700;">
                                            {{ __('Show Password') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-3" style="display:none;">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            checked>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(() => {
            $('#showPassword').on('click', () => {
                let x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            });
        });
    </script>
@endsection

 --}}


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}">

    <meta property='og:title' content='{{env('APP_NAME')}}'/>
    <meta property='og:image' content='{{asset('assets/thumbnail.jpg')}}'/>
    <meta property='og:description' content='{{env('APP_DESCRIPTION')}}'/>
    <meta property='og:url' content='{{env('APP_URL')}}'/>
    <meta property='og:image:width' content='1200' />
    <meta property='og:image:height' content='627' />



    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{ asset('css/signin.css?v=') . time() }}" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form method="POST" action="{{ route('login') }}"> @csrf
            <img class="mb-4" src="{{ asset('assets/logo.png') }}" alt="" width="72"
                height="72">
            <h1 class="h3 mb-3 fw-normal">Đăng Nhập</h1>

            <div class="form-floating">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" required>
                <label for="floatingInput">Email</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu" required>
                <label for="floatingPassword">Mật khẩu</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="checkbox mb-3" style="display:none;">
                <label>
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked> Remember me
                </label>
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input onclick="showPasswordClicked()" class="form-check-input" type="checkbox" name="showPassword"
                        id="showPassword"> Hiển thị mật
                    khẩu
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Đăng nhập</button>

        </form>
    </main>



</body>
<script>
    function showPasswordClicked() {
        let x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

</html>
