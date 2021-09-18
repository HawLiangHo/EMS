@extends('layouts.layout')

@section('title')
	Publish | Event Management System
@endsection

@section("navtitle")
Publish
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
					<li><a href="{{ route('manageUsers', ['id' => $events->id]) }}" class=""><i class="lnr lnr-users"></i> <span>User Management</span></a></li>
					<li><a href="{{ route('dashboard', ['id' => $events->id]) }}" class=""><i class="lnr lnr-chart-bars"></i> <span>Dashboard</span></a></li>
                    <li><a href="{{ route('publishEvent', ['id' => $events->id]) }}" class="active"><i class="lnr lnr-file-add"></i> <span>Publish</span></a></li>
                </ul>
			</nav>
		</div>
	</div>
	<!-- END LEFT SIDEBAR -->
	@endif
	@endauth
@endsection

@section('content')
<div class="main-content">
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">Publish Event</h3>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('publishEvent',['id'=>$events->id]) }}" enctype="multipart/form-data">
                @csrf
            @if($events->publish_status != "Published")
                <button type="submit" class="btn btn-primary" value="Submit" style="float: right;">
                    Confirm Publish
                </button>
            @else
                <p>"{{ $events->title }}"  has been published</p>
            @endif
            </form>
        </div>
    </div>
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">Event Preview</h3>
        </div>
    </div>
	<div class="container-fluid" style="margin-left: 200px; margin-right: 100px;">
        <!-- OVERVIEW -->
        <div class="event-content-home" style="margin-left: 100px; margin-right: -100px;">
            <div class="container">
                <div class="col-md-4" style="margin-bottom: 20px;">
                    <div class="card" id="{{ 'homeEvents' . $events->id}}">
                        <div class="card-body text-left" style="padding: 0.85rem;">
                            <img style="height: 200px; width:100%;" class="img-fluid"
                                src="data:image/png;base64,{{ chunk_split(base64_encode($events->cover_image)) }}">
                            <div style="height: 0.35rem;"></div>
                            <div>
                                <h4 class="m-0">
                                    <a href="{{ route('viewEvents', ['id' => $events->id]) }}" style="color: rgb(48, 48, 48); font-weight: bold;">{{ $events->title }}</a>
                                </h4>
                                <label class="ms-0" style="margin-left: 0; color:rgb(255, 171, 15);">{{ date('d/m/Y', strtotime($events->start_date)) }}, {{ date('H:i A', strtotime($events->start_time)) }}</label><br>
                                <label class="ms-0" style="margin-left: 0; color:rgb(255, 169, 71);">{{ $events->type }}</label><br>
                                <label class="ms-0" style="margin-left: 0; color:rgb(132, 132, 132);">{{ $events->tags }}</label><br>
                                <label class="ms-0" style="margin-left: 0; color:rgb(255, 169, 71);">{{ $events->event_status }}</label><br>
                                <label class="ms-0" style="margin-left: 0; color:rgb(132, 132, 132);">Available Slots: {{ $events->remaining_num_of_participant }}/{{ $events->num_of_participant }}</label><br>
                                <label class="ms-0" style="margin-left: 0; color:rgb(15, 15, 15);">{{ $events->user->username }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- END OVERVIEW -->
	</div>
</div>
@endsection