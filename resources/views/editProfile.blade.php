@extends('layouts.layout')

@section("title")
	Edit Profile | Event Management System
@endsection

@section("navtitle")
    Edit Profile
@endsection

@section('content')
<div class="profile-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="editProfile">Profile Details</a></li>
                        <li><a href="changePassword">Change Password</a></li>
                        <li><a href="billing">Billing</a></li>
                    </ul>
                    <div class="panel-heading"><p class="text-success">{{ session('message') }}</p></div>
                    <div class="panel-body">
                    <form method="POST" action="{{ route('editProfile') }}">
                        @csrf
                        @if (session('status'))
                            <p class="text-success">{{ session('status') }}</p>
                        @endif
                        {{-- Username --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" 
                                class="form-control @error('name') is-invalid @enderror" name="username" 
                                value="{{ $users->username}}" required autocomplete="username" autofocus 
                                placeholder="e.g. Adam Smith">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right required">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" name="email" 
                                value="{{ $users->email }}" required autocomplete="email" placeholder="e.g. adamsmith@gmail.com">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Phone --}}
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right required">{{ __('Phone No.') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" 
                                class="form-control @error('phone') is-invalid @enderror" name="phone" 
                                value="{{ $users->phone }}" placeholder="e.g. 012-3456789">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Address --}}
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Home Address') }}</label>
                            <div class="col-md-6">
                                <textarea id="address" 
                                class="form-control" rows="2" cols="57" 
                                name="address" 
                                placeholder=" Please fill in your address" >{{ $users->address }}</textarea>
                            </div>
                        </div>
                        {{-- Submit button --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4"><br>
                                <button type="submit" class="btn btn-primary" value="Register">
                                    {{ __('Update Details') }}
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