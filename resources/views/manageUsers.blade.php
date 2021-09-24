@extends('layouts.layout')

@section('title')
	User Management | Event Management System
@endsection

@section("navtitle")
    User Management
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
                    <div class="panel-heading"><h3>List of Event Assistants</h3></div>
                    <div class="table-responsive p-0">
                        <div class="col-md-12 offset-md-4">
                        @if($events->publish_status != "Published")
                            <a href="{{ route('addUsers',['id'=>$events->id]) }}" style="float:right;" class="btn btn-default">Add assistant</a>
                        @endif
                        </div>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px" style="text-align: center">
                                        No.
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Assistant Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Phone
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events->assistants as $assistant)
                                <tr>
                                    <td class="align-middle text-md" style="padding-left: 25px">
                                        <h6 class="mb-0" style="text-align: center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $assistant->username }}</p>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $assistant->email }}</p>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $assistant->phone }}</p>
                                    </td>
                                    @if($events->publish_status != "Published")
                                    <td class="align-middle text-center">
                                        <a href="{{ route('editUser', ['id' => $events->id, 'user_id' =>$assistant->id]) }}">
                                            <i class="lnr lnr-pencil btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                        </a>
                                        <a class="lnr lnr-trash btn-stock-action deleteAssistant" style="color: orange; font-size: 25px;" id="{{ $assistant->id }}" value="{{ $assistant->username }}" event="{{ $events->id  }}"></a>
                                    </td>
                                    @else
                                    <td class="align-middle text-center">
                                        <a href="{{ route('editUser', ['id' => $events->id, 'user_id' =>$assistant->id]) }}">
                                            <i class="lnr lnr-magnifier btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                    @endforeach
                                    @if (count($events->assistants) == 0)
                                        <tr>
                                            <td colspan="6" style="text-align: center;">No event assistants added!</td>
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
        $(document).on('click', '.deleteAssistant', function() {
		    var id = $(this).attr('id');
		    var name = $(this).attr('value');
            var event = $(this).attr('event');
            Swal.fire({
                title: 'Delete this assistant?',
                text: 'Assistant Name: ' + '"' + name + '"',
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
                        text: "Deleted the selected assistant: " + '"' + name + '"',
                        icon: 'success',
                        type: 'success',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "/manageUsers/deleteAssistant/" + id;
                    });
                }
		    });
        });
    </script>
@endsection