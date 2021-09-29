@extends('layouts.layout')

@section('title')
	Edit Ticket Details | Event Management System
@endsection

@section("navtitle")
    Edit Ticket Details
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
					<li><a href="{{ route('manageTickets', ['id' => $events->id]) }}" class="active"><i class="lnr lnr-tag"></i> <span>Ticketing</span></a></li>
					<li><a href="{{ route('manageUsers', ['id' => $events->id]) }}" class=""><i class="lnr lnr-users"></i> <span>User Management</span></a></li>
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
                        <form method="POST" action="{{ route('editTicket',['id'=>$events->id, 'ticket_id'=>$tickets->id]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Ticket Name') }}</label>

                                <div class="col-md-4">
                                    <input id="name" type="text" 
                                    class="form-control @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name',$tickets->name) }}" required autocomplete="name" autofocus 
                                    placeholder="Enter ticket name..." 
                                    @if ($events->publish_status == "Published") readonly @endif>
                                    

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
                                @if ($events->publish_status != "Published")
                                    <select id="type" name="type" class="form-control">
                                        <option value="null" disabled selected>Ticket Type</option>
                                        <option value="General Admission" @if($tickets->type == "General Admission") selected=selected; @endif>General Admission</option>
                                        <option value="Participant/Attendee" @if($tickets->type == "Participant") selected=selected; @endif>Participant/Attendee</option>
                                        <option value="Speaker" @if($tickets->type == "Speaker") selected=selected; @endif>Speaker</option>
                                        <option value="Exhibitor" @if($tickets->type == "Exhibitor") selected=selected; @endif>Exhibitor</option>
                                        <option value="Vendor" @if($tickets->type == "Vendor") selected=selected; @endif>Vendor</option>
                                        <option value="VIP">VIP</option>
                                        <option value="Student">Student</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @else
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                    name="type" value="{{ old('type', $tickets->type) }}" readonly>
                                @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right required">{{ __('Available Quantity') }}</label>

                                <div class="col-md-2">
                                    <input id="quantity" type="text" name="quantity" class="form-control"
                                    maxlength="4" min="1" max="1000" value="{{ old('quantity',$tickets->quantity) }}"
                                    placeholder="Quantity" 
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    @if ($events->publish_status == "Published") readonly @endif>

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
                                    maxlength="4" min="0" max="1000" value="{{ old('price',$tickets->price) }}"
                                    placeholder="0.00" 
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    @if ($events->publish_status == "Published") readonly @endif>

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="link" class="col-md-4 col-form-label text-md-right required">{{ __('Attach Link') }}</label>

                                <div class="col-md-4">
                                    <input id="link" type="text" 
                                    class="form-control @error('link') is-invalid @enderror" name="link" 
                                    value="{{ old('link',$tickets->link) }}" required autocomplete="link" autofocus 
                                    placeholder="Attach ticket link..."
                                    @if ($events->publish_status == "Published") readonly @endif>

                                    @error('link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="qrcode" class="col-md-4 col-form-label text-md-right">{{ __('Ticket QR Code') }}</label>

                                <div class="col-md-2 offset-md-4">
                                    {{ QrCode::generate($tickets->link) }}
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">

                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4">
                                    @if ($events->publish_status != "Published")
                                        <button type="submit" class="btn btn-primary" value="Submit" >
                                            {{ __('Update ticket') }}
                                        </button>
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