@extends('layouts.layout')

@section('title')
	Details | Event Management System
@endsection

@section("navtitle")
    Details
@endsection

@section("sidebar")
<!-- LEFT SIDEBAR -->
	@auth
	@if (Auth::user()->isAdmin())
	<div id="sidebar-nav" class="sidebar">
		<div class="sidebar-scroll">
			<nav>
				<ul class="nav">
                    <li><a href="{{ route('eventDetails', ['id' => $events->id]) }}" class="active"><i class="lnr lnr-home"></i> <span>Details</span></a></li>
					<li><a href="{{ route('manageTickets', ['id' => $events->id]) }}" class=""><i class="lnr lnr-tag"></i> <span>Ticketing</span></a></li>
					<li><a href="{{ route('manageUsers', ['id' => $events->id]) }}" class=""><i class="lnr lnr-users"></i> <span>User Management</span></a></li>
					<li><a href="{{ route('dashboard', ['id' => $events->id]) }}" class=""><i class="lnr lnr-chart-bars"></i> <span>Dashboard</span></a></li>
                    <li><a href="{{ route('publishEvent', ['id' => $events->id]) }}" class=""><i class="lnr lnr-file-add"></i> <span>Publish</span></a></li>
                </ul>
			</nav>
		</div>
	</div>
	<!-- END LEFT SIDEBAR -->
	@endif
	@endauth
@endsection

@section('content')
<div class="main-content">
	<div class="container-fluid">
        		<!-- OVERVIEW -->
		<div class="panel panel-headline">
            <div class="panel-heading">
				<h3 class="panel-title"></h3>
				<p class="panel-subtitle"></p>
			</div>
            <p class="text-success">{{ session('message') }}</p>
			<div class="panel-body">
				<div class="row">
					<form method="POST" action="{{ route('eventDetails',['id'=>$events->id]) }}" enctype="multipart/form-data">
                        @csrf
                    <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B">Basic Info</h3><br>
                    {{-- Title --}}
                    <div class="form-group row">
                        <label for="title" class="col-md-3 col-form-label text-md-right required">{{ __('Title') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                            name="title" value="{{ old('title', $events->title) }}" 
                            placeholder="(empty)" @if($events->status=="Published") readonly @endif>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Description --}}
                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right required">{{ __('Description') }}</label>
                        <div class="col-md-9">
                            <textarea type="text" id="description"
                            class="form-control @error('description') border-danger @enderror" 
                            name="description" rows="6"
                            maxlength="65535" placeholder="(empty)"
                            onkeyup="countWords(this)" @if($events->status=="Published") readonly @endif>{{ old('description', $events->description  )}}</textarea>
                            <div id="description_word_count" class="text-sm" style="text-align: right; font-size: 12px">
                                0/65535
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Event Category --}}
                    <div class="form-group row">
                        <label for="category" class="col-md-3 col-form-label text-md-right required">{{ __('Category') }}</label>
                        <div class="col-md-4">
                            <select id="category" name="category" class="form-control">
                                <option value="null" disabled selected>Select event category</option>
                                <option value="Conference" @if($events->category == "Conference") selected=selected; @endif>Conference</option>
                                <option value="Convention" @if($events->category == "Convention") selected=selected; @endif>Convention</option>
                                <option value="Competition" @if($events->category == "Competition") selected=selected; @endif>Competition</option>
                                <option value="Class / Training / Workshop" @if($events->category == "Class / Training / Workshop") selected=selected; @endif>Class / Training / Workshop</option>
                                <option value="Seminar / Talk" @if($events->category == "Seminar / Talk") selected=selected; @endif>Seminar / Talk</option>
                                <option value="Festival / Fair" @if($events->category == "Festival / Fair") selected=selected; @endif>Festival / Fair</option>
                                <option value="Meeting Event" @if($events->category == "Meeting Event") selected=selected; @endif>Meeting Event</option>
                                <option value="Other" @if($events->category == "Other") selected=selected; @endif>Other</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Event Tags --}}
                    <div class="form-group row">
                        <label for="tags" class="col-md-3 col-form-label text-md-right">{{ __('Tags') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                            name="tags" placeholder="e.g. #new#event"
                            value="{{ old('tags',$events->tags) }}" @if($events->status=="Published") readonly @endif>
                            @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B">Event Venue</h3><br>
                    {{-- Event Type --}}
                    <div class="form-group row">
                        <label for="type" class="col-md-3 col-form-label text-md-right required">{{ __('Type of Event') }}</label>
                        <div class="col-md-4">
                            <select id="type" name="type" class="form-control" onchange="checkValue(this.value)">
                                <option value="null" disabled selected>Select event type</option>
                                <option value="Virtual Event" @if($events->type == "Virtual Event") selected=selected; @endif>Virtual Event</option>
                                <option value="Physical Event" @if($events->type == "Physical Event") selected=selected; @endif>Physical Event</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Venue Name --}}
                    <div class="form-group row">
                        <label for="venue_name" class="col-md-3 col-form-label text-md-right required">{{ __('Venue Name') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('venue_name') is-invalid @enderror" 
                            name="venue_name" placeholder="Enter venue name"
                            value="{{ old('venue_name',$events->venue_name) }}" @if($events->status=="Published") readonly @endif>
                            @error('venue_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Venue Address --}}
                    <div class="form-group row" id="showDisplay" style="display:none;"> 
                        <label for="venue_address" 
                        class="col-md-3 col-form-label text-md-right ">{{ __('Venue Address') }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control @error('venue_address') is-invalid @enderror" 
                            name="venue_address" onkeyup="address(this)" placeholder="Enter venue address"
                            value="{{ old('venue_address',$events->venue_address) }}">
                            @error('venue_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B">Event Time</h3><br>
                    {{-- Start date and end date --}}
                    <div class="form-group row">
                        <label for="start_date" class="col-md-3 col-form-label text-md-right required">{{ __('Start Date') }}</label>
                        <div class="col-md-3">
                            <input type="date" id="startDate" class="form-control @error('start_date') is-invalid @enderror" 
                            name="start_date" 
                            value="{{ old('start_date',$events->start_date) }}">
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label for="end_date" class="col-md-2 col-form-label text-md-right required">{{ __('End Date') }}</label>
                        <div class="col-md-3">
                            <input type="date" id="endDate" class="form-control @error('end_date') is-invalid @enderror" 
                            name="end_date" 
                            value="{{ old('end_date',$events->end_date) }}">
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Start time and end time --}}
                    <div class="form-group row">
                        <label for="start_time" class="col-md-3 col-form-label text-md-right required">{{ __('Start Time') }}</label>
                        <div class="col-md-3">
                            <input type="time" id="startTime" class="form-control @error('start_time') is-invalid @enderror" 
                            name="start_time" placeholder='hh:mm' onfocus="this.placeholder = ''"
                            value="{{ old('start_time',$events->start_time) }}"
                            min="07:00" max="21:00" pattern="(09|1[0-5]):[0-5]\d"
                            >
                            @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label for="end_time" class="col-md-2 col-form-label text-md-right required">{{ __('End Time') }}</label>
                        <div class="col-md-3">
                            <input type="time" id="endTime" class="form-control @error('end_time') is-invalid @enderror" 
                            name="end_time"
                            value="{{ old('end_time',$events->end_time) }}"
                            min="07:00" max="21:00" pattern="(09|1[0-5]):[0-5]\d">
                            @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B">Event Cover Image</h3><br>
                    {{-- Cover Image --}}
                    <div class="form-group row">
                        <label for="cover_image" class="col-md-3 col-form-label text-md-right required">{{ __('Cover Image') }}</label>
                        <div class="col-md-6">
                            @if($events->publish_status=="Not published")
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                            name="cover_image"
                            accept=".pdf,.jpg,.png,.jpeg" style="align-content: center;  font-size: 13px;"><br>
                                <img style="height: 300px; width:100%;" class="img-fluid"
                                src="data:image/png;base64,{{ chunk_split(base64_encode($events->cover_image)) }}">
                            @error('cover_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror

                            @else
                            <img style="height: 300px; width:100%;" class="img-fluid"
                            src="data:image/png;base64,{{ chunk_split(base64_encode($events->cover_image)) }}">

                            @endif
                        </div>
                    </div>
                    <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B">More Details</h3><br>
                    {{-- Number of Participants --}}
                    <div class="form-group row">
                        <label for="num_of_participant" class="col-md-3 col-form-label text-md-right required">{{ __('Number of Participants Allowed') }}</label>
                        <div class="col-md-3">
                            <input id="amount" type="number" name="num_of_participant" class="form-control @error('num_of_participant') is-invalid @enderror"
                            maxlength="4" min="10" max="1000"
                            placeholder="Enter numbers" value="{{ old('num_of_participant',$events->num_of_participant) }}"
                            oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            >   
                            <p> 
                                @error('num_of_participant')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                                @enderror  
                            </p>         
                        </div>
                    </div>
                    {{-- Registration start time and end time --}}
                    <div class="form-group row">
                        <label for="registration_start_date" class="col-md-3 col-form-label text-md-right required">{{ __('Registration Start Date') }}</label>
                        <div class="col-md-3">
                            <input type="date" id="startDate" class="form-control @error('registration_start_date') is-invalid @enderror" 
                            name="registration_start_date" 
                            value="{{ old('registration_start_date',$events->registration_start_date) }}">
                            @error('registration_start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label for="registration_end_date" class="col-md-2 col-form-label text-md-right required">{{ __('Registration End Date') }}</label>
                        <div class="col-md-3">
                            <input type="date" id="endDate" class="form-control @error('registration_end_date') is-invalid @enderror" 
                            name="registration_end_date" 
                            value="{{ old('registration_end_date',$events->registration_end_date) }}">
                            @error('registration_end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Submit button --}}
                    <div class="form-group row mb-0">
                        <div class="col-md-12 offset-md-4"><br>
                            <button type="submit" class="btn btn-primary" value="Submit" >
                                Update Details
                            </button>
                        </div>
                    </div>
                    </form>
				</div>
			</div>
		</div>
		<!-- END OVERVIEW -->
	</div>
</div>
@endsection

@section('script')
    <script>
        function countWords(words){
            $('#description_word_count').text(words.value.length + "/" + words.maxLength);
        };

        function checkValue(type){
            if(type == "Virtual Event"){
                document.getElementById("showDisplay").style.display = "none";
            }
            else if(type == "Physical Event"){
                document.getElementById("showDisplay").style.display = "block";
            }
        }

        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;

            $('#startDate').attr('min', maxDate);
        });

        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;

            $('#endDate').attr('min', maxDate);
        });

        function test(){
            var x = document.getElementById("startTime").value;
            var y = document.getElementById("endTime").min = x;
        }
    </script>
@endsection