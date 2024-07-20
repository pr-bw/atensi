@extends('layouts.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader text-light" style="background-color: #FFC7ED">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">PRESENSI</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 300px;
        }
    </style>

    <script
        src="https://www.bing.com/api/maps/mapcontrol?key=Am0oIOY9jcVsq1hoSrFS80kEEmzSAJ5xFopwNWOsVsDItimhCR1r7elcx-x9_XOW">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="row mt-2">
        <div class="col">
            <input type="text" id="lokasi" class="form-control" readonly>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col">
            <div class="webcam-capture"></div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col">
            @if ($check > 0)
                <button id="take_presensi" class="btn btn-danger btn-block">
                    <ion-icon name="camera"></ion-icon>
                    Presensi Pulang
                </button>
            @else
                <button id="take_presensi" class="btn btn-primary btn-block">
                    <ion-icon name="camera"></ion-icon>
                    Presensi Masuk
                </button>
            @endif
        </div>
    </div>

    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    <audio id="notifikasi_in">
        <source src="{{ asset('/assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
    </audio>

    <audio id="notifikasi_out">
        <source src="{{ asset('/assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
    </audio>

    <audio id="notifikasi_radius">
        <source src="{{ asset('/assets/sound/notifikasi_radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script>
        let notif_in = document.getElementById('notifikasi_in');
        let notif_out = document.getElementById('notifikasi_out');
        let notif_radius = document.getElementById('notifikasi_radius');
        let lokasi = document.getElementById('lokasi');
        let latitude = "";
        let longitude = "";

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            console.log("Position received:", position);
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            lokasi.value = latitude + "," + longitude;
            initMap();
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        function initMap() {
            try {
                // let latitude_sekolah = -6.410222;
                // let longitude_sekolah = 106.720293;

                let loc = "{{ $loc_sekolah->lokasi_sekolah }}";

                let location = loc.split(',');

                let latitude_sekolah = location[0];
                let longitude_sekolah = location[1];

                // alert(latitude_sekolah);
                // alert(longitude_sekolah);

                let map = new Microsoft.Maps.Map('#map', {
                    center: new Microsoft.Maps.Location(latitude, longitude),
                    zoom: 15 // Mungkin perlu disesuaikan untuk menampilkan seluruh area
                });

                // Add pushpin for the school location
                let schoolLocation = new Microsoft.Maps.Location(latitude_sekolah, longitude_sekolah);
                let pushpinSchool = new Microsoft.Maps.Pushpin(schoolLocation, {
                    color: 'red',
                    title: 'Lokasi Sekolah'
                });
                map.entities.push(pushpinSchool);

                // Add pushpin for user's current location
                let userLocation = new Microsoft.Maps.Location(latitude, longitude);
                let pushpinUser = new Microsoft.Maps.Pushpin(userLocation, {
                    color: 'blue',
                    title: 'Lokasi Anda'
                });
                map.entities.push(pushpinUser);

                // Load the Spatial Math module
                Microsoft.Maps.loadModule('Microsoft.Maps.SpatialMath', function() {
                    let center = schoolLocation;
                    let radius = {{ $loc_sekolah->radius }}; // Radius in meters
                    let numPoints = 36; // Number of points to create the circle (more points = smoother circle)

                    let locations = Microsoft.Maps.SpatialMath.getRegularPolygon(center, radius, numPoints,
                        Microsoft.Maps.SpatialMath.DistanceUnits.Meters);

                    let polygon = new Microsoft.Maps.Polygon(locations, {
                        fillColor: 'rgba(255, 0, 0, 0.2)', // Merah transparan
                        strokeColor: 'red',
                        strokeThickness: 1
                    });

                    map.entities.push(polygon);
                });
            } catch (error) {
                console.error("Error initializing map:", error);
            }
        }

        $(document).ready(function() {
            getLocation();

            Webcam.set({
                height: 480,
                width: 640,
                image_format: 'jpeg',
                jpeg_quality: 80,
            });

            Webcam.attach(".webcam-capture");

            $("#take_presensi").click(function(e) {
                e.preventDefault();
                Webcam.snap(function(uri) {
                    let lokasi = $("#lokasi").val();

                    $.ajax({
                        type: 'POST',
                        url: '/guru/presensi/simpan-presensi',
                        data: {
                            _token: '{{ csrf_token() }}',
                            image: uri,
                            lokasi: lokasi,
                        },
                        cache: false,
                        success: function(response) {
                            console.log(response); // untuk debugging
                            let result;
                            try {
                                result = JSON.parse(response);
                            } catch (e) {
                                console.error("Error parsing JSON:", e);
                                result = response; // jika response bukan JSON
                            }

                            if (result.status == "success") {
                                if (result.type == "in") {
                                    notif_in.play();
                                } else {
                                    notif_out.play();
                                }
                                Swal.fire({
                                    title: 'Success!',
                                    text: result.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    console.log(
                                        "Redirecting to dashboard..."
                                    ); // untuk debugging
                                    window.location.href =
                                        '/guru/dashboard';
                                });
                            } else {
                                if (result.type == "radius") {
                                    notif_radius.play();
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: result.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat mengirim data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });
        });
    </script>
@endpush
