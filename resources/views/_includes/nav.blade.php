<!-- Navbar -->
<nav class="navbar navbar-light bg-white navbar-full navbar-fixed-top ls-left-sidebar">

    <!-- Sidebar toggle -->
    <button class="navbar-toggler pull-xs-left hidden-lg-up" type="button" data-toggle="sidebar" data-target="#sidebarLeft"><span class="material-icons">menu</span></button>

    <!-- Brand -->
    @yield('page-header')

    <!-- Search -->
    <form class="form-inline pull-xs-left hidden-sm-down">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn"><button class="btn" type="button"><i class="material-icons">search</i></button></span>
        </div>
    </form>
    <!-- // END Search -->

    <!-- Menu -->
    <ul class="nav navbar-nav pull-xs-right hidden-md-down">

        <!-- Notifications dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-caret="false" data-toggle="dropdown" role="button" aria-haspopup="false"><i class="material-icons email">mail_outline</i></a>
            <ul class="dropdown-menu dropdown-menu-right notifications" aria-labelledby="Preview">
                <li class="dropdown-title">Emails</li>
                <li class="dropdown-item email-item">
                    <a class="nav-link" href="index.html">
              <span class="media">
					<span class="media-left media-middle"><i class="material-icons">mail</i></span>
              <span class="media-body media-middle">
						<small class="pull-xs-right text-muted">12:20</small>
						<strong>Adrian Demian</strong>
						Enhance your website with
					</span>
              </span>
                    </a>
                </li>
                <li class="dropdown-item email-item">
                    <a class="nav-link" href="#">
              <span class="media">
					<span class="media-left media-middle">
						<i class="material-icons">mail</i>
					</span>
              <span class="media-body media-middle">
						<small class="text-muted pull-xs-right">30 min</small>
						<strong>Michael Brain</strong>
						Partnership proposal
					</span>
              </span>
                    </a>
                </li>
                <li class="dropdown-item email-item">
                    <a class="nav-link" href="#">
              <span class="media">
					<span class="media-left media-middle">
						<i class="material-icons">mail</i>
					</span>
              <span class="media-body media-middle">
						<small class="text-muted pull-xs-right">1 hr</small>
						<strong>Sammie Downey</strong>
						UI Design
					</span>
              </span>
                    </a>
                </li>
                <li class="dropdown-action center">
                    <a href="email.html">Go to inbox</a>
                </li>
            </ul>
        </li>
        <!-- // END Notifications dropdown -->

        <!-- User dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle p-a-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false">
                <img src="{{ URL::asset('assets/images/logos/logo.png') }}" alt="Avatar" class="img-circle" width="40">
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-list" aria-labelledby="Preview">
                <a class="dropdown-item" href="#"><i class="material-icons md-18">lock</i> <span class="icon-text">Edit Account</span></a>
                <a class="dropdown-item" href="#"><i class="material-icons md-18">person</i> <span class="icon-text">Public Profile</span></a>
                <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
            </div>
        </li>
        <!-- // END User dropdown -->

    </ul>
    <!-- // END Menu -->

</nav>
<!-- // END Navbar -->