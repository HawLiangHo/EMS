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
	@if (Auth::user()->isAdmin()  | Auth::user()->isAssistant())
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
                        <form method="POST" action="{{ route('addTickets',['id'=>$events->id]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right required">{{ __('Ticket Type') }}</label>
                                @php
                                    $tickets = $events->tickets->pluck("type")->toArray();
                                @endphp
                                <div class="col-md-4">
                                    <select id="type" name="type" class="form-control">
                                        <option value="null" disabled selected>Ticket Type</option>
                                        <option value="General Admission" @if (in_array("General Admission", $tickets)) disabled @endif>General Admission</option>
                                        <option value="Participant/Attendee" @if (in_array("Participant/Attendee", $tickets)) disabled @endif>Participant/Attendee</option>
                                        <option value="Speaker" @if (in_array("Speaker", $tickets)) disabled @endif>Speaker</option>
                                        <option value="Exhibitor" @if (in_array("Exhibitor", $tickets)) disabled @endif>Exhibitor</option>
                                        <option value="Vendor" @if (in_array("Vendor", $tickets)) disabled @endif>Vendor</option>
                                        <option value="VIP" @if (in_array("VIP", $tickets)) disabled @endif>VIP</option>
                                        <option value="Student" @if (in_array("Student", $tickets)) disabled @endif>Student</option>
                                        <option value="Other" @if (in_array("Other", $tickets)) disabled @endif>Other</option>
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
                                    <input id="quantity" type="number" name="quantity" class="form-control"
                                    maxlength="4" min="1" 
                                    onblur="validateQuantityAllowed();"
                                    placeholder="Quantity" 
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">

                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-3" style="margin-top: 5px;">
                                    @php
                                        $maximum = $events->num_of_participant - $ticketCount;
                                    @endphp
                                    <p style="color: red;">* Remaining Quantity : {{ $maximum }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right required">{{ __('Set Price (RM)') }}</label>

                                <div class="col-md-2">
                                    <input id="price" type="number" name="price" class="form-control"
                                    maxlength="4" step="0.01" min="0.00" max="1000.00"
                                    placeholder="0.00">

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-5" style="margin-top: 5px;">
                                    @php
                                        $maximum = $events->num_of_participant - $ticketCount;
                                    @endphp
                                    <p style="color: red;">* Price Range Allowed : RM0.00 - RM1000.00</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="link" class="col-md-4 col-form-label text-md-right required">{{ __('Attach Link') }}</label>

                                <div class="col-md-4">
                                    <input id="link" type="text" 
                                    class="form-control @error('link') is-invalid @enderror" name="link" 
                                    value="{{ old('link') }}" required autocomplete="link" autofocus 
                                    placeholder="Attach ticket link...">

                                    @error('link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-2 offset-md-4">
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

@section('script')
<script>
    $(document).ready(function(){
            validateQuantityAllowed();
            
        });

        function validateQuantityAllowed(){
            var maximum = {{ $events->num_of_participant }} - {{ $ticketCount }};
            console.log(maximum);

            document.getElementById('quantity').setAttribute('max', maximum);
        }
</script>
@endsection