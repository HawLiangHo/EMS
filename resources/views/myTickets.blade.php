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
                                    @foreach (Auth::user()->checkouts as $checkout)
                                    @if ($checkout->paid_status == "Paid")
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
                                            <a href="#">
                                                <i class="lnr lnr-magnifier btn-stock-action" style="color: orange; font-size: 25px;"></i>
                                            </a>
                                            <a class="lnr lnr-trash btn-stock-action deleteEvent" style="color: orange; font-size: 25px;" id="{{ $checkout->id }}" value="{{ $checkout->ticket->name }}"></a>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding-left: 100px; padding-top: 30px;">You have yet to fully register any events!</td>
                                    </tr>
                                    @endif
                                    @endforeach                                  
                                   
                                    @if (count(Auth::user()->checkouts) == 0)
                                        <tr>
                                            <td colspan="6" style="text-align: center; padding-left: 100px; padding-top: 30px;">You have yet to register any events!</td>
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
</div>
@endsection
