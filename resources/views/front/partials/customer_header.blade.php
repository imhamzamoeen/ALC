<div
    class="w-100 main-nav fixed-top py-2 @isset($tooltip) @if ($tooltip) disable-scroll @endif @endisset">
    <div class="container-xl">
        <nav class="navbar navbar-expand-lg navbar-dark  ">
            <div class="container-fluid">
                @if (request()->segment(count(request()->segments())) != 'dashboard')
                    {{-- <a class="  text-decoration-none d-none d-lg-block text-white" aria-current="page" href="{{ route(auth()->user()->user_type.'.dashboard' , app()->getLocale()) }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Home</a> --}}
                @endif
                <ul class="navbar-nav my-2 my-lg-0">
                    @if (request()->segment(count(request()->segments())) == 'dashboard')
                        <li class="nav-item ">
                            <a class="console-btn btn btn-light color-primary py-2 px-sm-3 px-1 text-med"
                                href="{{ route(auth()->user()->user_type . '.console', app()->getLocale()) }}">
                                {{-- <i
                                    class="me-2 fa fa-angle-left d-none d-sm-inline"></i> --}}
                                Customer
                                Console</a>
                        </li>
                    @elseif (!(request()->segment(count(request()->segments())) == 'dashboard' ||
                        request()->segment(count(request()->segments())) == 'console'
                    ))
                        <li class="nav-item ">
                            <a class="text-light px-14 text-decoration-none"
                                href="{{ route(auth()->user()->user_type . '.console', app()->getLocale()) }}"><i
                                    class="me-2 fa fa-angle-left back-btn"></i> <span class="d-none d-sm-inline">Back To
                                    Home</span></a>
                        </li>
                    @else
                        <li class="nav-item ">
                            <a class="text-light px-14 text-decoration-none"
                                href="{{ route(auth()->user()->user_type . '.dashboard', app()->getLocale()) }}"><i
                                    class="me-2 fa fa-angle-left back-btn"></i> <span class="d-none d-sm-inline">Back To
                                    Dashboard</span></a>
                        </li>
                    @endif
                </ul>
                @if (request()->segment(count(request()->segments())) == 'dashboard')
                    <img class="d-sm-block d-none" src="{{ asset('images/logo_white.png') }}" width="140px"
                        alt="alquran-logo">
                @endif

                <div class="d-flex justify-content-end notifications">

                    <div id="toolTipNotif" class="nav-item position-relative d-flex me-4">
                        <img class="mt-1" width="27" src="{{ asset('images/bell-icon.svg') }}"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" />
                        <span class=" position-absolute text-center text-light"
                            style="background-color: #F45E76; font-size: 12px;cursor: pointer;border-radius: 50%; width: 18px; height: 18px; left: 15px; top: 6px; bottom:10px;"></span>
                        <ul class="dropdown-menu dropdown-menu-lg-end customer_notification-dropdown" style=""
                            aria-labelledby="dropdownMenuButton1">
                            <li>
                                <div class="d-flex justify-content-between align-items-center notify_padding">
                                    <h6 class="mb-0 py-1 px-14">Notifications</h6>
                                    {{-- <button class="border-0 bg-transparent bold color-primary px-14">Read All</button> --}}
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider ">
                            </li>
                            <ul class="list-unstyled px-3">
                                <x-customer.customer-header-notification-component />

                            </ul>
                            {{-- <li><hr class="dropdown-divider "></li>
                            <li><div class="d-flex align-items-center justify-content-center"><a href="" class="text-decoration-none text-dark">{{ 'See all' }}</a> </div></li> --}}
                        </ul>
                    </div>
                    {{-- <div id="toolTipChat" class="nav-item position-relative d-flex me-4">
                        <img class="mt-1 icon-chat" width="27"
                            src="{{ asset('images/vuesax-linear-message-notif.svg') }}"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" />
                        <span class=" position-absolute text-center text-light"
                            style="background-color: #F45E76; font-size: 12px; border-radius: 50%;cursor: pointer;width: 18px; height: 18px; left: 18px; top: 6px; bottom:10px;">1</span>
                    </div> --}}
                    <div class="nav-item d-block" id="toolTipUser">
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="text-decoration-none" href="javascript:void(0);"
                                id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    {!! generate_profile_picture_by_name(Auth::user()->name, 50) !!}
                                @else
                                    <img src="{{ asset('images/user-image.svg') }}" />
                                @endif

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item px-14" href="#">{{ auth()->user()->name }}</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                {{-- @if (!empty(session('customer_pin'))) --}}
                                    <li><a href="{{ url('/en/customer/settings') }}"
                                            class="dropdown-item px-14">Settings</a>
                                    <li><a href="{{ url('/en/customer/paymentMethod') }}"
                                            class="dropdown-item px-14">Payment
                                            Methods</a>
                                    </li>
                                    <li><a href="{{ url('/en/customer/helpSupport') }}" class="dropdown-item px-14">Help
                                            and Support</a>
                                    </li>
                                {{-- @endif --}}
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a class="dropdown-item px-14" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </nav>
</div>
</div>

@yield('profile-header')

<br>
<br>
@push('after-script')
    <script>
        $(document).ready(function() {
            let intro = introJs().setOptions({
                tooltipClass: 'customTooltip',
                exitOnOverlayClick: false
            });
            // intro.start();
            // use below code only when tooltips are displayed
            // $('a , button').not('.introjs-button , .introjs-skipbutton').addClass('avoid-clicks');
            setTimeout(() => {
                $('.customTooltip').find('.introjs-bullets li').first().addClass('active');
                $('.customTooltip .introjs-nextbutton').on('click', function() {
                    $('.customTooltip li').removeClass('active');
                    $('.customTooltip').find('li > a.active').parent().next().addClass('active')
                });
                $('.customTooltip .introjs-bullets a').on('click', function() {
                    $('.customTooltip li').removeClass('active');
                    $('.customTooltip').find('li > a.active').parent().addClass('active')
                });
                $('.customTooltip .introjs-prevbutton').on('click', function() {
                    $('.customTooltip li').removeClass('active');
                    $('.customTooltip').find('li > a.active').parent().prev().addClass('active')
                });
            }, 10);
            intro.onexit(function() {
                enableScroll();
                $('a , button').removeClass('avoid-clicks')
            });
        });
        $('.sidebar_toggle_button').click(function() {
            $('#sidebar-toggle').animate({
                width: 'toggle'
            });
        });
        $('.secondary-nav .nav-link').click(function() {
            $('.secondary-nav .border-custom-bottom').removeClass('active');
            $(this).parent().addClass('active');
        })
        @if (!is_null(auth()->user()->customer_pin) && (auth()->user()->pin_check==1))
            $('.console-btn').on('click', function(e) {
                e.preventDefault()

                $('#pinCode-modal').modal('toggle')
            })
        @endif
    </script>
@endpush
