@extends('layouts.layout')

@section('title')
	Checkout | Event Management System
@endsection

@section("navtitle")
    Checkout
@endsection

@section('content')
<div class="event-content">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 style="text-align: center;">Checkout</h3>
                        <h4 style="text-align: center;">{{ $events->title }}</h4>
                    </div>
                    <form method="POST" action="{{ route('checkout',['id'=>$events->id]) }}">
                        @csrf
                        <div class="table-responsive p-0">
                            <div class="col-md-12 offset-md-4">
                            </div>
                            <h3 style="font-size: 20px; border-bottom: 1px solid rgb(231, 231, 231);"></h3><br>
                            <section>
                                <article>
                                    <table class="table align-items-center mb-0">
                                        <tbody>
                                            @foreach ($events->tickets as $ticket)
                                            <tr>
                                                <td>
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{  $ticket->type }}</p>
                                                    @if($ticket->price == 0)
                                                    <p class="text-md text-dark font-weight-bold mb-0" id="price">Free</p>
                                                    @else
                                                    <p class="text-md text-dark font-weight-bold mb-0" id="price">RM {{ number_format($ticket->price, 2) }}</p>
                                                    @endif

                                                    @if($ticket->quantity_left == 1)
                                                    <p class="text-md text-dark font-weight-bold mb-0" id="price">Quantity left: &nbsp{{ $ticket->quantity_left }} ticket</p>
                                                    @elseif($ticket->quantity_left > 1)
                                                    <p class="text-md text-dark font-weight-bold mb-0" id="price">Quantity left: &nbsp{{ $ticket->quantity_left }} tickets</p>
                                                    @else
                                                    <p class="text-md text-dark font-weight-bold mb-0" id="price">Quantity left: &nbsp{{ $ticket->quantity_left }} ticket</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ticket->quantity_left > 0)
                                                    <br><br>
                                                    <input type="hidden" name="ticketID[]" value={{ $ticket->id }}>
                                                    <input type="hidden" name="price[]" value={{ $ticket->price }}>
                                                    <input type="number" style="margin-right: -50px; margin-left: -50px;"
                                                        class="input form-control" name="quantity[]" id="quantity{{ $ticket->id }}" 
                                                        onKeyPress="if(this.value.length==4) return false;" max="{{ $ticket->quantity_left }}" onkeyup="update()">
                                                    <br><br>
                                                    @else
                                                    <br><br>
                                                    <input type="number" style="margin-right: -50px; margin-left: -50px;"
                                                        class="input form-control" placeholder=" Not Available to Purchase" readonly>
                                                    <br><br>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </article>
                                <aside style="background-color:rgb(231, 231, 231);">
                                    <h4 style="color: rgb(34, 34, 34); text-align: center;">Order Summary</h4><br>
                                    @foreach ($events->tickets as $ticket)
                                        <p style="color: rgb(34, 34, 34);" id="showDetail{{ $ticket->id }}" name="showDetail"></p><br>
                                        @endforeach
                                        <h4 style="color: rgb(34, 34, 34);" id="updatePrice" name="updatePrice" >Total: RM 0.00</h4>
                                </aside>
                                <div class="col-md-12 offset-md-4">
                                    <br>
                                    <button type="submit" class="button btn btn-primary" value="Submit">
                                        Register
                                    </button>
                                    <br>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function update() {

        var subPrice = new Array();
        @foreach ($events->tickets as $ticket)
            var quantity = document.getElementById('quantity' + {{ $ticket->id }}).value;
            // dd($ticket->id);
            if(quantity != ''){
                console.log(quantity);

                subPrice[{{ $loop->iteration }}] = quantity * {{ $ticket->price }};

                var subprice1 = subPrice[{{ $loop->iteration }}];

                var showDetail = document.getElementById('showDetail' + {{ $ticket->id }});
                showDetail.innerHTML ="<div style='overflow: hidden;'>"
                + "<p style='text-align: left; float: left;'>" + quantity + " x " + "{{ $ticket->type }}" +"</p>"
                + "<p style='text-align: right; float: right;'>RM " + Number(subprice1).toFixed(2) + "</p>"
                + "</div>";
                // showDetail.innerHTML = quantity + " x " + "{{ $ticket->name }}" + " = " + subprice1;
            }
            else{
                var showDetail = document.getElementById('showDetail' + {{ $ticket->id }});
                showDetail.innerHTML = '';
            }
            //3 x Ticket 1    RM 3.00
        @endforeach
        
        var totalPrice = 0.0;
        for (let index = 1; index < subPrice.length; index++) {
            if(subPrice[index] > 0){
                const element = subPrice[index];
                totalPrice += element;
            }
        }
        document.getElementById('updatePrice').innerHTML = "Total: RM " + Number(totalPrice).toFixed(2);
    }
   
    function stateHandle(){
        let any = $("input[name='quantity[]'").toArray().some(value => value.value != "");
        button.disabled = !any;
        console.log(any);
    }
    var button = document.querySelector(".button");
    var input = document.querySelector("input[name='quantity[]']");
    $("input[name='quantity[]']").on("change", stateHandle);
    stateHandle();
    
</script>
@endsection