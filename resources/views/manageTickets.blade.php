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
                    <div class="panel-heading">
                        <h3>List of Tickets</h3>
                        @if($events->num_of_participant <= 0)
                            <p style="color:red; font-style: italic;">* Please complete event details in order to proceed</p>
                        @endif
                    </div>
                    <div class="table-responsive p-0">
                        <div class="col-md-12 offset-md-4">
                        @if($events->publish_status != "Published" && $ticketCount < $events->num_of_participant )
                            <a href="{{ route('addTickets',['id'=>$events->id]) }}" style="float:right;" class="btn btn-default">Add ticket</a>
                        @endif
                        </div>
                        {{-- dd({{ $ticketCount }}) --}}
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px" style="text-align: center">
                                        No.
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Ticket Type
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
                                @foreach ($events->tickets as $ticket)
                                <tr>
                                    <td class="align-middle text-md" style="padding-left: 25px">
                                        <h6 class="mb-0" style="text-align: center">{{ $loop->iteration }}</h6>
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
                                        @if ($events->publish_status != "Published")
                                        <a href="{{ route('editTicket', ['id' => $events->id, 'ticket_id' =>$ticket->id]) }}">
                                            <i class="lnr lnr-pencil btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                        </a>
                                        <a class="lnr lnr-trash btn-stock-action deleteTicket" style="color: orange; font-size: 25px;" id="{{ $ticket->id }}" value="{{ $ticket->type }}"></a>
                                        @else
                                        <a href="{{ route('editTicket', ['id' => $events->id, 'ticket_id' =>$ticket->id]) }}">
                                            <i class="lnr lnr-eye btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                    @endforeach
                                    @if (count($events->tickets) == 0)
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

@section('script')
    <script>
        $(document).on('click', '.deleteTicket', function() {
		    var id = $(this).attr('id');
		    var name = $(this).attr('value');
            Swal.fire({
                title: 'Delete this ticket?',
                text: 'Ticket Name: ' + '"' + name + '"',
                icon: 'warning',
                customClass: 'swal-wide',
                showCancelButton: true,
                cancelButtonColor: '#F00',
                confirmButtonColor: '#00F',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Deleted the selected ticket: " + '"' + name + '"',
                        icon: 'success',
                        type: 'success',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "/manageTickets/deleteTicket/{{ $events->id }}/" + id;
                    });
                }
		    });
        });
    </script>
@endsection