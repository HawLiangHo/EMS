@extends('layouts.layout')

@section('title')
	Event Details | Event Management System
@endsection

@section("navtitle")
    Event Details
@endsection

@section('content')
<div class="event-content-details">
    <img style="height: 500px; width:100%; padding: 0.85rem;" class="img-fluid"
                src="data:image/png;base64,{{ chunk_split(base64_encode($events->cover_image)) }}">
    <div class="panel-heading">
        <h2 style="color: rgb(34, 34, 34)">{{ $events->title}}
        @if($events->event_status == "Open" && $events->created_by != Auth::id() && $events->remaining_num_of_participant != 0)
            <a href="{{ route('checkout', ['id' => $events->id]) }}" style="float:right; font-size: 20px" class="btn btn-default">Register</a>
        @endif
        </h2>
    </div>
    <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B"></h3><br>
    <section>
        <aside>
            <h3 style="color: rgb(255, 255, 255)">Type of Event</h3><br>
            <p style="color: rgb(255, 255, 255)">{{ $events->type }}</p>
            <br>
            <h3 style="color: rgb(255, 255, 255)">Date and Time</h3><br>
            <p style="color: rgb(255, 255, 255)">Date: {{ $events->start_date }} - {{ $events->end_date }},</p>
            <p style="color: rgb(255, 255, 255)">Time: {{ $events->start_time }} - {{ $events->end_time }}</p>
            <br>
            <h3 style="color: rgb(255, 255, 255)">Location</h3><br>
            <p style="color: rgb(255, 255, 255)">Venue: {{ $events->venue_name }}</p>
            @if($events->venue_address != "")
                <p style="color: rgb(255, 255, 255)">Address: {{ $events->venue_address }}</p>
            @endif
            <br>
            <h3 style="color: rgb(255, 255, 255)">Registration Details</h3><br>
            <p style="color: rgb(255, 255, 255)">Registration Date: {{ $events->registration_start_date }} - {{ $events->registration_end_date }}</p>
            <p style="color: rgb(255, 255, 255)">Number of Participants: {{ $events->num_of_participant }}</p>
            <br>
        </aside>
        <article>
            <h3 style="color: rgb(34, 34, 34)">Tags</h3><br>
            <p style="color: rgb(34, 34, 34)">{{ $events->tags }}</p>
            <br>
            <h3 style="color: rgb(34, 34, 34)">Description</h3><br>
            <p class="word-wrap" style="color: rgb(34, 34, 34)">{{ $events->description }}</p>
        </article>
    </section>
    {{-- <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B"></h3><br>
    <div class="panel panel-headline">
        <iframe id="description_address" width="100%" height="500" 
            src="https://maps.google.com/maps?q={{ $events->venue_name }}&output=embed"></iframe>
    </div> --}}
</div>
@endsection