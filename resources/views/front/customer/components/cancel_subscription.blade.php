@extends('front.layouts.master', ['parent' => true])

@section('content')


    <div class="cancel-subscription">
        <div class="container">
            <div class="tab-content" id="tab-content">
                <div class="tab-pane fade show active" id="first-cancel-Tab" role="tabpanel" aria-labelledby="1st-cancel-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <h3 class="px-24 text-bold mb-4">Cancel Subscription (Step 1/3)</h3>
                            </div>
                        </div>
                        <div class="row flex-lg-row flex-column-reverse">
                            <div class="col-lg-6 col-12">
                                <h4 class="px-18 text-sb pb-1 mb-2">Why do you want to cancel?</h4>
                                {{-- <div class="row m-auto trial-days text-center mb-4 ps-0 pe-0 "> --}}
                                <div class="mt-4 checkboxes">
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <input class="form-check-input form-tick custom-checkbox mt-0" type="checkbox"
                                                name="reasons[]" id="" value="1">
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <label class="form-check-label ms-sm-0 ms-2 px-14"
                                                for="">{{ __('It\'s too expensive') }}</label>
                                        </div>

                                    </div>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <input class="form-check-input form-tick custom-checkbox mt-0" type="checkbox"
                                                name="reasons[]" id="" value="2">
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <label class="form-check-label ms-sm-0 ms-2 px-14"
                                                for="">{{ __('Lofnsdfbsfsdnfsbssd fn hfn nffu hij jhdi iwnfe infe nioF FS SFSDFSFSFNSIFSN') }}</label>
                                        </div>


                                    </div>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <input class="form-check-input form-tick custom-checkbox mt-0" type="checkbox"
                                                name="reasons[]" id="" value="3">
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <label class="form-check-label ms-sm-0 ms-2 px-14"
                                                for="">{{ __('Lofnsdfbsfsdnfsbssd fn hfn nffu hij jhdi iwnfe infe nioF FS SFSDFSFSFNSIFSN') }}</label>
                                        </div>

                                    </div>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <input class="form-check-input form-tick custom-checkbox mt-0" type="checkbox"
                                                name="reasons[]" id="" value="4">
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <label class="form-check-label ms-sm-0 ms-2 px-14"
                                                for="">{{ __('Lofnsdfbsfsdnfsbssd fn hfn nffu hij jhdi iwnfe infe nioF FS SFSDFSFSFNSIFSN') }}</label>
                                        </div>

                                    </div>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <input class="form-check-input form-tick custom-checkbox mt-0" type="checkbox"
                                                name="reasons[]" id="" value="5">
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <label class="form-check-label ms-sm-0 ms-2 px-14"
                                                for="">{{ __('Lofnsdfbsfsdnfsbssd fn hfn nffu hij jhdi iwnfe infe nioF FS SFSDFSFSFNSIFSN') }}</label>
                                        </div>

                                    </div>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <input class="form-check-input form-tick custom-checkbox mt-0" type="checkbox"
                                                name="reasons[]" id="" value="6">
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <label class="form-check-label ms-sm-0 ms-2 px-14"
                                                for="">{{ __('Other (Please Specify )') }}</label>
                                        </div>

                                    </div>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <div style="width: 12px;height:12px"></div>
                                        </div>
                                        <div class="col-11 ps-sm-0 ">
                                            <textarea class="ms-sm-0 ms-2 form-control px-14" name="" id="" rows="4"
                                                placeholder="Comments (optional)"></textarea>
                                        </div>

                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="col-lg-1 d-lg-block d-none"></div>
                            <div class="col-lg-5 col-12 mt-5 mt-sm-0">
                                <h4 class="px-18 text-bold pb-2">{{ __('Your plan Details') }}</h4>
                                <div class="container mb-3 shadow-sm rounded">
                                    <div class="py-3 row">
                                        <div class="col-3">
                                            <div class="align-items-center d-flex justify-content-center"
                                                style="height: 63px;background-color:#FFAA0028">
                                                Plus
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="mt-2 px-14 text-sb">5 Classes Per week</h4>
                                            <h5 class="px-14 text-med">$ 115 / Month</h5>
                                        </div>
                                        <div class="col-3">
                                            <span class="badge bg-success text-med d-lg-inline d-none">Best
                                                Seller</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="second-cancel-Tab" role="tabpanel" aria-labelledby="2nd-cancel-tab">
                    <h3 class="px-24 text-bold mb-5">Cancel Subscription (Step 2/3)</h3>
                    <h4 class="px-18 text-sb pb-1 mb-2 text-center">Downgrade to a more affordable plan.
                    </h4>
                    <div class="owl-carousel owl-theme text-center mx-auto">
                        <div class="item shadow">
                            <div class="border py-4 subscription_plan" style="">
                                <h5 class="px-14 text-sb">Basic</h5>
                                <h4 class="text-sb">$35</h4>
                                <p class="text-muted px-14 text-med">Per week</p>
                                <p class="px-14 text-med">Basic Plan for every Budget</p>
                                <hr class="mx-auto">
                                <p class="px-14 text-med">1 Class Per week</p>
                                <p class="px-14 text-med">$ 170 / Month</p>
                                <button class="btn px-5 py-2 text-med">Avail Offer</button>
                            </div>
                        </div>
                        <div class="item shadow">
                            <div class="border py-4 subscription_plan">
                                <h5 class="px-14 text-sb">Standard</h5>
                                <h4 class="text-sb">$65</h4>
                                <p class="text-muted px-14 text-med">Per week</p>
                                <p class="px-14 text-med">Basic Plan for every Budget</p>
                                <hr class="mx-auto">
                                <p class="px-14 text-med">3 Class Per week</p>
                                <p class="mb-4 px-14 text-med">$ 250 / Month</p>
                                <button class="btn  px-5 py-2 text-med">Avail Offer</button>
                            </div>
                        </div>
                        <div class="item shadow">
                            <div class="border py-4 subscription_plan">
                                <h5 class="px-14 text-sb">Premium</h5>
                                <h4 class="text-sb">$90</h4>
                                <p class="text-muted px-14 text-med">Per week</p>
                                <p class="px-14 text-med">Basic Plan for every Budget</p>
                                <hr class="mx-auto">
                                <p class="px-14 text-med">5 Class Per week</p>
                                <p class="px-14 text-med">$ 400 / Month</p>
                                <button class="btn px-5 py-2 text-med">Avail Offer</button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="tab-pane fade show" id="third-cancel-Tab" role="tabpanel" aria-labelledby="3rd-cancel-tab">
                    <h3 class="px-24 text-bold mb-5">Cancel Subscription (Step 3/3)</h3>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <h4 class="px-18 text-bold pb-2">{{ __('Student Details') }}</h4>
                                <div class="container mb-3 shadow-sm rounded">
                                    <div class="py-3 row">
                                        <div class="col-2 align-items-center d-flex justify-content-center">
                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <img height="59" class="rounded-circle"
                                                    src="{{ Auth::user()->profile_photo_url }}" />
                                            @else
                                                <img src="{{ asset('images/user-image.svg') }}" />
                                            @endif
                                        </div>
                                        <div class="col-10">
                                            <h4 class="mt-2 px-14 text-sb">Noman ali Khan</h4>
                                            <h5 class="px-14 text-med">Tajweed Of Quran</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h4 class="px-18 text-bold pb-2">{{ __('Your plan Details') }}</h4>
                                <div class="container mb-3 shadow-sm rounded">
                                    <div class="py-3 row">
                                        <div class="col-3">
                                            <div class="align-items-center d-flex justify-content-center"
                                                style="height: 63px;background-color:#FFAA0028">
                                                Plus
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="mt-2 px-14 text-sb">5 Classes Per week</h4>
                                            <h5 class="px-14 text-med">$ 115 / Month</h5>
                                        </div>
                                        <div class="col-3">
                                            <span class="badge bg-success text-med d-lg-inline d-none">Best
                                                Seller</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger px-14" role="alert">
                            <i class="fa fa-exclamation-triangle me-2"></i> Lorem ipsum dolor sit amet, consetetur
                            sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
                            erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
                            kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
                            amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore
                            magna aliquyam erat, sed diam voluptua. At vero
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="footer-wrapper fixed-bottom">
            <div class="container">
                <div
                    class="align-items-center flex-column-reverse flex-sm-row footer justify-content-evenly justify-content-sm-between px-xl-4 row text-center text-sm-start">
                    <div class="col-sm-3 col-12 mt-sm-0 mt-2 mb-3">
                        <button
                            class="text-dark text-med px-14 text-start text-decoration-underline border-0 bg-transparent"
                            onclick="location.href = '/en/customer/console';" href="javascript:void(0)">No, I
                            don't want to
                            cancel</button>
                    </div>
                    <div class="col-sm-9 col-12">
                        <ul class="nav cancel_sub_nav justify-content-center justify-content-sm-end flex-sm-row flex-column-reverse"
                            id="myTab" role="tablist">
                            <li class="nav-item mt-sm-0 mt-2" data-label="Continue" role="presentation">
                                <a class="nav-link p-0 text-med active" id="1st-cancel-tab" data-bs-toggle="tab"
                                    data-bs-target="#first-cancel-Tab" role="tab" aria-controls="first-cancel-Tab"
                                    aria-selected="false">
                                    <button class="btn py-2"></button>
                                </a>
                            </li>
                            <li class="nav-item next mt-sm-0 mt-2" data-label="Continue" role="presentation">
                                <a class="nav-link p-0 text-med" id="2nd-cancel-tab" data-bs-toggle="tab"
                                    data-bs-target="#second-cancel-Tab" role="tab" aria-controls="second-cancel-Tab"
                                    aria-selected="true">
                                    <button class="ms-3 btn btn-primary py-2">Continue</button>
                                </a>
                            </li>
                            <li class="nav-item mt-sm-0 mt-2" data-label="Continue" role="presentation">
                                <a class="nav-link p-0 text-med" id="3rd-cancel-tab" data-bs-toggle="tab"
                                    data-bs-target="#third-cancel-Tab" role="tab" aria-controls="third-cancel-Tab"
                                    aria-selected="false">
                                    <button class="ms-3 btn py-2 btn-primary">Continue</button>
                                </a>
                            </li>
                            <li class="nav-item mt-sm-0 mt-2" data-label="Confirm Cancellation" role="presentation">
                                <a class="nav-link p-0 text-med">
                                    <button class="ms-3 btn btn-outline-danger py-2"
                                        onclick="location.href = '/en/customer/console';">Confirm
                                        Cancellation</button>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @push('after-style')
        <style>
            .cancel-subscription {
                margin: 90px 0 130px;
            }

            .cancel-subscription>.container {
                margin-bottom: 80px;
            }

            .cancel-subscription .package_summary {
                background-color: #F1F7FF;
            }

            .cancel-subscription .package_summary hr {
                background-color: #c9bcbc;
                height: 2px;
            }

            .cancel-subscription .form-check-input {
                width: 1.3em;
                height: 1.3em;
            }

            .cancel-subscription textarea {
                width: 100%;
            }

            .cancel_sub_nav button {
                width: 220px;
            }

            .form-check-input:checked[type=checkbox] {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
            }

            .cancel_sub_nav .nav-item {
                display: none;
            }



            .cancel-subscription .subscription_plan {
                margin-top: 40px;
            }

            .cancel-subscription .subscription_plan h4 {
                font-size: 32px;
            }

            .cancel-subscription .subscription_plan button {
                background-color: white;
                border: 1px solid var(--primary-color);
                color: var(--primary-color);
            }

            .cancel-subscription .subscription_plan button:hover {
                background-color: var(--primary-color);
                color: white;
            }

            .cancel-subscription .owl-item .item,
            .cancel-subscription .owl-item .subscription_plan {
                border-radius: 10px;
            }


            .cancel-subscription .owl-carousel {
                height: 414px;
            }



            .cancel-subscription .subscription_plan hr {
                background-color: var(--primary-color) !important;
                width: 50%
            }

            .cancel_sub_nav .nav-item.next,
            .cancel_sub_nav .nav-item.prev {
                display: block;
            }

            .cancel-subscription .btn-outline-primary:hover {
                background-color: white;
                border-color: #0d6efd;
                color: #0d6efd;
            }

            .cancel-subscription .owl-carousel button.owl-prev {
                width: 15px;
                height: 100px;
                position: absolute;
                top: 33%;
                margin-left: -25px;
                display: block !important;
                border: 0px solid black;
                font-size: 70px !important;
            }

            .cancel-subscription .owl-carousel button.owl-next {
                width: 15px;
                height: 100px;
                position: absolute;
                top: 33%;
                right: -20px;
                display: block !important;
                border: 0px solid black;
                font-size: 70px !important;
            }

            .cancel-subscription .footer {
                height: 100px;
            }

            .cancel-subscription .owl-carousel .owl-nav.disabled {
                display: block !important;
            }

            .cancel-subscription .footer-wrapper {
                border-top: 2px solid lightgray;
                background-color: white;
            }

            .cancel-subscription .alert {
                color: black;
                border: 2px solid red;
            }

            .cancel-subscription .alert i {
                color: red;
            }

            .cancel-subscription .footer-wrapper .nav-item .btn:not(.btn-outline-primary):not(.btn-primary):not(.btn-outline-danger) {
                display: none;
            }

            .cancel-subscription .checkboxes .col-1 {
                margin-top: 3px;

            }

            @media screen and (max-width:576px) {
                .payment-col {
                    margin: 0 auto 0 auto;
                }

                .cancel-subscription .footer {
                    height: 150px;
                }

                .cancel-subscription .footer-wrapper .nav-item .btn {
                    margin-left: 0 !important;
                    margin-top: 7px;
                }

                .cancel-subscription {
                    margin: 90px 0 80px;
                }
            }

            @media screen and (min-width:577px) and (max-width:991px) {
                .cancel-subscription .checkboxes .col-11 {
                    margin-left: -10px;
                }
            }

            @media screen and (min-width:769px) {

                .cancel-subscription .owl-item.center .subscription_plan p,
                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan h4 {
                    margin-bottom: 20px;
                }

                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan {
                    height: 414px;
                }

                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan hr {
                    background-color: white !important;
                }

                .cancel-subscription .owl-item.center .subscription_plan hr {
                    margin: 25px 0 25px 0;
                }



                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan p,
                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan h5 {
                    font-size: 16px;
                }

                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan h4 {
                    font-size: 37px;
                }


                .cancel-subscription .owl-item.center .subscription_plan button:hover {
                    background-color: white;
                    color: var(--primary-color);
                }

                .cancel-subscription .owl-item.center .subscription_plan button {
                    background-color: var(--primary-color);
                    border: 1px solid white;
                    color: white;
                }

                .cancel-subscription .owl-carousel .owl-item.center .subscription_plan {
                    transition: .5s ease;
                }

            }

            .cancel-subscription .owl-item.center .subscription_plan p.text-muted {
                color: white !important;
            }

            .cancel-subscription .owl-carousel .owl-item.center .subscription_plan {
                margin-top: 0;
                background-color: var(--primary-color);
                color: white;
            }

            @media screen and (min-width:768px) and (max-width:810px) {
                .cancel-subscription .owl-carousel button.owl-prev {
                    margin-left: 0px;
                }

                .cancel-subscription .owl-carousel button.owl-next {
                    right: 5px;
                }
            }

            @media screen and (max-width:767px) {
                .cancel-subscription .owl-carousel .owl-nav {
                    color: white;
                }

                .cancel-subscription .owl-carousel button.owl-prev {
                    margin-left: 14px;
                }

                .cancel-subscription .owl-carousel button.owl-next {
                    right: 14px;
                }

                .cancel_sub_nav button {
                    width: 176px;
                }

                .cancel_sub_nav .btn-primary {
                    border: 1px solid var(--primary-color) !important;
                }

                .cancel-subscription .footer-wrapper .nav-item .btn-outline-primary {
                    margin: 0 !important;
                }

                .cancel-subscription .owl-carousel .owl-item .subscription_plan {
                    padding: 50px 0 50px 0 !important;
                }
            }

            @media screen and (min-width:767px) {
                .cancel-subscription #third-cancel-Tab>div.container {
                    width: 85%;
                }
            }

            @media screen and (min-width:1280px) {
                #second-cancel-Tab>h4 {
                    margin-top: 80px
                }
            }
        </style>
    @endpush
    @push('after-script')
        <script>
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                center: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 3,
                    }
                },
            });
            $('.cancel_sub_nav .nav-item').on('click', shiftTab);

            function shiftTab() {
                if ($(this).hasClass("next")) {
                    removeClasses();
                    $(this).next().addClass('next');
                    $(this).prev().addClass('prev');
                    if (!($(this).next().attr('data-label') === 'Confirm Cancellation')) $(this).next().find('button').addClass(
                        'btn-primary');
                    $(this).prev().find('button').addClass('btn-outline-primary');
                    $(this).next().find('button').html($(this).next().attr('data-label'));
                    $(this).prev().find('button').html('Back');
                } else if ($(this).hasClass("prev")) {
                    removeClasses();
                    $(this).prev().addClass('prev');
                    $(this).next().addClass('next');
                    $(this).next().find('button').addClass('btn-primary');
                    $(this).prev().find('button').addClass('btn-outline-primary');
                    $(this).next().find('button').html($(this).attr('data-label'));
                    $(this).prev().find('button').html('Back');
                }

            }

            function removeClasses() {
                $('.cancel_sub_nav .nav-item').removeClass('next');
                $('.cancel_sub_nav .nav-item').removeClass('prev');
                $('.cancel_sub_nav .nav-item').find('button').removeClass('btn-primary');
                $('.cancel_sub_nav .nav-item').find('button').removeClass('btn-outline-primary');
            }
        </script>
    @endpush
@stop
