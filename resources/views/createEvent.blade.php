@extends('layouts.layout')

@section("title")
	Event Creation | Event Management System
@endsection

@section("navtitle")
    Event Creation
@endsection

@section('content')
<div class="event-content">
	<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-headline">
                    <div class="panel-heading"><h3>Create An Event</h3></div>
                        <div class="panel-body">
                            <h3 style="font-size: 20px; border-bottom: 1px solid #676A6B">Basic Info</h3><br>
                            @if (session('status'))
                                <div class="text-danger row mb-3 col-sm-6 offset-sm-3">{{ session('status') }}</div><br>
                            @endif
                            @if (session('message'))
                                <div class="text-success row mb-3 col-sm-6 offset-sm-3">{{ session('message') }}</div><br>
                            @endif
                            <form method="POST" action="{{ route('createEvent') }}" enctype="multipart/form-data">
                                @csrf
                            {{-- Title --}}
                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label text-md-right required">{{ __('Title') }}</label>
                                <div class="col-md-9">
                                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" 
                                    name="title" value="{{ old('title') }}" placeholder="Event full name">
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
                                    maxlength="65535" placeholder="Add a brief description about the event"
                                    onkeyup="countWords(this)">{{ old('description') }}</textarea>
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
                                        <option value="Conference">Conference</option>
                                        <option value="Convention">Convention</option>
                                        <option value="Competition">Competition</option>
                                        <option value="Class / Training / Workshop">Class / Training / Workshop</option>
                                        <option value="Seminar / Talk">Seminar / Talk</option>
                                        <option value="Festival / Fair">Festival / Fair</option>
                                        <option value="Meeting Event">Meeting Event</option>
                                        <option value="Other">Other</option>
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
                                    value="{{ old('tags') }}">
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
                                        <option value="Virtual Event">Virtual Event</option>
                                        <option value="Physical Event">Physical Event</option>
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
                                    value="{{ old('venue_name') }}">
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
                                    value="{{ old('venue_address') }}">
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
                                    value="{{ old('start_date') }}">
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
                                    value="{{ old('end_date') }}">
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
                                    value="{{ old('start_time') }}"
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
                                    value="{{ old('end_time') }}"
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
                                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                    name="cover_image"
                                    accept=".pdf,.jpg,.png,.jpeg" style="align-content: center;  font-size: 13px;">
                                    @error('cover_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color: rgb(255, 83, 83);">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Submit button --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4"><br>
                                    <button type="submit" class="btn btn-primary" value="Submit" onclick="test()">
                                        Create event
                                    </button>
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
