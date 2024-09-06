@extends('layouts.default_layout')
@section('title')
    {{ $title }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/leaflet/leaflet.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment-timezone.min.js') }}"></script>
    <script>
        function notification(status, message) {
            if (status == 'error') {
                toastr.error(message, status.toUpperCase(), {
                    closeButton: 1,
                    showDuration: "300",
                    hideDuration: "1000",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    timeOut: 5e3,
                    showEasing: "swing",
                    hideEasing: "linear"
                });
            } else {
                toastr.success(message, status.toUpperCase(), {
                    closeButton: 1,
                    showDuration: "300",
                    hideDuration: "1000",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    timeOut: 5e3,
                    showEasing: "swing",
                    hideEasing: "linear"
                });
            }
        }
        let googleTile = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution: ''});
        let osmTile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        let googleTerrain = L.tileLayer('http://{s}.google.com/vt?lyrs=p&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });
        let googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });
        var marker = [];
        var baseMaps = {
            "OpenStreetMap": osmTile,
            "Google Satellites": googleTile,
            "Google Terrain": googleTerrain
        };
        var map = L.map('map', {
            center: [-6.848569, 107.5202047],
            zoom: 13,
            layers: [osmTile, googleTile]
        });
        var layerControl = L.control.layers(baseMaps).addTo(map);

        function markersUser() {
            if (map.hasLayer(marker)) {
                map.removeLayer(marker); // remove
            }
            $.get("{{ route('auth.dashboard.markers') }}", function(res) {
                $.each(res.data, function(idx, val) {
                    marker = new L.marker([val.position.latitude, val.position.longitude])
                        .bindPopup(val.name + '<br>' + moment(val.position.created_at).tz(val.code).format('DD MMM YYYY HH:mm z'))
                        .on('click', onClick)
                        .addTo(map);
                })

                function onClick(e) {
                    var popup = e.target.getPopup();
                    var content = popup.getContent();
                }
            })
        }

        $(document).ready(function() {
            markersUser();
        })
    </script>
@endpush
@section('content')
    <!--**********************************
                                Content body start
                            ***********************************-->
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Total User</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $countUser }}</h2>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="icon-user-following"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">Employees Absence</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">122</h2>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-user-times"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-4">
                        <div class="card-body">
                            <h3 class="card-title text-white">PTT Server</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $countServer }}</h2>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-microchip"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Row -->
            <div class="row">
                <div class="col-12 m-b-30">
                    {{-- <h4 class="d-inline">User Location</h4> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">User Location</h5>
                                    <div id="map" style="height: 500px">
                                        <div class="btn-group float-right" style="z-index: 1001">
                                            {{-- <button type="buttons" onclick="markersUser()" class="btn btn-primary"><i
                                                    class="fa fa-arrows-rotate"></i> Refresh</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
            Content body end
        ***********************************-->
@endsection
