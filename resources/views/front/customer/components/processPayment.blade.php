@extends('front.layouts.master', ['parent' => true, 'tooltip' => false, 'profile_header' => true])

@section('profile-header')
    @include('front.customer.partials.profile-header', ['activeTab' => 'subscription_tab'])
@stop

@section('content')
    <div class="payment-methods">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 payment-col me-md-auto">
                    <h4 class="px-18 text-bold pb-1">{{ __('Make Payment') }}!</h4>
                    <p class="px-14 text-med mb-4">You can make payment via credit card or Stripe
                    </p>
                    @include('front.customer.components.payment_module')
                </div>
                <div class="col-lg-1 d-lg-block d-none"></div>
                <div class="col-lg-5 col-md-4 col-12 mt-5 mt-sm-0">
                    <h4 class="px-18 text-bold pb-2">{{ __('Package Summary:') }}</h4>
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

                    <div class="package_summary">
                        <div class="container-lg p-3 px-14 text-med">
                            <div class="row py-2">
                                <div class="col-6 text-sb">Subscription Type</div>
                                <div class="col-6 text-sb text-end">Monthly</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Student Name</div>
                                <div class="col-6 text-end">Haroon Mukhtar</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Course</div>
                                <div class="col-6 text-end">Tajweed</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Teacher Name</div>
                                <div class="col-6 text-end">Noman Ali</div>
                            </div>
                            <hr class="my-2">
                            <div class="row py-2 mx-0 selected-slots-view">
                                <div class="col-4 col-sm-12 col-lg-5 px-0 mb-2">Selected Slots</div>
                                <div class="col-8 col-sm-12 col-lg-7"></div>
                                <div class="col-12 col-sm-6 selected-slots text-center"><span>Mon[01:30 AM - 02:00 AM]
                                    </span></div>
                                <div class="col-12 col-sm-6 selected-slots text-center"><span> Mon[01:30 AM - 02:00 AM]
                                    </span></div>
                                <div class="col-12 col-sm-6 selected-slots text-center"><span>Mon[01:30 AM - 02:00 AM]
                                    </span></div>
                                <div class="col-12 col-sm-6 selected-slots text-center"><span> Mon[01:30 AM - 02:00 AM]
                                    </span></div>
                                <div class="col-12 col-sm-6 selected-slots text-center"><span>Mon[01:30 AM - 02:00 AM]
                                    </span></div>
                            </div>
                            <hr class="my-2">
                            <div class="row py-2">
                                <div class="col-6">Classes Per Week</div>
                                <div class="col-6 text-end total-selected-slots">0</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Price Per Class</div>
                                <div class="col-6 text-bold text-end">
                                    $30/month</div>
                            </div>
                            <hr class="my-2">
                            <div class="row py-2">
                                <div class="col-6">Discount</div>
                                <div class="col-6 text-bold text-end">$0</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-6">Calculated Price</div>
                                <div class="col-6 text-bold text-end">$<span class="calculated-slots-price">0</span></div>
                            </div>
                            <div class="row py-2 color-primary">
                                <div class="col-6">Total Price</div>
                                <div class="col-6 text-bold px-24 text-end">$<span class="total-slots-price">0</span></div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="footer-wrapper fixed-bottom">

            <div
                class="container-lg align-items-start align-items-sm-center mt-sm-0 mt-4 d-flex footer justify-content-between px-xl-4 footer">

                <a class="btn btn-outline-primary px-sm-5 py-3">Back
                </a>
                <ul class="nav subscription_nav justify-content-end align-items-end align-items-sm-center flex-sm-row flex-column-reverse"
                    id="myTab" role="tablist">
                    <button
                        class="color-primary text-med px-14 border-0 bg-transparent text-end mt-sm-0 mt-2 me-sm-2 d-inline d-sm-none"
                        href="javascript:void(0)">Need Help?</button>
                    <button
                        class="color-primary text-med px-14 border-0 bg-transparent text-end mt-sm-0 mt-2 me-sm-2 d-sm-inline d-none"
                        href="javascript:void(0)">Need Help in schedule?</button>
                    <button class="btn btn-primary px-sm-5 py-3" type="submit" id="confirm-schedule-btn"
                        form="slots-selection-form">Pay $<span class="total-slots-price">0</span>
                    </button>

                </ul>
            </div>

        </div>
    </div>


@stop
@push('after-style')
    <style>
        .payment-methods {
            margin-top: 140px;
        }

        .payment-methods>.container-lg {
            margin-bottom: 100px;
        }

        .payment-methods .selected-slots {
            background-color: #D9D9D972;
            padding: 5px;
            margin: 1px;
            border-radius: 10px;
            cursor: default;
        }

        .payment-methods .package_summary {
            background-color: #F1F7FF;
        }

        .payment-methods .package_summary hr {
            background-color: #c9bcbc;
            height: 2px;
        }

        .payment-methods .subscription_nav .nav-item {
            display: none;
        }

        .payment-methods .subscription_nav .nav-item.active {
            display: block;
        }

        .payment-methods .footer-wrapper .btn {
            width: 220px;
        }

        .payment-methods .payment-col {
            max-width: 500px;
        }

        .payment-methods .footer {
            height: 80px;
        }

        .payment-methods .footer-wrapper {
            border-top: 2px solid lightgray;
            background-color: white;
        }

        .payment-methods .footer-wrapper .nav-link {
            font-size: var(--px-14);
        }

        /* .payment-methods .btn-outline-primary:hover {
                background-color: white;
                border-color: #0d6efd;
                color: #0d6efd;
            } */

        .payment-methods .selected-slots {
            display: flex;
            justify-content: center;
        }


        @media screen and (max-width:576px) {
            .payment-methods .payment-col {
                margin: 0 auto 0 auto;
            }

            .payment-methods .subscription_nav a {
                font-size: 14px !important
            }

            .payment-methods .subscription_nav button {
                width: 150px;
            }

            .payment-methods .footer-wrapper .btn {
                width: 170px;
            }
        }


        @media screen and (min-width:400px) {
            .payment-methods .selected-slots {
                width: 49%;
            }
        }

        @media screen and (min-width:576px) and (max-width:991px) {
            .payment-methods .selected-slots {
                width: 100%;
            }
        }

        /* @media screen and (max-width:360px) {

                            .payment-methods .footer-wrapper .btn,
                            #back-btn-two {
                                width: 150px;
                                font-size: 12px;
                            }
                        } */
    </style>
@endpush
