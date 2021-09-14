<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        @include('layouts.head')
    </head>
    <body>
    	<!-- WRAPPER -->
		<div id="wrapper">
			<!-- NAVBAR -->
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="brand">
				@if(Auth::check() && Auth::user()->isAssistant())
				<a href="{{ route("manageEvents") }}"><img src="/assets/img/logo.png" alt="System Logo" class="img-responsive logo">
					<h5 style="color: #F4902E"><b>Event Management System | @yield("navtitle")</b></h5>
				</a>
				@elseif(Auth::check() && Auth::user()->isAdmin() && Auth::user()->isParticipant())
				<a href="{{ route('home') }}"><img src="/assets/img/logo.png" alt="System Logo" class="img-responsive logo">
					<h5 style="color: #F4902E"><b>Event Management System | @yield("navtitle")</b></h5>
				</a>
				@else
				<a href="{{ route('login') }}"><img src="/assets/img/logo.png" alt="System Logo" class="img-responsive logo">
					<h5 style="color: #F4902E"><b>Event Management System | @yield("navtitle")</b></h5>
				</a>
				@endif

				</div>
				@if (Auth::check())
				@include('layouts.nav')
				@endif
			</nav>
			<!-- END NAVBAR -->
			<!--Sidebar-->
			{{-- @if (Auth::check() && Route::currentRouteName() == "dashboard" && Auth::user()->isAdmin())
				@include('layouts.sidebar')
			@endif --}}
			<!--End Sidebar-->
			<!--Sidebar-->
			@yield("sidebar")
			<!--End Sidebar-->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			@yield("content")
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		{{-- <div class="clearfix"></div> --}}
		@include('layouts.footer')
	</div>
    <!-- END WRAPPER -->
    @include('layouts.script')
	@yield("script")
    </body>
</html>