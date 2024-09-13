<li class="user-profile header-notification">
    <a href="#!" class="waves-effect waves-light">
        <img src="{{ asset('dist/profiles/'.Auth::user()->photo) }}" class="img-radius" alt="User-Profile-Image">
        <span>{{ Auth::user()->name }}</span>
        <i class="ti-angle-down"></i>
    </a>
    <ul class="show-notification profile-notification">
        <li class="waves-effect waves-light">
            <a href="#!">
                <i class="ti-settings"></i> Settings
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="user-profile.html">
                <i class="ti-user"></i> Profile
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="auth-lock-screen.html">
                <i class="ti-lock"></i> Lock Screen
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="{{ route('auth.logout') }}">
                <i class="ti-layout-sidebar-left"></i> Logout
            </a>
        </li>
    </ul>
</li>
