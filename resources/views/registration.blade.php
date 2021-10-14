@extends('layouts.layout')

@section("title")
	Register | Event Management System
@endsection

@section("navtitle")
    Registration
@endsection

@section('content')
<div class="profile-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading"></div>
                        <div class="panel-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" 
                                    class="form-control @error('name') is-invalid @enderror" name="username" 
                                    value="{{ old('username') }}" required autocomplete="username" autofocus 
                                    placeholder="e.g. Adam Smith">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right required">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" 
                                    class="form-control @error('email') is-invalid @enderror" name="email" 
                                    value="{{ old('email') }}" required autocomplete="email" placeholder="e.g. adamsmith@gmail.com">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right required">{{ __('Phone No.') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" 
                                    class="form-control @error('phone') is-invalid @enderror" name="phone" 
                                    value="{{ old('phone') }}" placeholder="e.g. 012-3456789">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right required">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" 
                                    class="form-control @error('password') is-invalid @enderror" name="password" 
                                    required autocomplete="new-password" placeholder="Please enter password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-1" style="margin-left: -60px; margin-top: 4px;">
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>

                            </div>
                            
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right required">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="passwordConfirm" type="password" 
                                    class="form-control" name="password_confirmation" 
                                    required autocomplete="new-password" placeholder="Confirm the password">
                                </div>
                                <div class="col-md-1" style="margin-left: -60px; margin-top: 4px;">
                                    <i class="bi bi-eye-slash" id="togglePasswordConfirm"></i>
                                </div>
                            </div>

                            <br><br>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">
                                    <button type="submit" class="btn btn-primary" value="Register">
                                        {{ __('Register') }}
                                    </button>
                                    <a class="btn btn-primary" href="/">{{ __('Back to login') }}</a>
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
    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const passwordConfirm = document.querySelector('#passwordConfirm');


    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
    });

    togglePasswordConfirm.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordConfirm.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
    });
</script>
@endsection