<div>

    {{-- @extends('front.layouts.master', ['parent' => true])

    @section('content') --}}

    <div class="change-subscription">
        <div class="container-lg">
            {{-- <ul class="subscription_breadcrumb breadcrumb px-14 px-2 ms-1 fw-bold">
                <li id="first-tab">
                    <a href="javascript:void(0)" class="text-decoration-none text-dark text-med me-1">Home
                        <i class="fa fa-angle-right mx-2 color-primary"></i></a>
                </li>
                <li id="first-tab">
                    <a href="javascript:void(0)" class="text-decoration-none text-dark text-med me-1">Select Schedule
                        <i class="fa fa-angle-right d-none mx-2 color-primary"></i></a>
                </li>
                <li id="second-tab">
                    <a href="javascript:void(0)" class="active-breadcrumb text-decoration-none color-primary"></a>
                </li>
            </ul> --}}
            @if (\Session::has('error'))
                <div class="alert alert-danger px-14 px-2 py-3 error alert-dismissible">{{ \Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                {{ \Session::forget('error') }}
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success error px-14 px-2 py-3 alert-dismissible">{{ \Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                {{ \Session::forget('success') }}
            @endif
            <div class="tab-content" id="tab-content">
                <div class="tab-pane fade show active" id="firstTab" role="tabpanel" aria-labelledby="1st-tab">
                    <div class="container-lg">
                        <div class="row">
                            <div class="col-lg-7 col-sm-8 col-12">

                                @if ($student->subscription_status != \App\Classes\Enums\StatusEnum::SubscriptionExtend)
                                    <div class="subscription-tabs" id="timetable-tab">
                                        <h4 class="px-18 text-bold pb-1">
                                            {{ __('Setup a Schedule for ' . $student->name) }}!
                                        </h4>

                                        <p class="px-14 text-med mb-1 mb-sm-4">Below are the available days and time
                                            slots
                                            for
                                            <strong> {{ $teacher->name ?? '--' }} </strong>
                                            Please
                                            select slots for each day.
                                        </p>
                                        <p class="px-14 text-med d-sm-none d-block text-danger mt-1 pb-3">
                                            {{ __('Scroll left to view more days') }}</p>

                                        @include('front.customer.components.timetable', [$student])

                                        {{-- <p class="px-14 text-med mt-5">
                                        *Please note that we charge $45 for changing Schedule. Customer Support will
                                        contact you for
                                        further assistance.
                                    </p> --}}
                                    </div>
                                @endif
                                {{-- {{dd($student,$teacher)}} --}}
                                <div class="subscription-tabs" id="payment-tab"
                                    @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) style="display: block" @else
                                    style="display: none" @endif>
                                    @include('front.customer.components.payment_module')

                                </div>
                                <div class='alert-danger px-14 px-2 py-2 alert error form-group mt-3'
                                    style="display: none">Please
                                    correct the errors
                                    and try
                                    again.</div>
                                <div class="alert alert-info mb-0 mb-sm-2 mt-3 px-14 px-2 py-2" role="alert">
                                    *Please note that the Payment of your subscription will be deducted from your
                                    account every month.
                                </div>
                            </div>
                            {{-- <div class="col-lg-1 d-lg-block d-none"></div> --}}
                            <div class="col-lg-5 col-sm-4 col-12 mt-5 mt-sm-0"
                                @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) style="display: none" @else
                                style="display: block" @endif>
                                <h4 class="px-18 text-bold pb-2">{{ __('Package Summary:') }}</h4>
                                <div class="package_summary">
                                    <div class="container-lg p-3 px-14 text-med">
                                        <div class="row py-2">
                                            <div class="col-6 text-bold">Subscription Type</div>
                                            <div class="col-6 text-bold text-end">Monthly</div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-6">Student Name</div>
                                            <div class="col-6 text-end">{{ $student->name ?? '--' }}</div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-6">Course</div>
                                            <div class="col-6 text-end">{{ $student->course->title ?? '--' }}</div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-6">Teacher Name</div>
                                            <div class="col-6 text-end">{{ $teacher->name ?? '--' }}</div>
                                        </div>
                                        @if ($student->subscription_status != \App\Classes\Enums\StatusEnum::SubscriptionExtend)
                                            <hr class="my-2">

                                            <div class="row py-2 mx-0 selected-slots-view">
                                                <div class="col-4 col-sm-12 col-lg-5 px-0 mb-2">Selected Slots</div>
                                                <div class="col-8 col-sm-12 col-lg-7"></div>
                                            </div>
                                        @endif
                                        <hr class="my-2">
                                        <div class="row py-2">
                                            <div class="col-6">Classes Per Week</div>
                                            <div class="col-6 text-end total-selected-slots">0</div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-6">Price Per Class</div>
                                            <div class="col-6 text-bold text-end">
                                                ${{ settings('slot-price') ?? \App\Classes\AlQuranConfig::SlotPrice }}
                                                /month</div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row py-2 align-items-center discount-div">
                                            <div class="col-6"><span class="text-primary">Enter Discount code</span>
                                            </div>
                                            <div class="col-6 text-bold px-24 discount-wrapper text-end">
                                                <div class="btn-group position-relative">
                                                    <input type="text" class="form-control discount" name="discount"
                                                        id="discount" style="font-size: 1rem !important">
                                                    <button class="btn btn-outline-primary btn-apply coupon p-1">
                                                        <span class="text-med">Apply</span>
                                                        <div id="loader"
                                                            style="background-color: transparent;display:none !important">
                                                            <div class="spinner-border color-primary text-light"
                                                                style="width:1.5rem;height:1.5rem" role="status"></div>
                                                        </div>
                                                        <img class="verified" width="20"
                                                            src="{{ asset('images/verified.svg') }}" alt="verified"
                                                            style="filter: invert(22%) sepia(83%) saturate(1890%) hue-rotate(100deg) brightness(98%) contrast(104%);position: absolute;right: 53px;top:3px;">
                                                        {{-- <i class="fa fa-check fa-lg discount-icon"></i> --}}
                                                    </button>
                                                </div>
                                                <div class="text-danger px-12 text-med w-100 error-text">Please Enter
                                                    Valid
                                                    Discount Code
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-6">Discount</div>
                                            <div class="col-6 text-bold text-end">$<span class="discount-value">0</span>
                                            </div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-6">Calculated Price</div>
                                            <div class="col-6 text-bold text-end">$<span
                                                    class="calculated-slots-price">0</span>
                                            </div>
                                        </div>
                                        <div class="row py-2 color-primary">
                                            <div class="col-6">Total Price</div>
                                            <div class="col-6 text-bold px-24 text-end">$<span
                                                    class="total-slots-price">0</span></div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                {{-- <div class="tab-pane fade show" id="secondTab" role="tabpanel" aria-labelledby="2nd-tab">
                    <div class="container-lg">
                        @include('front.customer.components.invoice')
                    </div>
                </div> --}}
            </div>
        </div>
        {{-- for status accepted use this below footer --}}

        <div class="footer-wrapper fixed-bottom">

            {{-- @if (!Route::is('customer.buySubscription')) --}}
            <div
                class="container-lg align-items-start align-items-sm-center my-sm-0 my-3 d-flex footer justify-content-between px-xl-4 footer">
                {{-- <a class="nav nav-item nav-link btn btn-outline-primary px-5 py-2" id="subscription-tab-six"
                    data-bs-toggle="tab" data-bs-target="#subscription" role="tab" aria-controls="subscription"
                    aria-selected="false">Back</a>
                <a class="btn btn-outline-primary px-5 py-2 d-none" id="back-btn-two">Back</a> --}}
                <a class="btn btn-outline-primary px-sm-3 py-2 nav-btn"
                    href="{{ route(auth()->user()->user_type . '.console', app()->getLocale()) }}" data-target="home"
                    data-current="timetable-tab">Back
                </a>
                <a class="btn btn-outline-primary px-sm-3 py-2 nav-btn" data-target="timetable-tab"
                    data-current="payment-tab" style="display: none">Back
                </a>
                <ul class="nav subscription_nav justify-content-end align-items-end align-items-sm-center flex-sm-row flex-column-reverse"
                    id="myTab" role="tablist">
                    {{-- <button
                        class="color-primary text-med px-14 border-0 bg-transparent text-end mt-sm-0 mt-2 me-sm-2 d-inline d-sm-none"
                        href="javascript:void(0)">Need Help?</button> --}}
                    <a class="color-primary text-med px-14 border-0 bg-transparent text-end mt-sm-0 mt-2 me-sm-2"
                        href="{{ route('customer.helpSupport', [app()->getLocale(), 'child' => $student]) }}">Need
                        Help in schedule?</a>
                    <button class="btn btn-primary px-sm-3 py-2 nav-btn" disabled id="next"
                        data-target="payment-tab" data-current="timetable-tab"
                        @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) style="display:none" @endif>Next</button>
                    <button class="btn btn-primary px-sm-3 py-2 nav-btn" type="submit" data-current="payment-tab"
                        data-target="none"
                        @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) id="confirm-schedule-btn-update"
                        style="display: block" @else id="confirm-schedule-btn" style="display: none" @endif>Pay
                        $ @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend)
                            <span class="total-slots-prices">{{ $planPrice }}</span>
                        @else
                            <span class="total-slots-price">0</span>
                        @endif
                    </button>
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link active p-0 text-med" id="1st-tab" data-bs-toggle="tab"
                            data-bs-target="#firstTab" role="tab" aria-controls="firstTab" aria-selected="true"> --}}{{-- <button class="btn btn-primary py-2">Next</button> --}}{{-- </a>
                    </li> --}}
                    {{-- <li class="nav-item active" data-label="Select Schedule" role="presentation">
                        {{-- <a class="nav-link p-0 text-med" id="2nd-tab" data-bs-toggle="tab"
                            data-bs-target="#secondTab" role="tab" aria-controls="secondTab" aria-selected="false"> --}}
                    {{-- <button class="btn btn-primary py-2" type="submit" id="confirm-schedule-btn"
                                form="slots-selection-form" disabled>Next</button> --}}
                    {{-- </a> --}}
                    {{-- </li>
                    <li class="nav-item" data-label="Invoice" role="presentation">
                        <a class="nav-link p-0 text-med" id="subscription-tab-one" data-bs-toggle="tab"
                            data-bs-target="#subscription" role="tab" aria-controls="subscription"
                            aria-selected="false">
                            <button class="btn btn-primary py-2">Confirm</button>
                        </a>
                    </li> --}}
                    {{-- <div
                        class="container-lg align-items-center d-flex footer justify-content-sm-end justify-content-center px-xl-4 footer">
                        <button class="btn btn-primary px-sm-5 py-3" type="submit" id="confirm-schedule-btn" disabled
                            form="slots-selection-form">Pay $<span class="total-slots-price">0</span>
                        </button>
                    </div> --}}
                </ul>
            </div>
            {{-- @else
            <div
                class="container-lg align-items-center d-flex footer justify-content-sm-end justify-content-center px-xl-4 footer">
                <button class="btn btn-primary px-sm-5 py-3" type="submit" id="confirm-schedule-btn" disabled
                    form="slots-selection-form">Pay $<span class="total-slots-price">0</span> </button>
            </div>
            @endif --}}
        </div>

        {{-- for status pending use this below footer --}}
        {{-- <div class="footer-wrapper fixed-bottom">
            <div class="container-lg align-items-center container-lg d-flex footer justify-content-end px-xl-4 footer">
                <ul class="nav justify-content-end align-items-center" id="myTab" role="tablist">
                    <button class="color-primary text-med px-14 me-4 border-0 bg-transparent text-end"
                        href="javascript:void(0)">Need Help?</button>
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-outline-primary px-5 py-2" id="subscription-tab-five" data-bs-toggle="tab"
                            data-bs-target="#subscription" role="tab" aria-controls="subscription"
                            aria-selected="false">Back</a>
                    </li>
                </ul>
            </div>
        </div> --}}
    </div>
    @include('front.customer.partials.modal-loader')

    @push('after-style')
        <style>
            .change-subscription {
                margin-top: 140px;
            }

            .change-subscription .selected-slots {
                background-color: #D9D9D972;
                padding: 5px;
                margin: 1px;
                border-radius: 10px;
                cursor: default;
            }

            .change-subscription .selected-slots i {
                cursor: pointer;
            }

            .change-subscription .selected-slots:hover,
            .change-subscription .selected-slot:hover i.fa-times {
                background-color: var(--primary-color);
                color: white;
            }

            .change-subscription .selected-slots:hover i.fa-times {
                color: white !important;
            }

            .change-subscription .package_summary {
                background-color: #F1F7FF;
            }

            .change-subscription .package_summary hr {
                background-color: #c9bcbc;
                height: 2px;
            }

            .change-subscription .subscription_nav .nav-item {
                display: none;
            }

            .change-subscription .subscription_nav .nav-item.active {
                display: block;
            }

            .change-subscription .footer-wrapper .btn {
                width: 180px;
            }

            <style>.change-subscription {
                margin-top: 140px;
            }

            .change-subscription>.container-lg {
                margin-bottom: 115px;
            }

            .change-subscription .selected-slots {
                background-color: #D9D9D972;
                padding: 5px;
                margin: 1px;
                border-radius: 10px;
                cursor: default;
            }

            .change-subscription .selected-slots i {
                cursor: pointer;
            }

            .change-subscription .selected-slots:hover,
            .change-subscription .selected-slot:hover i.fa-times {
                background-color: var(--primary-color);
                color: white;
            }

            .change-subscription .selected-slots:hover i.fa-times {
                color: white !important;
            }

            .change-subscription .package_summary {
                background-color: #F1F7FF;
            }

            .change-subscription .package_summary hr {
                background-color: #c9bcbc;
                height: 2px;
            }

            .change-subscription .subscription_nav .nav-item {
                display: none;
            }

            .change-subscription .subscription_nav .nav-item.active {
                display: block;
            }

            .change-subscription .footer-wrapper .btn {
                width: 220px;
            }

            .change-subscription .payment-col {
                max-width: 500px;
            }

            .change-subscription .footer {
                height: 80px;
            }

            .change-subscription .footer-wrapper {
                border-top: 2px solid lightgray;
                background-color: white;
            }

            .change-subscription .footer-wrapper .nav-link {
                font-size: var(--px-14);
            }

            .change-subscription .btn-outline-primary:hover {
                background-color: white;
                border-color: #0d6efd;
                color: #0d6efd;
            }

            .change-subscription .selected-slots {
                display: flex;
                align-items: center;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 34px;
                height: 14px;
            }

            .discount-wrapper .verified {
                display: none;
            }

            .discount-wrapper .error-text {
                display: none;
            }

            .discount-wrapper.failed .error-text {
                display: block;
            }

            .discount-wrapper.success .verified {
                display: block;
            }

            .discount-wrapper.success #discount {
                border: 1px solid rgb(52 205 52)
            }

            .discount-wrapper.failed #discount {
                border: 1px solid rgb(207, 41, 41)
            }

            .discount-wrapper .discount-icon {
                display: none;
            }

            /* .discount-wrapper.success span,
                                                                                        .discount-wrapper.failed span {
                                                                                            display: none;
                                                                                        } */

            /* .discount-wrapper.success .discount-icon.fa-check {
                                                                                            display: inline-block;
                                                                                        } */

            .discount:focus {
                border-color: #ffff !important;
            }

            .discount-div {
                display: none;
            }

            .discount {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .btn-apply.coupon {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                height: 30px;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                -o-transition: .4s;
                transition: .4s;
            }

            .slider.round {
                border-radius: 34px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 20px;
                width: 20px;
                left: -5px;
                top: -3px;
                background-color: white;
                -webkit-transition: .4s;
                -o-transition: .4s;
                transition: .4s;
                -webkit-box-shadow: 1px 1px 15px 2px lightgrey;
                box-shadow: 1px 1px 15px 2px lightgrey;
            }

            .slider.round:before {
                border-radius: 50%;
            }

            input:checked+.slider::before {
                background-color: var(--primary-color);
            }

            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            input#discount {
                height: 30px;
            }

            .change-subscription .bootstrap-datetimepicker-widget {
                width: 100% !important;
                inset: auto auto 35px 0 !important;
            }

            #back-btn-two {
                font-size: 14px;
            }

            @media screen and (max-width:576px) {
                .change-subscription .payment-col {
                    margin: 0 auto 0 auto;
                }

                .change-subscription .subscription_nav a {
                    font-size: 14px !important
                }

                .change-subscription .subscription_nav button {
                    width: 150px;
                }

                .change-subscription .footer-wrapper .btn {
                    width: 170px;
                }
            }

            @media screen and (min-width:400px) {
                .change-subscription .selected-slots {
                    width: 49%;
                }

                .change-subscription #payment-tab {
                    width: 75%;
                }
            }

            @media screen and (min-width:576px) and (max-width:991px) {
                .change-subscription .selected-slots {
                    width: 100%;
                }
            }

            @media screen and (max-width:360px) {

                .change-subscription .footer-wrapper .btn,
                #back-btn-two {
                    width: 150px;
                    font-size: 12px;
                }
            }
        </style>
    @endpush
    @push('after-script')
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        {{-- <script type="text/javascript" src="https://js.stripe.com/v3/"></script> --}}
        <script>
            $('.nav-btn').on('click', function() {
                let current = $(this).data('current');
                let target = $(this).data('target');

                if (target !== 'home' && target != 'none') {
                    $('.subscription-tabs').hide();
                    $('.nav-btn').show();
                    $(`.nav-btn[data-current="${current}"]`).hide();
                    $('#' + target).fadeIn(500);
                }
                $('.error .btn-close').click();
            })

            $('.method-btn').on('click', function() {
                $('#confirm-schedule-btn').prop('disabled', false);
                let id = $(this).attr('id');
                if (id === 'card-btn') {
                    $('#card-tab').fadeIn(500);
                    $('#paypal-tab').hide();
                } else {
                    $('#card-tab').hide();
                    $('#paypal-tab').fadeIn(500);
                }
            })
            // $(function() {
            //     $('#datetimepicker').datetimepicker({
            //         minDate: new Date()
            //     });
            // });

            //update-subscription
            $('#confirm-schedule-btn-update').on('click', function() {

                $('#total-slots-price-2').val();
                let card = $('#card-tho').val();
                if (card == "true") {
                    $('#formPayment').submit();
                } else {
                    $('#payment-form').submit();
                }

            });
        </script>
        {{-- stripe validation --}}
        <script>
            $(function() {
                var $form = $("#payment-form");
                $('#loader-modal.modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#payment-form').bind('submit', function(e) {
                    var $form = $("#payment-form"),
                        inputSelector = ['input[type=email]', 'input[type=password]',
                            'input[type=text]', 'input[type=file]',
                            'textarea'
                        ].join(', '),
                        $inputs = $form.find('.required').find(inputSelector),
                        $errorMessage = $form.find('div.error'),
                        valid = true;
                    $errorMessage.hide();

                    $('.has-error').removeClass('has-error');
                    $inputs.each(function(i, el) {
                        var $input = $(el);
                        if ($input.val() === '') {
                            $input.parent().addClass('has-error');
                            $errorMessage.removeClass('hide');
                            e.preventDefault();
                        }
                    });
                    if (!$form.data('cc-on-file')) {
                        e.preventDefault();
                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                        let date = $('.card-expiry-date').val().split('/');
                        let month = date[0];
                        let year = '20' + date[1];
                        Stripe.createToken({
                            number: $('.card-number').val(),
                            cvc: $('.card-cvc').val(),
                            exp_month: month,
                            exp_year: year,
                        }, stripeResponseHandler);
                    }
                });

                function stripeResponseHandler(status, response) {
                    $('#loader-modal').modal('show');
                    console.log(status, response);
                    if (response.error) {
                        $('.error')
                            .show()
                            .text(response.error.message);
                    } else {
                        // token contains id, last4, and card type
                        var token = response['id'];
                        // insert the token into the form so it gets submitted to the server
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $form.get(0).submit();
                    }
                }

            });
        </script>
    @endpush

</div>
