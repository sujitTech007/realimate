<!DOCTYPE html>
<html>

<head>
    {{-- required meta tags --}}
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- title --}}
    <title>{{ __('Admin Login') . ' | ' . $websiteInfo->website_title }}</title>

    {{-- fav icon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/' . $websiteInfo->favicon) }}">

    {{-- bootstrap css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    {{-- login css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin-login.css') }}">
    
    
</head>

<body>
    {{-- login form start --}}
    <div class="login-page">
        @if (!empty($websiteInfo->logo))
            <div class="text-center mb-1">
                <img class="login-logo" src="{{ asset('assets/img/' . $websiteInfo->logo) }}" alt="logo">
            </div>
        @endif


        <div class="admin-login-page">

    <div class="admin-login-card">
        <div class="login-brand">
            
            <h2>Admin Login</h2>
            <p>Sign in to access your admin dashboard</p>
        </div>

        
        @if (session()->has('alert'))
            <div class="login-alert">
                <i class="fas fa-circle-exclamation"></i>
                <strong>{{ session('alert') }}</strong>
            </div>
        @endif

        <form class="login-form" action="{{ route('admin.auth') }}" method="POST">
            @csrf

            <div class="input-group">
                <label>Username</label>

                <div class="input-wrapper">
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Enter your username"
                    >
                </div>

                @if ($errors->has('username'))
                    <p class="login-error">
                        {{ $errors->first('username') }}
                    </p>
                @endif
            </div>

            <div class="input-group">
                <label>Password</label>

                <div class="input-wrapper">

                    <input
                        type="password"
                        name="password"
                        id="adminPassword"
                        placeholder="Enter your password"
                    >

                    <button type="button"
                            class="password-toggle"
                            onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordIcon"></i>
                    </button>
                </div>

                @if ($errors->has('password'))
                    <p class="login-error">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>

            <button type="submit" class="login-btn">
                <span>{{ __('login') }}</span>
                <i class="fas fa-arrow-right"></i>
            </button>

        </form>

        <a class="forget-link" href="{{ route('admin.forget_password') }}">
            {{ __('Forget Password or Username?') }}
        </a>

        <div class="login-footer">
            <span>© {{ date('Y') }} All Rights Reserved</span>
        </div>

    </div>

</div>

        <!-- <div class="form">
            @if (session()->has('alert'))
                <div class="alert alert-danger fade show" role="alert">
                    <strong>{{ session('alert') }}</strong>
                </div>
            @endif

            <form class="login-form" action="{{ route('admin.auth') }}" method="POST">
                @csrf
                <input type="text" name="username"  placeholder="Enter Username" />
                @if ($errors->has('username'))
                    <p class="text-danger text-left">{{ $errors->first('username') }}</p>
                @endif

                <input type="password" name="password"   placeholder="Enter Password" />
                @if ($errors->has('password'))
                    <p class="text-danger text-left">{{ $errors->first('password') }}</p>
                @endif

                <button type="submit" class="w-100">{{ __('login') }}</button>
            </form>

            <a class="forget-link" href="{{ route('admin.forget_password') }}">
                {{ __('Forget Password or Username?') }}
            </a>
        </div> -->
    </div>
    {{-- login form end --}}


    <script>
function togglePassword() {
    const password = document.getElementById('adminPassword');
    const icon = document.getElementById('passwordIcon');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

    {{-- jQuery --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    {{-- popper js --}}
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    {{-- bootstrap js --}}
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>

</html>
