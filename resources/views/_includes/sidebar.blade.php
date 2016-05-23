<!-- Sidebar -->
<div class="sidebar sidebar-left si-si-3 sidebar-visible-md-up sidebar-dark bg-primary" id="sidebarLeft" data-scrollable>

    <!-- Brand -->
    <a href="" class="sidebar-brand">
        <img src="{{ URL::asset('assets/images/logos/logo@2x.png') }}" alt="user" style="width:100px; padding:10px">
    </a>

    <!-- User -->
    <a href="" class="sidebar-link sidebar-user">
        Welcome Admin
    </a>
    <!-- // END User -->

    <!-- Menu -->
    <ul class="sidebar-menu sm-bordered sm-active-button-bg">
        <li class="sidebar-menu-item active">
            <a class="sidebar-menu-button" href="">
                <i class="sidebar-menu-icon material-icons">home</i> Dashboard
            </a>
        </li>

        <li class="sidebar-menu-item {{ in_array('badges',@$active)?"open active":"" }}">
            <a class="sidebar-menu-button" href="{{ url('/badges') }}">
                <i class="sidebar-menu-icon material-icons">loyalty</i> Badges
            </a>
            <ul class="sidebar-submenu">
                <li class="sidebar-menu-item {{ in_array('badges.manage',@$active)?"active":"" }}">
                    <a class="sidebar-menu-button" href="{{ url('/badges') }}">Manage Badges</a>
                </li>
                <li class="sidebar-menu-item {{ in_array('badges.add',@$active)?"active":"" }}">
                    <a class="sidebar-menu-button" href="{{ url('/badges/add') }}">Add Badge</a>
                </li>
            </ul>
        </li>

    </ul>
    <!-- // END Menu -->

</div>
<!-- // END Sidebar -->