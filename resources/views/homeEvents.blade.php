@foreach ($events as $event)
@if($event->publish_status=="Published")
<div class="col-md-4" style="margin-bottom: 20px;">
    <div class="card" id="{{ 'homeEvents' . $event->id}}">
        <div class="card-body text-left" style="padding: 0.85rem;">
            <img style="height: 200px; width:100%;" class="img-fluid"
                src="data:image/png;base64,{{ chunk_split(base64_encode($event->cover_image)) }}">
            <div style="height: 0.35rem;"></div>
            <div>
                <h4 class="m-0">
                    <a href="{{ route('viewEvents', ['id' => $event->id]) }}" style="color: rgb(48, 48, 48); font-weight: bold;">{{ $event->title }}</a>
                </h4>
                <label class="ms-0" style="margin-left: 0; color:rgb(255, 171, 15);">{{ date('d/m/Y', strtotime($event->start_date)) }}, {{ date('H:i A', strtotime($event->start_time)) }}</label><br>
                <label class="ms-0" style="margin-left: 0; color:rgb(255, 169, 71);">{{ $event->type }}</label><br>
                <label class="ms-0" style="margin-left: 0; color:rgb(132, 132, 132);">{{ $event->tags }}</label><br>
                <label class="ms-0" style="margin-left: 0; color:rgb(255, 169, 71);">{{ $event->event_status }}</label><br>
                <label class="ms-0" style="margin-left: 0; color:rgb(132, 132, 132);">Available Slots: {{ $event->remaining_num_of_participant }}/{{ $event->num_of_participant }}</label><br>
                <label class="ms-0" style="margin-left: 0; color:rgb(15, 15, 15);">{{ $event->createdBy->username }}</label>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach