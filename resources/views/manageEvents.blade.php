@extends('layouts.layout')

@section('title')
	Home | Event Management System
@endsection

@section("navtitle")
    Manage Events
@endsection

@section('content')
<div class="event-content">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading"><h3>List of Events</h3></div>
                    <div class="table-responsive p-0">
                        <div class="col-md-12 offset-md-4">
                            <a href="{{ route('createEvent') }}" style="float:right;" class="btn btn-default">Create new event</a>
                        </div>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px" style="text-align: center">
                                        No.
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Event Title
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                    <td class="align-middle text-md" style="padding-left: 25px">
                                        <h6 class="mb-0" style="text-align: center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $event->title }}</p>
                                    </td>
                                    <td>
                                        <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $event->publish_status }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('eventDetails', ['id' => $event->id]) }}">
                                            <i class="lnr lnr-pencil btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                        </a>
                                        <a class="lnr lnr-trash btn-stock-action deleteEvent" style="color: orange; font-size: 25px;" id="{{ $event->id }}" value="{{ $event->title }}"></a>
                                        
                                    </td>
                                </tr>
                                    @endforeach
                                    @if (count($events) == 0)
                                        <tr>
                                            <td colspan="6" style="text-align: center;">No events created</td>
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
        $(document).on('click', '.deleteEvent', function() {
		    var id = $(this).attr('id');
		    var title = $(this).attr('value');
            Swal.fire({
                title: 'Delete Event?',
                text: 'Event Title: ' + '"' + title + '"',
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
                        text: "Deleted event: " + '"' + title + '"',
                        icon: 'success',
                        type: 'success',
                        customClass: 'swal-wide',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "/manageEvents/" + id;
                    });
                }
		    });
        });
    </script>
@endsection