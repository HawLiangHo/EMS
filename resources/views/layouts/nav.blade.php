<div class="container-fluid">
    {{-- <div class="navbar-btn">
        <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
    </div> --}}
        <form class="navbar-form navbar-left">
            {{-- <div class="input-group" style="margin-left: 120px;">
                <input type="text" value="" class="form-control" placeholder="Search ......">
                <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
            </div> --}}
        </form>
        <div class="navbar-btn navbar-btn-right">
            {{-- <a class="btn btn-success update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a> --}}
        </div>
        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">
                {{-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                        <i class="lnr lnr-alarm"></i>
                        <span class="badge bg-danger">5</span>
                    </a>
                    <ul class="dropdown-menu notifications">
                        <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
                        <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
                        <li><a href="#" class="more">See all notifications</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Basic Use</a></li>
                        <li><a href="#">Working With Data</a></li>
                        <li><a href="#">Security</a></li>
                        <li><a href="#">Troubleshooting</a></li>
                    </ul>
                </li> --}}
                @if (Route::currentRouteName() == "login")
                <li class="dropdown">
                    <a href="{{ route("assistantLogin") }}">
                        <span style="font-size: 15px;">Login for Event Assistant</span>
                        <i class="lnr lnr-enter" style="font-size:15px"></i>
                    </a> 
                </li>
                @endif
                @if (Auth::check() && Route::currentRouteName() != "login" && Auth::user()->isAdmin() | Auth::user()->isParticipant())
                <li class="dropdown">
                    <a href="{{ route("billing") }}">
                        <span>RM {{ number_format(Auth::user()->credit_balance,2) }}</span>
                        <i class="fas fa-wallet" style="font-size:15px"></i>
                    </a> 
                </li>
                <li class="dropdown">
                    {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar">
                        <span>{{ Auth::user()->username }}</span>
                        <i class="icon-submenu lnr lnr-chevron-down"></i>
                    </a>     --}}
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>{{ Auth::user()->username }}</span>
                        <i class="icon-submenu lnr lnr-chevron-down"></i>
                    </a>    
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("editProfile")}}"><i class="lnr lnr-cog"></i> <span>Profile Settings</span></a></li>
                        <li><a href="{{ route("myTickets") }}"><i class="lnr lnr-tag"></i> <span>My Tickets</span></a></li>
                        @if(Auth::user()->isParticipant())
                        <li><a href="{{ route("createEvent") }}"><i class="lnr lnr-user"></i> <span>Become an organizer</span></a></li>
                        @endif
                        @if(Auth::user()->isAdmin())
                        <li><a href="{{ route("manageEvents") }}"><i class="lnr lnr-store"></i> <span>Manage my events</span></a></li>
                        @endif
                        <li><a href="{{ route("logout") }}"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                    </ul>
                </li>
                @elseif(Auth::check() && Route::currentRouteName() != "login" && Auth::user()->isAssistant())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>{{ Auth::user()->username }}</span>
                        <i class="icon-submenu lnr lnr-chevron-down"></i>
                    </a>    
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("logout") }}"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
</div>
