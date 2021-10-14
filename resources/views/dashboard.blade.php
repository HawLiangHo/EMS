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
				<h1><strong>Event Dashboard</strong></h1>
				<h3 style="font-size: 20px; border-bottom: 1px solid #676A6B"></h3>
				{{-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> --}}
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Event Participation Rate</h3>
								<div class="right">
									{{-- <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> --}}
								</div>
							</div>
							<div class="panel-body">
								<div id="system-load" class="easy-pie-chart" data-percent="70">
									@if($totalTicket != 0 && $ticketsAvailable != 0)
										<span class="percent">{{ number_format($totalTicket / $ticketsAvailable * 100, 2) }}</span>
									@else
										<span class="percent">0</span>
									@endif
								</div>
								{{-- <h4>CPU Load</h4>
								<ul class="list-unstyled list-justify">
									<li>High: <span>95%</span></li>
									<li>Average: <span>87%</span></li>
									<li>Low: <span>20%</span></li>
									<li>Threads: <span>996</span></li>
									<li>Processes: <span>259</span></li>
								</ul> --}}
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
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>General Details</strong></h3>
								<div class="left">
									<h4>Event &nbsp - &nbsp {{ $event->title }}</h4>	
								</div>
							</div>
							<h3 style="font-size: 20px; border-bottom: 1px solid #676A6B; margin-left: 20px; margin-right: 20px;"></h3>
							<div class="panel-body">
								<div class="col-md-6">
									<h4><b>Event Type:</b></h4>
									<p>{{ $event->type }}</p>
								</div>
								<div class="col-md-6">
									<h4><b>Event Category:</b></h4>
									<p>{{ $event->category }}</p>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-6">
									<h4><b>Event Publication Status:</b></h4>
									<p>{{ $event->publish_status }}</p>
								</div>
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
			</div>
		</div>
		<!-- END OVERVIEW -->
		<div class="row">
			<div class="col-md-12">
				<!-- MULTI CHARTS -->
				{{-- <div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align: center;">Page Visit Statistics</h3>
						<div class="right">
							<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
							<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
						</div>
					</div>
					<div class="panel-body">
						<div id="visits-trends-chart" class="ct-chart" style="position: relative"></div>
					</div>
				</div> --}}
				<!-- END MULTI CHARTS -->
				<div class="row">
					<div class="col-md-3">
						{{-- <div class="metric">
							<span class="icon"><i class="fa fa-download"></i></span>
							<p>
								<span class="number">1,252</span>
								<span class="title">Downloads</span>
							</p>
						</div>
					</div>
					<div class="col-md-3">
						<div class="metric">
							<span class="icon"><i class="fa fa-shopping-bag"></i></span>
							<p>
								<span class="number">203</span>
								<span class="title">Sales</span>
							</p>
						</div>
					</div>
					<div class="col-md-3">
						<div class="metric">
							<span class="icon"><i class="fa fa-eye"></i></span>
							<p>
								<span class="number">274,678</span>
								<span class="title">Visits</span>
							</p>
						</div>
					</div>
					<div class="col-md-3">
						<div class="metric">
							<span class="icon"><i class="fa fa-bar-chart"></i></span>
							<p>
								<span class="number">35%</span>
								<span class="title">Conversions</span>
							</p>
						</div>
					</div> --}}
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-md-7">
				
			</div>
			<div class="col-md-5">

			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4">
				<!-- VISIT CHART -->
				{{-- <div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Website Visits</h3>
						<div class="right">
							<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
							<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
						</div>
					</div>
					<div class="panel-body">
						<div id="visits-chart" class="ct-chart"></div>
					</div>
				</div> --}}
				<!-- END VISIT CHART -->
			</div>
				<div class="col-md-4">
				</div>
			</div>
		</div>
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
								<h3 class="panel-title" style="text-align: center;">Total Revenue (RM)</h3>
								<div class="right">
									{{-- <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> --}}
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-9">
									<div id="revenue-chart" class="ct-chart" style="position: relative"></div>
								</div>
								<div class="col-md-3">
									<div class="weekly-summary text-right">
										{{-- <span class="number">$65,938</span> <span class="percentage"><i class="fa fa-caret-down text-danger"></i> 8%</span>
										<span class="info-label">Total Income</span> --}}
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
								<h3 class="panel-title" style="text-align: center;">Overall Ticket Sales</h3>
								<div class="right">
									{{-- <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> --}}
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
								<h3 class="panel-title" style="text-align: center;">Page Visits Count</h3>
								<div class="right">
									{{-- <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
									<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> --}}
								</div>
							</div>
							<div class="panel-body">
								<div id="visits-trends-chart" class="ct-chart" style="position: relative"></div>
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
			labels: @json($xLabel),
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
			labels: @json($xLabel),
			series: [
				@foreach ($totalTickets as $ticketName => $totalTicket)
				[
					@foreach ($totalTicket as $ticket)
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
			height: "270px",
			low: 0,
			high: 'auto',
			axisX: {
				showGrid: false,

			},
			axisY: {
				showGrid: true,
				onlyInteger: true,
				offset: 0,
			},
			chartPadding: {
				left: 20,
				right: 20
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


		// visits bar chart
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[6384, 6342, 5437, 2764, 3958, 5068, 7654]
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
		};

		new Chartist.Bar('#visits-chart', data, options);


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

		// var updateInterval = 3000; // in milliseconds

		// setInterval(function() {
		// 	var randomVal;
		// 	randomVal = getRandomInt(0, 100);

		@if($ticketSold != null && $ticketsAvailable != null)
			sysLoad.data('easyPieChart').update({{ number_format($ticketSold / $ticketsAvailable * 100) }} * 100 / 100);
		@else
			sysLoad.data('easyPieChart').update(0);
		@endif
		// 	sysLoad.find('.percent').text(randomVal);
		// }, updateInterval);

		// function getRandomInt(min, max) {
		// 	return Math.floor(Math.random() * (max - min + 1)) + min;
		// }

	});
</script>
@endsection