<!--**********************************
            Sidebar start
        ***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('auth.dashboard') }}" aria-expanded="false">
                    <i class="icon-home menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-database"></i> <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.user.index') }}"><i class="icon-people"></i> Accounts</a></li>
                    <li><a href="{{ route('admin.server.index') }}"><i class="fa fa-sitemap"></i> Servers</a></li>
                    <li><a href="{{ route('admin.company.index') }}"><i class="fa fa-sitemap"></i> Companies</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.log-activity.index') }}" aria-expanded="false">
                    <i class="fa-solid fa-clock-rotate-left menu-icon"></i> <span class="nav-text">Log Activity</span>
                </a>
            </li>
            <li>
                <a href="{{ route('auth.logout') }}" aria-expanded="false">
                    <i class="icon-logout menu-icon"></i><span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
