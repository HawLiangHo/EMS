@extends('layouts.layout')

@section("title")
	Reload Credits | Event Management System
@endsection

@section("navtitle")
    Reload Credits
@endsection

@section('content')
<div class="profile-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading"><p style="color:red; font-style:italic;">* Transactions made will not be refund!</p></div>
                    <div class="panel-body">
                        @if (session('message'))
                        <div class="text-danger row mb-3 col-sm-6 offset-sm-3">{{ session('message') }}</div><br>
                        @endif  
                        <form method="POST" action="{{ route('reloadCredit') }}" enctype="multipart/form-data">
                            @csrf
                        {{-- Reload Amount --}}
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right required">{{ __('Reload Amount (RM)') }}</label>
                            <div class="col-md-3"> 
                                <input id="amount" type="text" name="amount"
                                maxlength="4" min="1" max="1500" class="form-control"
                                placeholder="Enter amount" 
                                oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">   
                                <p> 
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror  
                                </p>         
                            </div>
                        </div>
                        {{-- Credit Card Number --}}
                        <div class="form-group row">
                            <label for="credit_card_number" class="col-md-4 col-form-label text-md-right required">{{ __('Credit/Debit Card Number') }}</label>
                            <div class="col-md-3">
                                <input id="credit_card_number" type="text" class="creditCardText form-control" name="credit_card_number"
                                 maxlength="19" size="19"
                                placeholder="xxxx-xxxx-xxxx-xxxx" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">                            
                                <p> 
                                    @error('credit_card_number')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
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
                                        {{ $message }}
                                    </span>
                                    @enderror  
                                </p>  
                                <p> 
                                    @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
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
                                placeholder="---" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">                            
                                <p> 
                                    @error('cvv')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror  
                                </p> 
                            </div>
                        </div>
                        {{-- Submit button --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-4"><br>
                                <button type="submit" class="btn btn-primary" value="Submit">{{ __('Reload Credit') }}</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        match && match["0"] === match.input; // pattern regex isMatch
    };

    document.querySelectorAll('input[data-pattern-validate]').forEach(characters => characters.addEventListener('keypress', e => {
    if (!inputMatchesPattern(e)) {
        return e.preventDefault();
    }
    }));
</script>
@endsection