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


    <link href="{{ asset('admin-assets/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/font-awsome/css/all.min.css') }}" type="text/css">
    <script src="https://kit.fontawesome.com/9dcfaa0f04.js" crossorigin="anonymous"></script>
    @stack('after-css')
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="page d-flex flex-row flex-column-fluid">
                <!--begin::Aside-->
                @include('admin.layouts.aside')
                <!--end::Aside-->
                <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @if (\Session::has('error'))
                    <div class="alert alert-danger">{{ \Session::get('error') }}</div>
                    {{ \Session::forget('error') }}
                    @endif
                    @if (\Session::has('success'))
                    <div class="alert alert-success">{{ \Session::get('success') }}</div>
                    {{ \Session::forget('success') }}
                    @endif
                    <!--begin::Header-->
                    @include('admin.layouts.header')
                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Toolbar-->
                        @include('admin.layouts.page-head',['page' => isset($page) ? $page : 'Dashboard', 'action' => isset($action) ? $action : ''])
                        <!--end::Toolbar-->
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">
                                @yield('content')
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Footer-->
                    @include('admin.layouts.footer')
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
    </div>

    <script src="{{ asset('admin-assets/js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('admin-assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('admin-assets/js/general.js') }}"></script>

    @stack('after-script')
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
    @if(session()->has('success'))
    <script>
        toastr['success']("{{ session()->get('success') }}", 'Success!');
    </script>
    @elseif(session()->has('error'))
    <script>
        toastr['error']("{{ session()->get('error') }}", 'Error!');
    </script>
    @elseif(session()->has('warning'))
    <script>
        toastr['warning']("{{ session()->get('warning') }}", 'Warning!');
    </script>
    @endif

    <script>
        $(document).ready(function() {
            $('a[id="bulk-action-btn"]').on('click', function(e) {
                e.preventDefault()
                var action = $('form[id="bulk-action"]').find('select[name="action"]').val();

                if (action === undefined || action === '' || $('input[name="ids[]"]:checkbox:checked').length === 0) {
                    toastr['warning']("No action or record selected!", 'Warning!');
                    return false;
                }
                Swal.fire({
                    text: 'Are you sure you want to apply "Bulk ' + (action) + '" action?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Apply it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form[id="bulk-action"]').submit();
                    }
                })
            })
        })
    </script>
</body>

</html>