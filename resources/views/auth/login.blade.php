@extends('layouts.layout')

@section("title")
	Login | Event Management System
@endsection

@section("navtitle")
    Login
@endsection

@section('content')
<div class="login-content">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading"></div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="text-danger row mb-3 col-sm-6 offset-sm-3">{{ session('status') }}</div><br>
                            @endif
                            @if (session('message'))
                                <div class="text-success row mb-3 col-sm-6 offset-sm-3">{{ session('message') }}</div><br>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right required">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                    name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right required">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="current-password" required>
                                    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-1" style="margin-left: -60px;">
                                    <label class="col-md-4 col-form-label text-md-right"></label>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">
                                    <button type="submit" class="btn btn-primary" value="Login">
                                        Login
                                    </button>
                                    <a class="btn btn-primary" href="{{ route('register') }}">Register an Account</a>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');


});
</script>
@endsection