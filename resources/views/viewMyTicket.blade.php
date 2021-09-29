@extends('layouts.layout')

@section('title')
	View Ticket | Event Management System
@endsection

@section("navtitle")
    View Ticket
@endsection

@section('content')
<div class="event-content-myTickets">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 style="text-align: center; padding-left: 20px;">Ticket Details</h3>
                        <div class="table-responsive p-0 print-container">
                            <br><br>
                            <table class="table align-items-center mb-0" style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95; border: 1px rgb(101, 101, 101) solid; width: 100%; margin-left: auto; margin-right: auto;">
                                <tbody>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                            <h2 class="mb-0" style="text-align: center">{{ QrCode::generate($checkout->ticket->link) }}</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                            <h2 class="mb-0" style="text-align: center">Event Registered:<br><br>{{ $checkout->ticket->event->title }}</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                            <h3 class="mb-0" style="text-align: center"><br>{{ $checkout->ticket->name }}</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                            <h4 class="mb-0" style="text-align: center"><br>{{ $checkout->ticket->type }}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                            <h4 class="mb-0" style="text-align: center">Ticket Purchased Quantity: {{ $checkout->quantity }}</h4>
                                            <br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-md" style="border: 0;" >
                                            <p style="font-style: italic; text-align: center;">Registered from © Web-based Event Management System<br>"For the Event Organizer"</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12 offset-md-4" >
                            <button class="btn btn-default" onclick="download()" style="margin-left: 400px;">
                                {{ __('Download Ticket') }}
                            </button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function download() {
       window.print();
    }
</script>
@endsection
