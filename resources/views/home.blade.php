@extends('layouts.layout')

@section('title')
	Home | Event Management System
@endsection

@section("navtitle")
    Home
@endsection

@section('content')
<div class="event-content-home">
    <div class="container">
	<div class="container-fluid" style="margin-bottom: 30px; margin-left: -100px; margin-right: 200px; margin-top: 30px">
		<div>
            <form action="{{ route('homeSearch') }}" method="post">
                <input type="search" class="form-control" name="homeSearch" id="homeSearchInput"
                    placeholder="Search for events...">
            </form>
        </div>

		<div class="row" id="homeRow" style="margin-top: 40px">
			@include('homeEvents')
		</div>
	</div>
</div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        $('#homeSearchInput').on('input', function() {
            var searchKeyword = this.value;
            $.ajax({
                type: "POST",
                dataType: "text",
                url: "{{ route('homeSearch') }}",
                data: {
                    "homeSearch": searchKeyword,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(searchKeyword);
                    $('#homeRow').html(data);
                }
            });
        });
    </script>
@endsection