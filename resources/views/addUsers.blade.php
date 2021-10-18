@extends('layouts.layout')

@section('title')
	Add Event Assistant | Event Management System
@endsection

@section("navtitle")
    Add Event Assistant
@endsection

@section("sidebar")
<!-- LEFT SIDEBAR -->
	@auth
	@if (Auth::user()->isAdmin() | Auth::user()->isAssistant())
	<div id="sidebar-nav" class="sidebar">
		<div class="sidebar-scroll">
			<nav>
				<ul class="nav">
					<li><a href="{{ route('eventDetails', ['id' => $events->id]) }}" class=""><i class="lnr lnr-home"></i> <span>Details</span></a></li>
					<li><a href="{{ route('manageTickets', ['id' => $events->id]) }}" class=""><i class="lnr lnr-tag"></i> <span>Ticketing</span></a></li>
                    <li><a href="{{ route('publishEvent', ['id' => $events->id]) }}" class=""><i class="lnr lnr-file-add"></i> <span>Publish</span></a></li>
				</ul>
				<h3 style="font-size: 20px; border-bottom: 3px solid #676A6B"></h3>
				<ul class="nav">
					<li><a href="{{ route('dashboard', ['id' => $events->id]) }}" class=""><i class="lnr lnr-chart-bars"></i> <span>Dashboard</span></a></li>
					<li><a href="{{ route('manageUsers', ['id' => $events->id]) }}" class="active"><i class="lnr lnr-users"></i> <span>Manage Assistant</span></a></li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- END LEFT SIDEBAR -->
	@endif
	@endauth
@endsection

@section('content')
<div class="event-assistant">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading"></div>
                        <div class="panel-body">
                        <form method="POST" action="{{ route('addUsers',['id'=>$events->id]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Assistant Name') }}</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" 
                                    class="form-control @error('username') is-invalid @enderror" name="username" 
                                    value="{{ old('username') }}" required autocomplete="username" autofocus 
                                    placeholder="e.g. Adam Smith">

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

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
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone No.') }}</label>

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
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" 
                                    class="form-control" name="password_confirmation" 
                                    required autocomplete="new-password" placeholder="Confirm the password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">
                                    <button type="submit" class="btn btn-primary" value="Register">
                                        {{ __('Register event asssistant') }}
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