@extends('layouts.layout')

@section("title")
	Billing | Event Management System
@endsection

@section("navtitle")
    Payment Details
@endsection

@section('content')
<div class="profile-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <ul class="nav nav-tabs">
                        <li><a href="editProfile">Profile Details</a></li>
                        <li><a href="changePassword">Change Password</a></li>
                        <li class="active"><a href="billing">Billing</a></li>
                    </ul>
                    <div class="panel-heading"><ins><h4></h4></ins></div>
                    <div class="panel-body">
                        {{-- Credit Amount --}}
                        <div class="form-group row">
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-right">{{ __('Available Credit (RM)') }}</label>
                            <div class="col-md-5">
                                <p style="font-size: 20px">RM {{ number_format($users->credit_balance, 2) }}</p>
                            </div>
                        </div>
                            {{-- Submit button --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4"><br>
                                    <a class="btn btn-primary" href="{{ route('reloadCredit') }}">{{ __('Reload Credit') }}</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection