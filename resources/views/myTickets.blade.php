@extends('layouts.layout')

@section('title')
	My Tickets | Event Management System
@endsection

@section("navtitle")
    My Tickets
@endsection

@section('content')
<div class="event-content-myTickets">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 style="text-align: center;">Tickets</h3>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px" style="text-align: center">
                                            No.
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="200px" style="text-align: center">
                                            Event Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                            Ticket Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                            Ticket Type
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                            Purchased Quantity
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" style="text-align: center">
                                            Total Price (RM)
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse (Auth::user()->checkouts as $checkout)
                                    <tr>
                                        <td class="align-middle text-md" style="padding-left: 25px">
                                            <h6 class="mb-0" style="text-align: center">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $checkout->ticket->event->title }}</p>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $checkout->ticket->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $checkout->ticket->type }}</p>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">{{  $checkout->quantity }}</p>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center">RM {{  number_format($checkout->total_price, 2) }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{-- <a class="lnr lnr-eye btn-stock-action" onclick="showTicket('{{  $checkout->ticket->event->title }}','{{ $checkout->ticket->name }}','{{  $checkout->ticket->type }}','{{  $checkout->quantity }}','{{  $checkout->ticket->link}}')" style="color: orange; font-size: 25px;"></a> --}}
                                            <a href="{{ route('viewMyTicket', ['id' => $checkout->id]) }}">    
                                                <i class="lnr lnr-eye btn-stock-action" style="color: orange; font-size: 25px;"></i>                                                    
                                            </a>
                                            <a class="lnr lnr-trash btn-stock-action deleteRegisteredTicket" style="color: orange; font-size: 25px;" id="{{ $checkout->id }}" value="{{ $checkout->ticket->name }}"></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding-left: 100px; padding-top: 30px;">You have yet to register any events!</td>
                                    </tr>
                                    @endforelse                                  
                                </tbody>
                            </table>
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
    $(document).on('click', '.deleteRegisteredTicket', function() {
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
                        window.location.href = "/myTickets/deleteRegisteredTicket/" + id;
                    });
                }
		    });
        });
</script>
@endsection
