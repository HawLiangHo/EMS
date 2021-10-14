@extends('layouts.layout')

@section('title')
	Dashboard | Event Management System
@endsection

@section("navtitle")
    Dashboard
@endsection

@section("sidebar")
<!-- LEFT SIDEBAR -->
	@auth
	@if (Auth::user()->isAdmin() | Auth::user()->isAssistant())
	<div id="sidebar-nav" class="sidebar">
		<div class="sidebar-scroll">
			<nav>
				<ul class="nav">
					<li><a href="{{ route('eventDetails', ['id' => $event->id]) }}" class=""><i class="lnr lnr-home"></i> <span>Details</span></a></li>
					<li><a href="{{ route('manageTickets', ['id' => $event->id]) }}" class=""><i class="lnr lnr-tag"></i> <span>Ticketing</span></a></li>
                    <li><a href="{{ route('publishEvent', ['id' => $event->id]) }}" class=""><i class="lnr lnr-file-add"></i> <span>Publish</span></a></li>
				</ul>
				<h3 style="font-size: 20px; border-bottom: 3px solid #676A6B"></h3>
				<ul class="nav">
					<li><a href="{{ route('dashboard', ['id' => $event->id]) }}" class="active"><i class="lnr lnr-chart-bars"></i> <span>Dashboard</span></a></li>
					<li><a href="{{ route('manageUsers', ['id' => $event->id]) }}" class=""><i class="lnr lnr-users"></i> <span>Manage Assistant</span></a></li>
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
	<div class="container-fluid">
		<!-- OVERVIEW -->
		<div class="panel panel-headline">
			<div class="panel-heading">
				<h1><strong>{{ $event->title }} - General Overview</strong></h1>
				<h3 style="font-size: 20px; border-bottom: 1px solid #676A6B"></h3>
				{{-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> --}}
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-body">
								<div class="col-md-6">
									<h4><b>Event Available Status:</b></h4>
									<p>{{ $event->event_status }}</p>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-6">
									<h4><b>Event Start and End Date:</b></h4>
									<p>{{ date('d/m/Y', strtotime($event->start_date)) }}, {{ date('H:i A', strtotime($event->start_time)) }} - {{ date('d/m/Y', strtotime($event->end_date)) }}, {{ date('H:i A', strtotime($event->end_time)) }}</p>
								</div>
								<div class="col-md-6">
									<h4><b>Event Registration Start and End Date:</b></h4>
									<p>{{ date('d/m/Y', strtotime($event->registration_start_date)) }}, {{ date('H:i A', strtotime($event->registration_start_time)) }} - {{ date('d/m/Y', strtotime($event->registration_end_date)) }}, {{ date('H:i A', strtotime($event->registration_end_time)) }}</p>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-6">
									<h4><b>Targeted Number of Participants:</b></h4>
									<p>{{ $event->num_of_participant }} Participant(s)</p>
								</div>
								<div class="col-md-6">
									<h4><b>Actual Number of Participants:</b></h4>
									<p>{{ $totalTicket }} Participant(s)</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="text-align: center;">Ticket Sales Rate</h3>
							</div>
							<div class="panel-body">
								<div id="system-load" class="easy-pie-chart" data-percent="70">
									@if($totalTicket != 0 && $ticketsAvailable != 0)
										<span class="percent">{{ number_format($totalTicket / $ticketsAvailable * 100, 2) }}</span>
									@else
										<span class="percent">0</span>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="metric">
							<span class="icon"><i class="fa fa-ticket"></i></span>
							<p>
								<span class="number">{{ $totalTicket }}</span>
								<span class="title">Number of Ticket Sales</span>
							</p>
						</div>
						<div class="metric">
							<span class="icon"><i class="fa fa-eye"></i></span>
							<p>
								<span class="number">{{ $totalVisited }}</span>
								<span class="title">Page Visits</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END OVERVIEW -->
	</div>
</div>
<div class="main-content">
	<div class="container-fluid">
		<div class="panel panel-headline">
			<div class="panel-heading">
				<h1><strong>Analytics</strong></h1>
				<h3 style="font-size: 20px; border-bottom: 1px solid #676A6B"></h3>
				{{-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> --}}
			</div>
			<div class="panel-body">
				{{-- Event total revenue chart --}}
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="text-align: center;">Weekly Revenue Earned By Ticket Type (RM)</h3>
								<div class="right">
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-9">
									<div id="revenue-chart" class="ct-chart" style="position: relative"></div>
								</div>
								<div class="col-md-3">
									<div class="weekly-summary text-right">
										<span class="number">RM {{ number_format($totalRevenue, 2) }}</span>
										<span class="info-label">Total Revenue Earned</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Event total ticket sales chart --}}
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="text-align: center;">Overall Ticket Type Sales</h3>
								<div class="right">
								</div>
							</div>
							<div class="panel-body">
								<div id="ticket-sales-chart" class="ct-chart" style="position: relative"></div>
							</div>
						</div>
					</div>
				</div>
				{{-- Page Visit chart --}}
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title" style="text-align: center;">Event Page Visits Count</h3>
								<div class="right">
								</div>
							</div>
							<div class="panel-body">
								<div id="visits-trends-chart" class="ct-chart" style="position: relative;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(function() {
		var data, options;

		// headline charts
		data = {
			labels: [
				@foreach ($xLabel as $label)
					@php
						$revenue = collect($totalRevenues)->sum(function ($value) use ($loop) {
							return $value[$loop->index];
						});
					@endphp
					"{{ $label }}<br>(RM {{ $revenue }})",
				@endforeach
			],
			series: [
				@foreach ($totalRevenues as $ticketName => $revenues)
				[
					@foreach ($revenues as $revenue)
						{meta: "{{ $ticketName }}", value: @json($revenue)},
					@endforeach
				],
				@endforeach
			]
		};

		options = {
			height: 300,
			stackBars: true,
			showLine: true,
			showPoint: true,
			fullWidth: false,
			axisX: {
				showGrid: false
			},
			lineSmooth: true,
			plugins: [
				Chartist.plugins.tooltip({
					currency: "RM "
				}),
				// Chartist.plugins.legend({
				// 	position: 'bottom',
				// 	legendNames: [
				// 		@foreach ($totalRevenues as $ticketName => $revenues)
				// 		[
				// 			@json($ticketName),
				// 		],
				// 		@endforeach
				// 	]
				// })
			]
		};

		new Chartist.Bar('#revenue-chart', data, options);

		// headline charts 2
		data = {
			labels: [
				@foreach ($xLabel as $label)
					@php
						$ticketsSold = collect($totalTickets)->sum(function ($value) use ($loop) {
							return $value[$loop->index];
						});
					@endphp
					"{{ $label }}<br>({{ $ticketsSold }} tickets sold)",
				@endforeach
			],
			series: [
				@foreach ($totalTickets as $ticketName => $allTicket)
				[
					@foreach ($allTicket as $ticket)
						{meta: "{{ $ticketName }}", value: @json($ticket)},
					@endforeach
				],
				@endforeach
			]
		};

		options = {
			height: 300,
			stackBars: true,
			showLine: true,
			showPoint: true,
			fullWidth: false,
			axisX: {
				showGrid: false
			},
			lineSmooth: true,
			plugins: [
				Chartist.plugins.tooltip({
					currency: "Number of tickets sold: "
				})
			]
		};

		new Chartist.Bar('#ticket-sales-chart', data, options);


		// visits trend charts
		data = {
			labels: @json($xLabel),
			series: [
				@json($pageVisited)
			]
		};

		options = {
			lineSmooth: true,
			height: 300,
			axisX: {
				showGrid: false,

			},
			axisY: {
				showGrid: true,
				onlyInteger: true,
				offset: 0,
			},
			chartPadding: {
				left: 40,
				right: 40
			},
			plugins: [
				Chartist.plugins.tooltip({
					transformTooltipTextFnc: function (view) {
						return view + " views";
					}
				})
			]
		};

		new Chartist.Line('#visits-trends-chart', data, options);

		// real-time pie chart
		var sysLoad = $('#system-load').easyPieChart({
			size: 130,
			barColor: function(percent) {
				return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
			},
			trackColor: 'rgba(245, 245, 245, 0.8)',
			scaleColor: false,
			lineWidth: 5,
			lineCap: "square",
			animate: 800
		});
		sysLoad.find(".percent").text();

		@if($totalTicket != null && $ticketsAvailable != null)
			sysLoad.data('easyPieChart').update({{ number_format($totalTicket / $ticketsAvailable * 100) }} * 100 / 100);
		@else
			sysLoad.data('easyPieChart').update(0);
		@endif

	});
</script>
@endsection