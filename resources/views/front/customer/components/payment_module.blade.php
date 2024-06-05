<h4 class="px-18 text-bold pb-1">{{ __('Make Payment') }}!</h4>
{{-- <p class="px-14 text-med pb-1 mt-4">Please Select Your Preferred Payment Method</p>
<div class="d-flex align-items-center">
    <label class="switch">
        <input type="radio" class="method-btn" id="card-btn" name="method" data-target="card-tab" style="display:none"
            value="1">
        <span class="slider round ms-1"></span>
    </label>
    <img class="ms-3" src="{{ asset('images/card.svg') }}" class="card-icon" width="20px" height="20px" alt="card">
    <span class="ms-1 px-14 text-sb">Credit/Debit Card</span>
</div>
<div class="d-flex align-items-center mt-4">
    <label class="switch">
        <input type="radio" class="method-btn" id="paypal-btn" name="method" data-target="paypal-tab"
            style="display:none" value="1">
        <span class="slider round ms-1"></span>
    </label> <img class="ms-3" src="{{ asset('images/paypal.svg') }}" alt="paypal" width="15" height="15">
    <span class="ms-2 px-14 text-sb">Paypal</span>

</div> --}}
{{-- {{dd("payment",$cardInfo)}} --}}
<div id="card-tab">
    <p class="px-14 text-med my-4">You can make payment via credit card or debit
        card
    </p>

    @if ($cardInfo != 'False')
        <form class="px-14 text-med payment_module" action="{{ route('customer.stripepost', [app()->getLocale()]) }}"
            method="post" class="require-validation" data-cc-on-file="false"
            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="formPayment">
            @csrf
            <input name="student_id" value="{{ $student->id ?? '' }}" type="hidden" id="student_id">
            <input name="total_price"
                @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) value="{{ $planPrice }}"  @else value="" @endif type="hidden"
                id="total-slots-price-2">
            <input name="change_subscription" value="false" type="hidden" id="change_subscription">
            <input type="hidden" id="card-tho" name="card_tho" value="true">
            <input
                @if (isset($student)) @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) name="slots[]" value="{{ count($student->routine_classes) }}" @else value="" name="slots[]" @endif
                @endif type="hidden" id="slots">
            <div class="subscription-card px-3 mb-4">
                <div>
                    <div class="text-end mb-2">End-To-End encrypted <svg width="11" height="14"
                            viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.5002 6.19961H8.7002V3.79961C8.7002 2.03961 7.2602 0.599609 5.5002 0.599609C3.7402 0.599609 2.3002 2.03961 2.3002 3.79961V6.19961H1.5002C1.1002 6.19961 0.700195 6.59961 0.700195 6.99961V12.5996C0.700195 12.9996 1.1002 13.3996 1.5002 13.3996H9.5002C9.9002 13.3996 10.3002 12.9996 10.3002 12.5996V6.99961C10.3002 6.59961 9.9002 6.19961 9.5002 6.19961ZM6.3002 11.7996H4.7002L5.0202 10.0396C4.6202 9.87961 4.3002 9.39961 4.3002 8.99961C4.3002 8.35961 4.8602 7.79961 5.5002 7.79961C6.1402 7.79961 6.7002 8.35961 6.7002 8.99961C6.7002 9.47961 6.4602 9.87961 5.9802 10.0396L6.3002 11.7996ZM7.1002 6.19961H3.9002V3.79961C3.9002 2.91961 4.6202 2.19961 5.5002 2.19961C6.3802 2.19961 7.1002 2.91961 7.1002 3.79961V6.19961Z"
                                fill="#FF7F00" />
                        </svg>
                    </div>
                    <div class="card">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <div class="px-14">
                                    Your Payment Method
                                </div>
                                <a class="text-decoration-none"
                                    href="{{ route('customer.paymentMethod', [app()->getLocale(), 'child' => $student]) }}">
                                    <img class="img-fluid me-1" src="{{ asset('/images/Icon feather-edit-3.svg') }}"
                                        alt="edit-icon" width="14px" height="14px">
                                    <span>Change</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="align-items-center d-flex">
                                <div class="me-2">
                                    <img src="{{ asset('/images/' . $cardInfo['brand'] . '.svg') }}"
                                        alt="{{ $cardInfo['brand'] }}" width="48"
                                        onerror="this.onerror=null;this.src='{{ asset('/images/card.svg') }}'">
                                </div>
                                <div>
                                    <div class="align-items-center d-flex">
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div class="hidden-number"></div>
                                        <div>{{ $cardInfo['last4'] }}</div>
                                    </div>
                                    <div class="px-12 text-secondary" style="line-height: 1;">
                                        VALID THRU : {{ $cardInfo['exp_month'] }}/{{ $cardInfo['exp_year'] }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    @else
        <form class="px-14 text-med payment_module" action="{{ route('customer.stripepost', [app()->getLocale()]) }}"
            method="post" class="require-validation" data-cc-on-file="false"
            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
            @csrf
            <input name="student_id" value="{{ $student->id ?? '' }}" type="hidden" id="student_id">
            <input name="total_price" value="" type="hidden" id="total-slots-price-2">
            <input name="change_subscription" value="false" type="hidden" id="change_subscription">
            <input name="slots[]"
                @if (isset($student)) @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend) value="{{ count($student->routine_classes) }}" @else value="" @endif
                @endif type="hidden" id="slots">


            <label class="form-label text-sb" for="card_name">Card Name</label>
            <input class="form-control py-2 card-name" type="text" name="card_name" placeholder="Card Name"
                pattern="[A-Za-z]+" itle="Please enter valid Card Name" required>
            <label class="form-label mt-4 text-sb " for="card_number">Card
                Number</label>
            <div class="position-relative">
                <input class="form-control py-2 card-number" inputmode="numeric" id="card_number"
                    autocomplete="cc-number" name="number" type="text" maxlength="19"
                    placeholder="xxxx xxxx xxxx xxxx" required>
                <img class="me-2 card-image" src="{{ asset('/images/card.svg') }}" alt="card">
            </div>
            <div class="row">
                <div class="col-sm-8 col-12">
                    <label class="form-label mt-4 text-sb" for="exp_date">Expiry
                        Date</label>
                    {{-- <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                    <input type="text" name="exp_date" class="form-control card-expiry-date"
                        data-target="#datetimepicker" data-toggle="datetimepicker"
                        placeholder=" {{ __('Select Date and Time') }}" value="09/29/2025" />
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div> --}}
                    <input class="form-control py-2 card-expiry-date" placeholder="MM/YY" type="text"
                        onkeyup="formatDate(event);" autocomplete="cc-exp" maxlength="5" name="exp_date"
                        id="exp_date">
                </div>
                <div class="col-sm-4 col-12">
                    <label class="form-label mt-4 text-sb" for="cvv">CVV</label>
                    <input class="form-control py-2 card-cvc" autocomplete="cc-csc" type="text" maxlength="4"
                        name="cvc" placeholder="CVV">
                </div>
            </div>
    @endif
    </form>

</div>
<div id="paypal-tab" style="display: none">
    <p class="px-14 text-med my-4">You will be redirected to the paypal website on
        submission
    </p>
</div>
@push('after-style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 14px;
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

        .hidden-number {
            width: 9px;
            height: 9px;
            background: #333A34;
            /* Inside auto layout */
            flex: none;
            order: 0;
            flex-grow: 0;
            border-radius: 50%;
            margin-left: 1px;
        }

        .hidden-number:nth-child(4n) {
            margin-right: 5px;
        }

        .card-number {
            padding-left: 40px;
        }

        .card-image {
            position: absolute;
            top: 7px;
            width: 25px;
            left: 7px;
        }

        .card-image.mastercard {
            width: 30px;
            margin-top: 2px;
        }

        .card-image.visa {
            width: 30px;
            margin-top: -2px;
        }


        input:checked+.slider::before {
            background-color: var(--primary-color);
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield !important;
        }
    </style>
@endpush
@push('after-script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/payform@1.4.0/dist/payform.min.js"></script> --}}

    <script>
        window.$ = $;
        var asset = "{{ asset('/images//') }}";
    </script>
    {{-- <script src="{{ asset('js/payment.js') }}"></script> --}}
    <script>
        $(function() {
            $('#datetimepicker').datetimepicker({
                minDate: new Date(),
                viewMode: 'years'
            });
        });
        // $('input#card_number').payform('formatCardNumber');

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

        function formatDate(e) {
            var inputChar = String.fromCharCode(event.keyCode);
            var code = event.keyCode;
            var allowedKeys = [8];
            if (allowedKeys.indexOf(code) !== -1) {
                return;
            }

            event.target.value = event.target.value.replace(
                /^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
            ).replace(
                /^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
            ).replace(
                /^([0-1])([3-9])$/g, '0$1/$2' // 13 > 01/3
            ).replace(
                /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
            ).replace(
                /^([0]+)\/|[0]+$/g, '0' // 0/ > 0 and 00 > 0
            ).replace(
                /[^\d\/]|^[\/]*$/g, '' // To allow only digits and `/`
            ).replace(
                /\/\//g, '/' // Prevent entering more than 1 `/`
            );
        }

        $('.card-number').on('input', function() {
            // this.value = this.value.replace(/[^0-9]/g, '');
            if ($(this).val().length < 17) {
                this.value = this.value.replace(/(.{4})/g, '$1 ');
            }
            let card_type = detectCardType(this.value.replace(/\s/g, ''));

            if (card_type != undefined) {
                $('img.card-image').attr('src', `${asset}/${card_type}.svg`).attr('class',
                    `me-2 card-image ${card_type}`);
                console.log(card_type);
            }
        });
        $('.card-number').on('keydown', function(e) {
            // this.value = this.value.replace(/(.{4})/g, '$1 ');
            if (((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e
                    .keyCode >= 97 &&
                    e.keyCode <= 123) || e.keyCode === 32 || e.keyCode === 8) && $(this).val().length <
                19) {
                this.value = this.value.replace(/[^0-9]/g, '');
            }

        })
        $('.card-cvc').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('.card-name').on('input', function() {
            this.value = this.value.replace(/^\s+/g, '').replace(/[^A-Za-z\s]/g, '');
        });
        $('.card-expiry-date').on('input', function() {
            this.value = this.value.replace(/[^0-9/]/g, '');
        });


        function detectCardType(number) {
            var re = {
                electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
                maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
                dankort: /^(5019)\d+$/,
                interpayment: /^(636)\d+$/,
                unionpay: /^(62|88)\d+$/,
                visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
                mastercard: /^5[1-5][0-9]{14}$/,
                amex: /^3[47][0-9]{13}$/,
                diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
                discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
                jcb: /^(?:2131|1800|35\d{3})\d{11}$/
            }

            for (var key in re) {
                if (re[key].test(number)) {
                    return key
                }
            }
        }

        //     $('.payment_module .card-number').formatCardNumber();
        //     $('.payment_module .card-expiry-date').formatCardExpiry();
        //     $('.payment_module .card-cvc').formatCardCVC();
        //
    </script>
@endpush
