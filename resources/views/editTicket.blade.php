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
                    <li><a href="{{ route('publishEvent', ['id' => $events->id]) }}" class=""><i class="lnr lnr-file-add"></i> <span>Publish</span></a></li>
				</ul>
				<h3 style="font-size: 20px; border-bottom: 3px solid #676A6B"></h3>
				<ul class="nav">
					<li><a href="{{ route('dashboard', ['id' => $events->id]) }}" class=""><i class="lnr lnr-chart-bars"></i> <span>Dashboard</span></a></li>
					<li><a href="{{ route('manageUsers', ['id' => $events->id]) }}" class=""><i class="lnr lnr-users"></i> <span>Manage Assistant</span></a></li>
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
                                <label for="type" class="col-md-4 col-form-label text-md-right required">{{ __('Ticket Type') }}</label>
                                @php
                                $checkTickets = $events->tickets->pluck("type")->toArray();
                                @endphp
                                <div class="col-md-4">
                                @if ($events->publish_status != "Published")
                                    <select id="type" name="type" class="form-control">
                                        <option value="null" disabled selected>Ticket Type</option>
                                        <option value="General Admission" @if($tickets->type == "General Admission") selected=selected; @endif @if (in_array("General Admission", $checkTickets)) disabled @endif>General Admission</option>
                                        <option value="Participant/Attendee" @if($tickets->type == "Participant/Attendee") selected=selected; @endif @if (in_array("Participant/Attendee", $checkTickets)) disabled @endif>Participant/Attendee</option>
                                        <option value="Speaker" @if($tickets->type == "Speaker") selected=selected; @endif @if (in_array("Speaker", $checkTickets)) disabled @endif>Speaker</option>
                                        <option value="Exhibitor" @if($tickets->type == "Exhibitor") selected=selected; @endif @if (in_array("Exhibitor", $checkTickets)) disabled @endif>Exhibitor</option>
                                        <option value="Vendor" @if($tickets->type == "Vendor") selected=selected; @endif @if (in_array("Vendor", $checkTickets)) disabled @endif>Vendor</option>
                                        <option value="VIP" @if($tickets->type == "VIP") selected=selected; @endif @if (in_array("VIP", $checkTickets)) disabled @endif>VIP</option>
                                        <option value="Student" @if($tickets->type == "Student") selected=selected; @endif @if (in_array("Student", $checkTickets)) disabled @endif>Student</option>
                                        <option value="Other" @if($tickets->type == "Other") selected=selected; @endif @if (in_array("Other", $checkTickets)) disabled @endif>Other</option>
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
                                    <input id="price" type="number" name="price" class="form-control"
                                    maxlength="4" step="0.01" min="0.00" max="1000.00" value="{{ old('price',$tickets->price) }}"
                                    placeholder="0.00"
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