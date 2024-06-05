@extends('front.layouts.master', ['parent' => true, 'tooltip' => false, 'profile_header' => true])

@section('profile-header')
    @include('front.customer.partials.profile-header', ['activeTab' => 'subscription-tab'])
@stop

@section('content')
    <div class="view-request">
        <div class="container-lg">
            {{-- <ul class="subscription_breadcrumb breadcrumb px-14 px-2 ms-1">
                <li id="first-request-tab">
                    <a href="javascript:void(0)" class="text-decoration-none text-dark text-med me-1">Request Status
                        <i class="fa fa-angle-right d-none mx-2 color-primary" aria-hidden="true"></i></a>
                </li>
                <li id="second-request-tab">
                    <a href="javascript:void(0)" class="active-breadcrumb text-decoration-none color-primary"></a>
                </li>
            </ul> --}}
            <div class="row">
                <div class="col-lg-6 col-sm-8 col-12">
                    <div class="change-request-tabs" id="request-tab">
                        <h4 class="px-18 text-bold pb-1">Change Schedule Request!</h4>
                        <p class="px-14 text-med mb-5">You request has been submitted. Customer support will
                            contact you within 24-48 hours.</p>
                        <div class="row px-14 py-2">
                            <div class="col-4 text-sb">
                                Request Date:
                            </div>
                            <div class="col-8 px-14 text-med">21 Oct 2021</div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4 text-sb">
                                Details:
                            </div>
                            <div class="col-8 px-14 text-med">Lorem ipsum dolor sit amet, consetetur
                                sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et</div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4 text-sb">
                                Status:
                            </div>
                            <div class="col-8 px-14 text-med"><span class="badge status-pill status-danger">Pending</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="change-request-tabs" id="payment-tab" style="display: none">
                        @include('front.customer.components.payment_module')
                    </div> --}}
                    {{-- <div class="row py-2">
                        <div class="col-4 text-sb">
                            Action:
                        </div>
                        <div class="col-8 px-14 text-med"><button class="btn btn-outline-danger">Delete
                                Request</button></div>
                    </div> --}}
                </div>
                <div class="col-lg-1 d-lg-block d-none"></div>
                <div class="col-lg-5 col-sm-4 col-12 mt-5 mt-sm-0">
                    <h4 class="px-18 text-bold pb-2">Invoice:</h4>
                    <div class="package_summary">
                        <div class="container p-3 px-14 text-med">
                            <div class="row py-2">
                                <div class="col-6">Student Name</div>
                                <div class="col-6 text-end">Noman Ali khan</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Course</div>
                                <div class="col-6 text-end">Tajweed Of Quran</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Course Change Fee</div>
                                <div class="col-6 text-end text-bold">20$</div>
                            </div>
                            <hr class="my-2">
                            <div class="row py-2 color-primary">
                                <div class="col-6">Total Price</div>
                                <div class="col-6 text-bold px-24 text-end">- $63</div>
                            </div>
                        </div>

                    </div>
                    <div class="px-14 text-med pt-3 text-end"><a class="text-danger">Delete
                            Request</a></div>
                </div>
            </div>
            <div class="footer-wrapper fixed-bottom">

                <div
                    class="container-lg align-items-start align-items-sm-center mt-sm-0 mt-4 d-flex footer justify-content-between px-xl-4 footer">
                    {{-- <a class="btn btn-outline-primary px-sm-3 py-2 nav-btn"
                        href="{{ route(auth()->user()->user_type . '.subscriptionDetails', app()->getLocale()) }}""
                        data-target="home" data-current="request-tab">Back
                    </a> --}}
                    <a class="btn btn-outline-primary px-sm-3 py-2 nav-btn" data-target="request-tab"
                        data-current="payment-tab" style="display: none">Back
                    </a>
                    <ul class="nav subscription_nav justify-content-end align-items-end align-items-sm-center flex-sm-row flex-column-reverse"
                        id="myTab" role="tablist">
                        {{-- <button
                            class="color-primary text-med px-14 border-0 bg-transparent text-end mt-sm-0 mt-2 me-sm-2 d-inline d-sm-none"
                            href="javascript:void(0)">Need Help?</button>
                        <button
                            class="color-primary text-med px-14 border-0 bg-transparent text-end mt-sm-0 mt-2 me-sm-2 d-sm-inline d-none"
                            href="javascript:void(0)">Need Help in schedule?</button> --}}
                        <button class="btn btn-primary px-sm-3 py-2 nav-btn" id="next" data-target="payment-tab"
                            data-current="request-tab">Next</button>
                        <button class="btn btn-primary px-sm-3 py-2 nav-btn" data-current="payment-tab"
                            id="confirm-schedule-btn" style="display: none">Pay $<span class="total-slots-price">0</span>
                        </button>

                    </ul>
                </div>

            </div>
            {{-- for status pending use this below footer --}}
            {{-- <div class="footer-wrapper fixed-bottom">
            <div class="container-lg align-items-center container-lg d-flex footer justify-content-end px-xl-4 footer">
                <ul class="nav justify-content-end align-items-center" id="myTab" role="tablist">
                    <button class="color-primary text-med px-14 me-4 border-0 bg-transparent text-end"
                        href="javascript:void(0)">Need Help?</button>
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-outline-primary px-5 py-2" id="subscription-tab-three" data-bs-toggle="tab"
                            data-bs-target="#subscription"  role="tab" aria-controls="subscription"
                            aria-selected="false">Back</a>
                    </li>
                </ul>
            </div>
        </div> --}}
        </div>
    </div>

    @push('after-style')
        <style>
            .view-request>.container-lg {
                margin-bottom: 50px;
                margin-top: 130px;
            }

            .view-request .footer {
                height: 80px;
            }

            .view-request .subscription_nav .nav-item {
                display: none;
            }

            .view-request .footer-wrapper .btn {
                width: 220px;
            }

            .view-request .subscription_nav .nav-item.active {
                display: block;
            }

            .view-request .footer-wrapper {
                border-top: 2px solid lightgray;
                background-color: white;
            }

            .view-request .footer-wrapper .nav-link {
                font-size: var(--px-14);
            }

            #back-btn {
                font-size: 14px;
            }

            .view-request .package_summary {
                background-color: #F1F7FF;
            }

            .view-request .package_summary hr {
                background-color: #c9bcbc;
                height: 2px;
            }

            .view-request .payment-col {
                max-width: 500px;
            }

            @media screen and (max-width:576px) {
                .view-request .payment-col {
                    margin: 0 auto 0 auto;
                }

            }

            .view-request .btn-outline-primary:hover {
                background-color: white;
                border-color: #0d6efd;
                color: #0d6efd;
            }

            @media screen and (max-width:576px) {
                .view-request .subscription_nav button {
                    width: 150px;
                }

                .view-request .footer-wrapper .btn {
                    width: 170px;
                }
            }

            @media screen and (max-width:360px) {

                .view-request .footer-wrapper .btn,
                #back-btn {
                    width: 150px;
                    font-size: 12px;
                }
            }
        </style>
    @endpush
    @push('after-script')
        <script>
            $('.nav-btn').on('click', function() {
                let current = $(this).data('current');
                let target = $(this).data('target');
                if (target !== 'home') {
                    $('.change-request-tabs').hide();
                    $('.nav-btn').show();
                    $(`.nav-btn[data-current="${current}"]`).hide();
                    $('#' + target).fadeIn(500);;
                }
            })
        </script>
    @endpush
@stop
