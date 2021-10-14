@component('mail::message')
Dear {{ $user->username }},
<br>

<h2>Your registered event, "{{ $event->title }}" is coming up soon!</h2>
<br>

<h3><u>About this event:</u></h3>
Date: {{ date('d/m/Y', strtotime($event->start_date)) }} at {{ date('H:i A', strtotime($event->start_time)) }} - {{ date('d/m/Y', strtotime($event->end_date)) }} at {{ date('H:i A', strtotime($event->start_time)) }}<br>
Venue: {{ $event->venue_name }}<br>
@if($event->venue_address != "")
Venue Address: {{ $event->venue_address }}<br>    
@endif
Organized by {{ $event->username }}<br>
<br><br>
<br><br>

<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
