@include('includes.header')

<body>
    <!-- Pre-loader start -->
    @include('includes.components.pre-loader')
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('includes.topbar')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('includes.sidebar')
                    <div class="pcoded-content">
                        @include('includes.components.page-header')
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        @yield('content')
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                            </div>
                            <div id="styleSelector"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.pagejs')
    @stack('scripts')
</body>

</html>
