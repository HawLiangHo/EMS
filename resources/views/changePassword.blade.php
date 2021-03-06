@extends('layouts.layout')

@section("title")
	Change Password | Event Management System
@endsection

@section("navtitle")
    Change Password
@endsection

@section('content')
<div class="profile-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <ul class="nav nav-tabs">
                        <li><a href="editProfile">Profile Details</a></li>
                        <li class="active"><a href="changePassword">Change Password</a></li>
                        <li><a href="billing">Billing</a></li>
                    </ul>
                    <div class="panel-heading"><p class="text-success">{{ session('message') }}</p></div>
                    <div class="panel-body">
                    <form method="POST" action="{{ route('changePassword') }}">
                        @csrf
                        @if (session('status'))
                            <p class="text-success">{{ session('status') }}</p>
                        @endif
                        {{-- Old Password --}}
                        <div class="form-group row">
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-right required">{{ __('Current Password') }}</label>
                            <div class="col-md-5">
                                <input id="oldPassword" type="password" 
                                class="form-control @error('oldPassword') is-invalid @enderror" name="oldPassword" 
                                value="{{ old('oldPassword') }}" 
                                required autocomplete="oldPassword" autofocus placeholder="Enter your password"> 
                                @error('oldPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1" style="margin-left: -60px; margin-top: 5px;">
                                <i class="bi bi-eye-slash" id="toggleOldPassword"></i>
                            </div>
                        </div>
                        {{-- New Password --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right required">{{ __('New Password') }}</label>
                            <div class="col-md-5">
                                <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" name="password" 
                                required autocomplete="new-password" placeholder="Enter new password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1" style="margin-left: -60px; margin-top: 5px;">
                                <i class="bi bi-eye-slash" id="toggleNewPassword"></i>
                            </div>
                        </div>
                        {{-- Confirm New Password --}}
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right required">{{ __('Confirm New Password') }}</label>
                            <div class="col-md-5">
                                <input id="password-confirm" type="password" 
                                class="form-control" name="password_confirmation" 
                                required autocomplete="new-password" placeholder="Confirm new password">
                            </div>
                            <div class="col-md-1" style="margin-left: -60px; margin-top: 5px;">
                                <i class="bi bi-eye-slash" id="togglePasswordConfirm"></i>
                            </div>
                        </div>
                        {{-- Submit button --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4"><br>
                                <button type="submit" class="btn btn-primary" value="submit">
                                    {{ __('Update Password') }}
                                </button>
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
    const toggleOldPassword = document.querySelector('#toggleOldPassword');
    const oldPassword = document.querySelector('#oldPassword');
    const toggleNewPassword = document.querySelector('#toggleNewPassword');
    const newPassword = document.querySelector('#password');
    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const passwordConfirm = document.querySelector('#password-confirm');


    toggleOldPassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = oldPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    oldPassword.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
    });

    toggleNewPassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    newPassword.setAttribute('type', type);
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