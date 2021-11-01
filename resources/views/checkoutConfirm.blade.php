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
        <form method="POST" action="{{ route('checkoutConfirm',['id'=>$events->id]) }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 style="text-align: center;">Confirm Checkout</h3>
                        </div>
                        <div class="table-responsive p-0">
                            <div class="col-md-12 offset-md-4">
                            </div>
                            <table class="table align-items-center mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" id="name" style="padding-left: 25px;">Ticket Details</h4>
                                        </td>
                                        <td>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" style="text-align: center;">Quantity Purchase</h4>
                                        </td>
                                        <td>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" style="text-align: center;">Subtotal (RM)</h4>
                                        </td>
                                    </tr>
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @foreach (session("tickets") as $ticket)
                                    @php
                                        $totalPrice += $ticket->get("quantity") * $ticket->get("ticket")->price;
                                    @endphp
                                    <tr>
                                        <input type="hidden" name="ticketID[]" value={{ $ticket->get("ticket")->id }}>
                                        <input type="hidden" name="quantity[]" value={{ $ticket->get("quantity") }}>
                                        <td>
                                            <br>
                                            <p class="text-md text-dark font-weight-bold mb-0" id="name" style="padding-left: 20px;"><b>{{  $ticket->get("ticket")->event->title }}</b></p>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="padding-left: 20px;">{{  $ticket->get("ticket")->type }}</p>
                                            <br>
                                        </td>
                                        <td>
                                            <br><br>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center;">{{ $ticket->get("quantity") }} &nbsp x &nbsp RM {{ number_format($ticket->get("ticket")->price, 2) }} &nbsp per &nbsp ticket</p>
                                            <br><br>
                                        </td>
                                        <td>
                                            <br><br>
                                            <p class="text-md text-dark font-weight-bold mb-0" style="text-align: center;">RM {{ number_format($ticket->get("quantity") * $ticket->get("ticket")->price, 2) }}</p>
                                            <br><br>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <br>
                                            <h4 class="text-md text-dark font-weight-bold mb-0" 
                                                style="float: right; color: rgb(34, 34, 34); margin-right: 80px;"
                                                id="updateTotal" name="updateTotal"
                                                >
                                                Total: &nbsp RM {{ number_format($totalPrice, 2) }}
                                            </h4>
                                            <br>
                                        </td>
                                    </tr>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 style="text-align: center;">Proceed to Checkout</h3>
                        </div>
                        <h3 style="font-size: 20px; border-bottom: 1px solid rgb(231, 231, 231);"></h3><br>
                        @if(Auth::user()->credit_balance < $totalPrice)
                        <div class="panel-heading">
                            <p style="color:red; font-style: italic;">*  Your credit balance is not sufficient!</p>
                            <p style="color:red; font-style: italic;">&nbsp Please reload credit to confirm checkout!</p>
                        </div>
                        @endif
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
                                    placeholder="Enter amount"  value="{{ old('amount', $totalPrice) }}"
                                    oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    @if(Auth::user()->credit_balance < $totalPrice) required @endif
                                    >   
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
                                    placeholder="xxxx-xxxx-xxxx-xxxx" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    @if(Auth::user()->credit_balance < $totalPrice) required @endif
                                    >                            
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
                                        <input autocomplete="off" class="exp" id="month" name="month" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="MM" type="text" data-pattern-validate @if(Auth::user()->credit_balance < $totalPrice) required @endif/>
                                        <input autocomplete="off" class="exp" id="year" name="year" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="YY" type="text" data-pattern-validate @if(Auth::user()->credit_balance < $totalPrice) required @endif/>
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
                                <div class="col-md-2">
                                    <input id="cvv" type="text" name="cvv" class="form-control"
                                    pattern="[0-9]{3}" maxlength="3" size="3" 
                                    placeholder="---" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    @if(Auth::user()->credit_balance < $totalPrice) required @endif
                                    >                            
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
                                <button type="submit" name="action" class="button btn btn-default" value="cancel" style="float: left; margin-bottom: 20px;">
                                    Cancel checkout
                                </button>
                                <button type="submit" name="action" class="button btn btn-default" value="confirm" style="float: right; margin-bottom: 20px;">
                                    Confirm checkout
                                </button>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.creditCardText').keyup(function() {
        var cardNumber = $(this).val().split("-").join(""); // remove hyphens
        if (cardNumber.length > 0) {
            cardNumber = cardNumber.match(new RegExp('.{1,4}', 'g')).join("-");
        }
        $(this).val(cardNumber);
      });
    </script>
    <script>
        const month = document.querySelector('#month');
        const year = document.querySelector('#year');
        
        const focusSibling = function(target, direction, callback) {
        const nextTarget = target[direction];
        nextTarget && nextTarget.focus();
        // if callback is supplied we return the sibling target which has focus
        callback && callback(nextTarget);
        }
        
        // input event only fires if there is space in the input for entry. 
        // If an input of x length has x characters, keyboard press will not fire this input event.
        month.addEventListener('input', (event) => {
        
        const value = event.target.value.toString();
        // adds 0 to month user input like 9 -> 09
        if (value.length === 1 && value > 1) {
            event.target.value = "0" + value;
        }
        // bounds
        if (value === "00") {
            event.target.value = "01";
        } else if (value > 12) {
            event.target.value = "12";
        }
        // if we have a filled input we jump to the year input
        2 <= event.target.value.length && focusSibling(event.target, "nextElementSibling");
        event.stopImmediatePropagation();
        });
        
        year.addEventListener('keydown', (event) => {
        // if the year is empty jump to the month input
        if (event.key === "Backspace" && event.target.selectionStart === 0) {
            focusSibling(event.target, "previousElementSibling");
            event.stopImmediatePropagation();
        }
        });
        
    const inputMatchesPattern = function(e) {
      const { 
        value, 
        selectionStart, 
        selectionEnd, 
        pattern 
      } = e.target;
      
      const character = String.fromCharCode(e.which);
      const proposedEntry = value.slice(0, selectionStart) + character + value.slice(selectionEnd);
      const match = proposedEntry.match(pattern);
      
      return e.metaKey || // cmd/ctrl
        e.which <= 0 || // arrow keys
        e.which == 8 || // delete key
        match && match["0"] === match.input; // pattern regex isMatch - workaround for passing [0-9]* into RegExp
    };
    
    document.querySelectorAll('input[data-pattern-validate]').forEach(characters => characters.addEventListener('keypress', e => {
      if (!inputMatchesPattern(e)) {
        return e.preventDefault();
      }
    }));
</script>
@endsection