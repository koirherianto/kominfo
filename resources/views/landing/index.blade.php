<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">

    <link href="{{ asset('landing2/fonts/font-awesome.css') }} " rel="stylesheet" type="text/css">
    <link href="{{ asset('landing2/fonts/elegant-fonts.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('landing2/bootstrap/css/bootstrap.css') }} " type="text/css">
    <link rel="stylesheet" href="{{ asset('landing2/css/magnific-popup.css') }} " type="text/css">
    <link rel="stylesheet" href="{{ asset('landing2/css/style.css') }} " type="text/css">
    <meta name="description" content="Sispaka - Platform Sistem Pakar Berbasis Web tanpa Kode. Buat dan kelola sistem pakar. Daftarkan diri Anda, buat proyek, dan jelajahi pengetahuan medis.">
    <link rel="shortcut icon" href="{{ asset('landing2/img/favicon.ico') }} " type="image/x-icon">
    <title>Sispaka - Expert System Platform </title>

    {{-- beda template --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('landing/css/style.css') }} ">

    <style>
        body { background-color: #f3f3f3; }
    </style>

</head>

<body>
<div class="page-wrapper">
    @include('landing.layout.header')
    
</div>
<!--end page-wrapper-->

<div class="latest-news container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="row-title">
                    Expert System Platform
                </div>
            </div>
            <div class="col-sm-4">
                <div class="main-btn-holder">
                    {{-- <a href="{{ route('blogs') }}" class="hbtn hbtn-default">View more</a> --}}
                </div>
            </div>
        </div>
        @php $counter = 0; @endphp
        @foreach ($projects as $project)
            @if ($counter % 3 == 0)
                <div class="row">
            @endif
            <div class="col-sm-6 col-md-4">
                <div class="post-box blue-bg" style="background-image: url('{{ $project['foto'] }}'); background-size: cover; background-position: center;">
                    <div class="post-img"></div>
                    <span class="badge badge-danger">{{ $project['judul']}}</span>
                    <div class="post-title">{{ $project['judul']}}</div>
                    {{-- <div class="post-link"><a href="{{ route('blog', $project['slug']) }}">Baca</a></div> --}}
                    <div class="post-link"><a href="">Baca</a></div>
                </div>
            </div>
            @php $counter++; @endphp
            @if ($counter % 3 == 0)
                </div>
            @endif
        @endforeach
        @if ($counter % 3 != 0)
            </div>
        @endif
    </div>
</div>


@include('landing.layout.modals')

<script  src="{{ asset('landing2/js/jquery-2.2.1.min.js') }}"></script>
<script  src="http://maps.google.com/maps/api/js"></script>
<script  src="{{ asset('landing2/bootstrap/js/bootstrap.min.js') }}"></script>
<script  src="{{ asset('landing2/js/jquery.validate.min.js') }}"></script>
<script  src="{{ asset('landing2/js/jquery.magnific-popup.min.js') }}"></script>
<script  src="{{ asset('landing2/js/jquery.plugin.min.js') }}"></script>
<script  src="{{ asset('landing2/js/jquery.countdown.min.js') }}"></script>
<script  src="{{ asset('landing2/js/jquery.parallax.min.js') }}"></script>
<script  src="{{ asset('landing2/js/custom.js') }}"></script>

<script>

    //  Map

    var latitude = 34.038405;
    var longitude = -117.946944;
    var markerImage = "{{ asset('landing2/img/map-marker.png') }} ";
    var mapTheme = "light";
    var mapElement = "map";

    $(".modal").on("shown.bs.modal", function (e) {
        google.maps.event.addDomListener(window, 'load', simpleMap(latitude, longitude, markerImage, mapTheme, mapElement));
    });

    // Background

    $('#scene').parallax({
        calibrateX: true,
        calibrateY: true,
        originX: -1.0,
        scalarX: 1400
    });



</script>

</body>
