@extends('layouts.layout')

@section('title')
	Manage Tickets | Event Management System
@endsection

@section("navtitle")
    Manage Tickets
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
                    <div class="panel-heading"><h3>List of Tickets</h3></div>
                    <div class="table-responsive p-0">
                        <div class="col-md-12 offset-md-4">
                            <a href="{{ route('addTickets',['id'=>$events->id]) }}" style="float:right;" class="btn btn-default">Add ticket</a>
                        </div>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px" style="text-align: center">
                                        No.
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Tickets Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Type
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Quantity
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Price (RM)
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td class="align-middle text-md" style="padding-left: 25px">
                                        <h6 class="mb-0" style="text-align: center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $ticket->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $ticket->type }}</p>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $ticket->quantity_left }}/{{  $ticket->quantity }}</p>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">
                                            @if($ticket->price == 0)
                                                Free
                                            @else
                                                RM {{ number_format($ticket->price, 2) }}
                                            @endif
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('editTicket', ['id' => $events->id, 'ticket_id' =>$ticket->id]) }}">
                                            <i class="lnr lnr-pencil btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                        </a>
                                        <a class="lnr lnr-trash btn-stock-action deleteEvent" style="color: orange; font-size: 25px;" id="{{ $ticket->id }}" value="{{ $ticket->name }}"></a>
                                        
                                    </td>
                                </tr>
                                    @endforeach
                                    @if (count($tickets) == 0)
                                        <tr>
                                            <td colspan="6" style="text-align: center;">No tickets created!</td>
                                        </tr>
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection