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
                <form action="{{ route('homeSearch3') }}" method="post">
                    @csrf
                    <input type="search" class="form-control" name="homeSearch" id="homeSearchInput"
                    placeholder="Search for events by title, date, time, type, tags, category, organizer....">
                </form>
            </div>
            <div class="row" id="#" style="margin-top: 40px">
                <nav>
                    <ul class="nav justify-content-center">
                        <li class="nav-item col-md-4">
                        <a class="nav-link" href="home" style="color: rgb(248, 142, 35); text-align:center;">All Events</a>
                        </li>
                        <li class="nav-item col-md-4">
                        <a class="nav-link " href="homeOngoing" style="color: rgb(248, 142, 35); text-align:center;">Ongoing Events</a>
                        </li>
                        <li class="nav-item active col-md-4">
                        <a class="nav-link active" href="homePast" style="color: rgb(248, 142, 35); text-align:center;">Past Events</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="row" id="homeRow" style="margin-top: 40px">
                @include('homeEvents3')
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