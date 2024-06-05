@php $build = 1.1; @endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/font-awsome/css/all.min.css') }}" type="text/css">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.0.0/introjs.min.css"
        integrity="sha512-B5BOsh3/c3Lg0FOPf3k+DASjK21v5SpLy7IlLg3fdGnbilmT1gR2QzELRp0gvCDSG+bptATmQDNtwHyLQxnKzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>AlQuranClasses | Online Quran Classes From The Best Quran Tutors</title>
    @include('front.partials.theme-colors')


    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ env('GOOGLE_TAG_MANAGER_KEY') }}');
    </script>
    <!-- End Google Tag Manager -->


    <link href="{{ asset('css/mediaQuery.css') }}?{{ $build }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?{{ $build }}" type="text/css">
    <script src="https://kit.fontawesome.com/9dcfaa0f04.js" crossorigin="anonymous"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"
        integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" type="text/css">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- FAVICONS --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#0a5cd6">
    @stack('after-style')
    @stack('before-script')
    <script src="{{ asset('/js/custom_before.js') }}"></script>
    @livewireStyles

    {!! RecaptchaV3::initJs() !!}
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{ env('GOOGLE_TAG_MANAGER_KEY') }}" height="0"
            width="0" style="display:none;visibility:hidden">
        </iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    @isset($parent)
    @if ($parent)
    @include('front.partials.customer_header')
    @endif
    @else
    @include('front.partials.app-header')
    @endisset

    @yield('content')
    <div class="footer-spacing"></div>



    {{-- AFTER SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"
        integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.0.0/intro.min.js"
        integrity="sha512-sjzr7wOVjpnvPO03NIXQ7ah4pK1lYr1HfVPnIZ1ZSRBHgXJHWhXL/DELFN2Nnssup1KDDfIUPTtbGlS5eRUEkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" charset="utf8"></script>

    <script src="{{ asset('js/sweetAlert2.min.js') }}?{{ $build }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}?{{ $build }}"></script>
    <script src="{{ asset('js/popper.min.js') }}?{{ $build }}"></script>
    <script src="{{ asset('js/main.js') }}?{{ $build }}"></script>
    {{-- <script src="{{ asset('js/zoom.js') }}" type="module"></script> --}}

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $("#three-lines").click(function() {
            document.getElementById("three-lines").classList.add("d-flex");
        });
    </script>
    @livewireScripts
    @stack('after-script')
    <script src="{{ asset('/js/custom_after.js') }}"></script>
    <script src="{{ asset('js/livewire-listeners.js') }}?{{ $build }}"></script>
    <script>
        function getUrlParameter(sParam) {
            let sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        function editArrows() {
            let component = getUrlParameter('component');
            // console.log($('#' + component + ' table.dataTable tbody tr'));
            // console.log();
            // if ($('#' + component + ' table.dataTable tbody tr').length <= 1) {
            // setTimeout(() => {
            $('#' + component + ' table.dataTable ').each(function() {
                setTimeout(() => {
                    const rows = $(this).find('tbody tr')
                    if (rows.length <= 1) {

                        setTimeout(() => {
                            $(this).parent().find('.dataTables_paginate .paginate_button.previous')
                                .remove()
                            $(this).parent().find('.dataTables_paginate .paginate_button.next')
                                .remove()
                        }, 100);
                    } else {
                        setTimeout(() => {
                            $('#' + component +
                                ' .dataTables_wrapper .dataTables_paginate .paginate_button.previous'
                            ).html(
                                '<i class="fas fa-angle-double-left" aria-hidden="true"></i>');
                            $('#' + component +
                                ' .dataTables_wrapper .dataTables_paginate .paginate_button.next'
                            ).html(
                                '<i class="fas fa-angle-double-right" aria-hidden="true"></i>');
                        }, 10);

                    }
                }, 10);
            })
            // $('#' + component + ' .dataTables_wrapper .dataTables_paginate .paginate_button.previous').remove()
            // $('#' + component + ' .dataTables_wrapper .dataTables_paginate .paginate_button.next').remove();
            // }, 10);

            // } 


        }

        function addArrows() {
            if ($(' table.dataTable tbody tr').length <= 1) {
                setTimeout(() => {
                    $('.dataTables_wrapper .dataTables_paginate .paginate_button.previous').remove()
                    $('.dataTables_wrapper .dataTables_paginate .paginate_button.next').remove();
                }, 10);

            } else {
                setTimeout(() => {
                    $('.dataTables_wrapper .dataTables_paginate .paginate_button.previous').html(
                        '<i class="fas fa-angle-double-left" aria-hidden="true"></i>');
                    $('.dataTables_wrapper .dataTables_paginate .paginate_button.next').html(
                        '<i class="fas fa-angle-double-right" aria-hidden="true"></i>');
                }, 10);

            }

        }

        function styleSearchField() {
            let input = $('.dataTables_filter label input');
            input.attr('placeholder', 'Search');
            input.addClass('form-control');
            $(".dataTables_filter label").addClass('position-relative');
            // $(".dataTables_filter label").append('<i class="fa fa-search search-icon text-muted" aria-hidden="true"></i>')
        }
    </script>
    {{-- <div class="tawkTo_Chat">
        @auth
        @if (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::SalesSupport)
        {{ \TawkTo::widgetCode('https://tawk.to/chat/' . env('TAWKTO_SALESSUPPORT_KEY')) }}
        @elseif(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Customer)
        {{ \TawkTo::widgetCode('https://tawk.to/chat/' . env('TAWKTO_CUSTOMER_KEY')) }}
        @else
        {{ \TawkTo::widgetCode() }}
        @endif
        @else
        {{ \TawkTo::widgetCode() }}
        @endauth
    </div> --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}"></script>
    <script src="{{ asset('js/dynamic_ajax.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
    @stack('end-scripts')
    @yield('ajax_scripts')
</body>

</html>