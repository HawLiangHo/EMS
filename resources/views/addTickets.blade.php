@extends('layouts.layout')

@section('title')
	Add New Ticket | Event Management System
@endsection

@section("navtitle")
    Add New Ticket
@endsection

@section("sidebar")
<!-- LEFT SIDEBAR -->
	@auth
	@if (Auth::user()->isAdmin())
	<div id="sidebar-nav" class="sidebar">
		<div class="sidebar-scroll">
			<nav>
				<ul class="nav">
                    <li><a href="{{ route('eventDetails', ['id' => $events->id]) }}" class=""><i class="lnr lnr-home"></i> <span>Details</span></a></li>
					<li><a href="{{ route('manageTickets', ['id' => $events->id]) }}" class=""><i class="lnr lnr-tag"></i> <span>Ticketing</span></a></li>
					<li><a href="{{ route('manageUsers', ['id' => $events->id]) }}" class="active"><i class="lnr lnr-users"></i> <span>User Management</span></a></li>
					<li><a href="{{ route('dashboard', ['id' => $events->id]) }}" class=""><i class="lnr lnr-chart-bars"></i> <span>Dashboard</span></a></li>
                    <li><a href="{{ route('publishEvent', ['id' => $events->id]) }}" class=""><i class="lnr lnr-file-add"></i> <span>Publish</span></a></li>
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
                        <form method="POST" action="{{ route('addTickets',['id'=>$events->id]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Ticket Name') }}</label>

                                <div class="col-md-4">
                                    <input id="name" type="text" 
                                    class="form-control @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name') }}" required autocomplete="name" autofocus 
                                    placeholder="Enter ticket name...">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right required">{{ __('Ticket Type') }}</label>

                                <div class="col-md-4">
                                    <select id="type" name="type" class="form-control">
                                        <option value="null" disabled selected>Ticket Type</option>
                                        <option value="General Admission">General Admission</option>
                                        <option value="Participant">Participant/Attendee</option>
                                        <option value="Speaker">Speaker</option>
                                        <option value="Exhibitor">Exhibitor</option>
                                        <option value="Vendor">Vendor</option>
                                        <option value="VIP">VIP</option>
                                        <option value="Student">Student</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right required">{{ __('Available Quantity') }}</label>

                                <div class="col-md-2">
                                    <input id="quantity" type="text" name="quantity" class="form-control"
                                    maxlength="4" min="1" max="1000"
                                    placeholder="Quantity" 
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">

                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right required">{{ __('Set Price (RM)') }}</label>

                                <div class="col-md-2">
                                    <input id="price" type="text" name="price" class="form-control"
                                    maxlength="4" min="0" max="1000"
                                    placeholder="0.00" 
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">

                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">
                                    <button type="submit" class="btn btn-primary" value="Register">
                                        {{ __('Save ticket') }}
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