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
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>
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
                        </div>
                        {{-- New Password --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
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
                        </div>
                        {{-- Confirm New Password --}}
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>
                            <div class="col-md-5">
                                <input id="password-confirm" type="password" 
                                class="form-control" name="password_confirmation" 
                                required autocomplete="new-password" placeholder="Confirm new password">
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