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
                    
                    <div class="table-responsive p-0">
                        <div class="col-md-12 offset-md-4">
                        </div>
                        <h3 style="font-size: 20px; border-bottom: 1px solid rgb(231, 231, 231);"></h3><br>
                        <section>
                            <article>
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>
                                                <p class="text-md text-dark font-weight-bold mb-0" id="name"><b>{{  $ticket->name }}</b></p>
                                                <p class="text-md text-dark font-weight-bold mb-0">{{  $ticket->type }}</p>
                                                @if($ticket->price == 0)
                                                <p class="text-md text-dark font-weight-bold mb-0" id="price">Free</p>
                                                @else
                                                <p class="text-md text-dark font-weight-bold mb-0" id="price">RM {{ number_format($ticket->price, 2) }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <br><br>
                                                {{-- <select id="quantity" name="quantity" class="form-control" onChange="update('{{ $ticket->name }}', {{ $ticket->price }})">
                                                    @for($i=0; $i<=$ticket->quantity_left; $i++)
                                                        <option value=@if($i==0){{ $i }} disabled selected @else {{ $i }} @endif>
                                                            @if($i==0) Select your ticket @else {{ $i }} @endif
                                                        </option>
                                                    @endfor
                                                </select> --}}
                                                <input type="number" id="quantity{{ $ticket->id }}" max="{{ $ticket->quantity_left }}" onkeyup="update('{{ $ticket->name }}', {{ $ticket->price }})">
                                                <br><br>
                                                {{-- <input type="text" id="value"> --}}
                                            <td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </article>
                            <aside style="background-color:rgb(231, 231, 231);">
                                <h4 style="color: rgb(34, 34, 34); text-align: center;">Order Summary</h4><br>
                                @foreach ($tickets as $ticket)
                                    <p style="color: rgb(34, 34, 34);" id="showDetail{{ $ticket->id }}" name="showDetail"></p><br>
                                    @endforeach
                                    <h4 style="color: rgb(34, 34, 34);" id="updatePrice" name="updatePrice" >Total: RM 0.00</h4>
                            </aside>
                            <div class="col-md-12 offset-md-4"><br>
                                <button type="submit" class="btn btn-primary" value="Submit" >
                                    Register
                                </button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function update(name,price) {
        // var name = document.getElementById('name');
        // var name = $(this).attr("ticket-name");
        console.log(name);

        var subPrice = new Array();
        @foreach ($tickets as $ticket)
            var quantity = document.getElementById('quantity' + {{ $ticket->id }}).value;
            if(quantity != ''){
                console.log(quantity);

                subPrice[{{ $loop->iteration }}] = quantity * {{ $ticket->price }};

                var subprice1 = subPrice[{{ $loop->iteration }}];

                var showDetail = document.getElementById('showDetail' + {{ $ticket->id }});
                showDetail.innerHTML = quantity + " x " + "{{ $ticket->name }}" + " = " + subprice1;
            }
            else{
                var showDetail = document.getElementById('showDetail' + {{ $ticket->id }});
                showDetail.innerHTML = '';
            }
            //3 x Ticket 1    RM 3.00
        @endforeach
        
        var totalPrice = 0.0;
        for (let index = 1; index < subPrice.length; index++) {
            const element = subPrice[index];
            totalPrice += element;
        }
        document.getElementById('updatePrice').innerHTML = "Total: RM " + totalPrice;

        /*document.getElementById('showDetail').innerHTML += "<div style='overflow: hidden;'>"
        + "<p style='text-align: left; float: left;'>" + option.value + " x " + name +"</p>"
        + "<p style='text-align: right; float: right;'>RM " + subPrice + "</p>"
        + "</div>";  

        var totalPrice = 0;
        totalPrice = subPrice + totalPrice;  

        document.getElementById('updatePrice').innerHTML = 
        "<h4 style='text-align: left; float: left;'>" + "Total: RM " + totalPrice +"</h4>";*/
        //var option = quantity.options[quantity.selectedIndex];


        // var parElement = document.getElementById("showDetail");
        // var textToAdd = document.createTextNode("<p>" + option.value + " x " + name + "RM " + price + "</p><br>");
        // parElement.appendCd(textToAdd);

        // document.getElementById('value').value = option.value;

       
    }

    // update();


</script>
@endsection