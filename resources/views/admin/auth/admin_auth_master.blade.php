<!DOCTYPE html>
<html lang="en">
<head>
    <title>AlQuranClasses | Online Quran Classes From The Best Quran Tutors</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#0a5cd6">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />


    <link href="{{ asset('admin-assets/css/plugins.dark.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/style.dark.bundle.css') }}" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class="dark-mode">

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #1E1E2D">

            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto text-center">
                        <a href="#" class="py-9 mb-5">
                            <img alt="Logo" src="{{ asset('images/logo_blue.svg') }}" class="h-60px" />
                        </a>

                        <h1 class="fw-bolder fs-2qx pb-5 pb-md-10 mt-15">Welcome to AlQuran Classes</h1>

                        <p class="fw-bold fs-2">Administration Panel</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('admin-assets/js/plugins.bundle.js') }}"></script>
<script src="{{ asset('admin-assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('admin-assets/js/general.js') }}"></script>
</body>
</html>
