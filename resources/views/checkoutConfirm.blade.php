@extends('layouts.layout')

@section('title')
	Confirm Checkout | Event Management System
@endsection

@section("navtitle")
    Confirm Checkout
@endsection

@section('content')
<div class="event-content">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 style="text-align: center;">Confirm Checkout</h3>
                    </div>
                    <form method="POST" action="#">
                        @csrf
                        <div class="table-responsive p-0">
                            <div class="col-md-12 offset-md-4">
                            </div>
                            <table class="table align-items-center mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" id="name"><b>Ticket Details</b></h4>
                                        </td>
                                        <td>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" style="padding-left: 50px;"><b>Quantity Purchase</b></h4>
                                        </td>
                                    </tr>
                                    @foreach (Auth::user()->checkouts as $checkout)
                                    <tr>
                                        <td>
                                            <br>
                                            <p class="text-md text-dark font-weight-bold mb-0" id="name"><b>{{  $checkout->ticket->name }}</b></p>
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->ticket->type }}</p>
                                            <br>
                                        </td>
                                        <td>
                                            <br><br>
                                            <p class="text-md text-dark font-weight-bold mb-0">{{ $checkout->quantity }} &nbsp x &nbsp RM {{ number_format($checkout->ticket->price, 2) }} &nbsp per &nbsp ticket &nbsp = &nbsp RM {{ number_format($checkout->total_price, 2) }}</p>
                                            <br><br>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <br>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" 
                                                style="float: right; color: rgb(34, 34, 34); margin-right: 50px;"
                                                id="updateTotal" name="updateTotal"
                                                >
                                                Total: &nbsp RM 0.00
                                            </h4>
                                            <br>
                                        </td>
                                    </tr>    
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 style="text-align: center;">Proceed to Checkout</h3>
                    </div>
                    <h3 style="font-size: 20px; border-bottom: 1px solid rgb(231, 231, 231);"></h3><br>
                    @php
                        $totalPrice = 0.0;
                        foreach(Auth::user()->checkouts as $checkout)
                            $totalPrice = $totalPrice + $checkout->total_price;
                        //dd($totalPrice);
                    @endphp
                    @if(Auth::user()->credit_balance < $totalPrice)
                    <div class="panel-heading">
                        <p style="color:red; font-style: italic;">*  Your credit balance is not sufficient!</p>
                        <p style="color:red; font-style: italic;">&nbsp Please reload credit to confirm checkout!</p>
                    </div>
                    @endif
                    <form method="POST" action="#">
                        @csrf
                        <div class="panel-body">
                            <div class="col-md-12 offset-md-4">
                            </div>
                            @if(Auth::user()->credit_balance < $totalPrice)
                            {{-- Reload Amount --}}
                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right required">{{ __('Reload Amount (RM)') }}</label>
                                <div class="col-md-3"> 
                                    <input id="amount" type="text" name="amount"
                                    maxlength="4" min="5" max="1500" class="form-control"
                                    placeholder="Enter amount" 
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">   
                                    <p> 
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror  
                                    </p>         
                                </div>
                            </div>
                            {{-- Credit Card Number --}}
                            <div class="form-group row">
                                <label for="ccn" class="col-md-4 col-form-label text-md-right required">{{ __('Credit/Debit Card Number') }}</label>
                                <div class="col-md-3">
                                    <input id="ccn" type="text" class="creditCardText form-control" name="ccn"
                                    maxlength="19" size="19"
                                    placeholder="xxxx-xxxx-xxxx-xxxx" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">                            
                                    <p> 
                                        @error('ccn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror  
                                    </p>  
                                </div>
                            </div>
                            {{-- Expiry Date --}}
                            <div class="form-group row">
                                <label for="expiryDate" class="col-md-4 col-form-label text-md-right required">{{ __('Expiry Date') }}</label>
                                <div class="col-md-5">
                                    <div class="exp-wrapper">
                                        <input autocomplete="off" class="exp" id="month" name="month" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="MM" type="text" data-pattern-validate />
                                        <input autocomplete="off" class="exp" id="year" name="year" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="YY" type="text" data-pattern-validate />
                                    </div>
                                    <p> 
                                        @error('month')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror  
                                    </p>  
                                    <p> 
                                        @error('year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror  
                                    </p>  
                                </div>
                            </div>
                            {{-- CVV/CVC --}}
                            <div class="form-group row">
                                <label for="ccn" class="col-md-4 col-form-label text-md-right required">{{ __('CVV/CVC') }}</label>
                                <div class="col-md-1">
                                    <input id="cvv" type="text" name="cvv" class="form-control"
                                    pattern="[0-9]{3}" maxlength="3" size="3"
                                    placeholder="---" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">                            
                                    <p> 
                                        @error('cvv')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror  
                                    </p> 
                                </div>
                            </div>
                            <h3 style="font-size: 20px; border-bottom: 1px solid rgb(231, 231, 231);"></h3><br>
                            @endif
                            <div class="col-md-12 offset-md-4">
                                <button type="submit" class="button btn btn-default" value="Submit" style="float: left; margin-bottom: 20px;">
                                    Cancel checkout
                                </button>
                                <button type="submit" class="button btn btn-default" value="Submit" style="float: right; margin-bottom: 20px;">
                                    Confirm checkout
                                </button>
                                <br>
                            </div>
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
    var updateTotal = document.getElementById('updateTotal');
    var subPrice = new Array();

    @foreach (Auth::user()->checkouts as $checkout)
        
        subPrice[{{ $loop->iteration }}] = {{ $checkout->total_price }};

        var allPrices = subPrice[{{ $loop->iteration }}];
    @endforeach

    var totalPrice = 0.0;
    for (let index = 1; index < subPrice.length; index++) {
        if(subPrice[index] > 0){
            const element = subPrice[index];
            totalPrice += element;
        }
    }

    updateTotal.innerHTML = "Total: &nbsp RM " + Number(totalPrice).toFixed(2);

</script>
@endsection