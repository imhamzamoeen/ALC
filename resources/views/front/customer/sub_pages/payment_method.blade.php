@extends('front.layouts.master', ['parent' => true])

@section('content')
<div class="container-xl payment-method">
    <h4 class="text-1 text-sb pb-1">{{ __('Subscriptions') }}</h4>
    <p class="px-14 text-med mb-4 pb-2">
        {{ __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore
        et dolore magna') }}
    </p>
    @if (\Session::has('error'))
    <div class="alert alert-danger px-14 px-2 py-3 alert-dismissible">{{ \Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    {{ \Session::forget('error') }}
    @endif
    @if (\Session::has('success'))
    <div class="alert alert-success px-14 px-2 py-3 alert-dismissible">{{ \Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    {{ \Session::forget('success') }}
    @endif
    <div class="px-18 text-sb pb-3">
        Payment Method
    </div>

    <div class="mb-4 payment-card px-3 shadow-sm">
        <div class="container">
            @if ($cardInfo != 'False')
            <div class="row align-items-center">
                <div class="col-sm-4 col-12 d-flex align-items-center py-2 py-sm-3 ps-0">

                    <img width="50px" class="me-2" src="{{ asset('/images/' . $cardInfo['brand'] . 'svg') }}"
                        alt="{{ $cardInfo['brand'] }}"
                        onerror="this.onerror=null;this.src='{{ asset('/images/card.svg') }}'">

                    <div class="px-14 text-med customer-cardNum">
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

                    </div>
                </div>
                <div
                    class="col-sm-4 col-12 justify-content-sm-center justify-content-start pt-0 pt-sm-2 text-med px-14 d-flex align-items-center">
                    <span class="card-expiry">Valid till
                        {{ $cardInfo['exp_month'] }}/{{ $cardInfo['exp_year'] }}</span>
                </div>
                <div class="col-sm-4 col-12 text-sm-end text-center ps-0 pt-sm-2 pt-0 mt-sm-0 mt-4">
                    <a class="btn btn-outline-primary color-primary px-sm-4 px-2 text-sb d-sm-inline d-none">
                        <span class="px-2" data-bs-target="#modal-payment" data-bs-toggle="modal">Update</span>
                    </a>
                    <a class="btn btn-primary px-sm-4 px-2 text-sb d-sm-none d-inline">
                        <span class="px-5" data-bs-target="#modal-payment" data-bs-toggle="modal">Update</span>
                    </a>
                </div>
            </div>
            @else
            <div class="row align-items-center">
                <div class="col-sm-4 col-12 d-flex align-items-center py-2 py-sm-3 ps-0">
                    <img width="50px" class="me-2" src="{{ asset('/images/card.svg') }}" alt="card">
                    <div class="px-14 text-med customer-cardNum">
                        **** **** **** 1234

                    </div>
                </div>
                <div
                    class="col-sm-4 col-12 justify-content-sm-center justify-content-start pt-0 pt-sm-2 text-med px-14 d-flex align-items-center">
                    <span class="card-expiry">Valid till MM/YY</span>
                </div>
                <div class="col-sm-4 col-12 text-sm-end text-center ps-0 pt-sm-2 pt-0 mt-sm-0 mt-4">
                    <a class="btn btn-outline-primary color-primary px-sm-4 px-2 text-sb d-sm-inline d-none">
                        <span class="px-2" data-bs-target="#modal-payment-create" data-bs-toggle="modal">Create</span>
                    </a>
                    <a class="btn btn-primary px-sm-4 px-2 text-sb d-sm-none d-inline">
                        {{-- <span class="px-5" data-bs-target="#modal-payment" data-bs-toggle="modal">Update</span>
                        --}}
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
    @if(!$subscription->isEmpty())
    <div class="px-18 text-sb pb-3">
        Billing History
    </div>

    <div class="mb-4 payment-card px-3 shadow-sm">
        @foreach ($subscription as $key => $value)
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4 py-2 py-sm-3 px-sm-2 px-0">
                    <div class="px-14 text-med pb-1">
                        {!! date('M d Y', strtotime($value->start_at)) !!}
                    </div>
                </div>
                <div class="col-sm-4 col-2 text-med px-14 px-sm-2 px-0">
                    <div class="text-center pb-1">${{ number_format($value->price, 2) }}</div>
                </div>
                <div class="col-sm-4 col-6 text-end px-sm-2 px-0">
                    <a class="btn color-primary px-0 text-sb" href="{{ url('/en/customer/bill-history') }}">
                        <span class="px-2">View Billing History</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="px-18 text-sb pb-3">
        Current Plans
    </div>
    <table class="vertical-table table-borderless student-list mb-sm-5 mb-0">
        <thead class="table-header">
            <tr>
                <th scope="col" class="align-middle">{{ __('Profiles') }}</th>
                <th scope="col" class="align-middle">{{ __('Status') }}</th>
                <th scope="col">{{ __('Pricing') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscription as $key => $value)
            <tr>
                <td data-label="Student Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!!
                            generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div class="col-12 col-lg-10 col-md-9 align-self-center pe-0 ps-0 ps-md-4"
                            style="text-transform: capitalize">
                            {{ $value->student->name }}</div>
                    </div>
                </td>
                <td data-label="Status">
                    <p class="mt-0 mb-0"> <span class="badge status-pill status-success">Subscription active</span>
                    </p>
                </td>

                <td data-label="Pricing">
                    <div class="px-14 text-med pe-md-3 pe-0">
                        ${{ number_format($value->price, 2) }}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    {{-- create payment card --}}
    <div class="modal fade modal-payment-create" id="modal-payment-create">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header px-4 pb-0">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="px-sm-3 pb-sm-4 p-0">
                        <div class="mb-4">
                            <img src="{{ asset('images/card.svg') }}" width="26px" class="me-1 svg-student" alt="card">
                            <span class="color-primary text-sb px-14">Credit Card</span>
                        </div>
                        <div class='alert-danger px-14 px-2 py-2 alert error form-group mt-3' style="display: none">
                            Please
                            correct the errors
                            and try
                            again.</div>
                        {{-- {{ route('customer.paymentMethodUpdate', [app()->getLocale()]) }} --}}
                        <form class="px-14 text-med payment_module"
                            action="{{ route('customer.paymentMethodCreate', [app()->getLocale()]) }}" method="post"
                            class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="paymentformCreate">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label text-sb" for="card_name">Card Name</label>
                                <input class="form-control py-2 card-name-create" type="text" name="card_name"
                                    placeholder="Card Name" pattern="[A-Za-z]+" itle="Please enter valid Card Name"
                                    required>
                                <label class="form-label mt-4 text-sb " for="card_number">Card
                                    Number</label>
                                <input class="form-control py-2 card-number card-number-create" inputmode="numeric"
                                    autocomplete="cc-number" name="number" type="text" maxlength="19"
                                    placeholder="xxxx xxxx xxxx xxxx" required>
                                <div class="row">
                                    <div class="col-sm-8 col-12">
                                        <label class="form-label mt-4 text-sb" for="exp_date">Expiry
                                            Date</label>
                                        <input class="form-control py-2 card-expiry-date-create" placeholder="MM/YY"
                                            type="text" onkeyup="formatDate(event);" autocomplete="cc-exp" maxlength="5"
                                            name="exp_date" id="exp_date-create" required>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label class="form-label mt-4 text-sb" for="cvv">CVV</label>
                                        <input class="form-control py-2 card-cvc-create" autocomplete="cc-csc"
                                            type="text" minlength="3" maxlength="4" name="cvc" placeholder="CVV"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary submit-btn w-100 mt-4">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- update payment card --}}
    <div class="modal fade modal-payment" id="modal-payment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header px-4 pb-0">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="px-sm-3 pb-sm-4 p-0">
                        <div class="mb-4">
                            <img src="{{ asset('images/card.svg') }}" width="26px" class="me-1 svg-student" alt="card">
                            <span class="color-primary text-sb px-14">Credit Card</span>
                        </div>
                        <div class='alert-danger px-14 px-2 py-2 alert error form-group mt-3' style="display: none">
                            Please
                            correct the errors
                            and try
                            again.</div>
                        {{-- {{ route('customer.paymentMethodUpdate', [app()->getLocale()]) }} --}}
                        <form class="px-14 text-med payment_module"
                            action="{{ route('customer.paymentMethodUpdate', [app()->getLocale()]) }}" method="post"
                            class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="paymentform">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label text-sb" for="card_name">Card Name</label>
                                <input class="form-control py-2 card-name-update" type="text" name="card_name"
                                    placeholder="Card Name" pattern="[A-Za-z]+" itle="Please enter valid Card Name"
                                    required>
                                <label class="form-label mt-4 text-sb " for="card_number">Card
                                    Number</label>
                                <input class="form-control py-2 card-number card-number-update" inputmode="numeric"
                                    autocomplete="cc-number" name="number" type="text" maxlength="19"
                                    placeholder="xxxx xxxx xxxx xxxx" required>
                                <div class="row">
                                    <div class="col-sm-8 col-12">
                                        <label class="form-label mt-4 text-sb" for="exp_date">Expiry
                                            Date</label>
                                        <input class="form-control py-2 card-expiry-date-update" placeholder="MM/YY"
                                            type="text" onkeyup="formatDate(event);" autocomplete="cc-exp" maxlength="5"
                                            name="exp_date" id="exp_date" required>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label class="form-label mt-4 text-sb" for="cvv">CVV</label>
                                        <input class="form-control py-2 card-cvc-update" autocomplete="cc-csc"
                                            type="text" minlength="3" maxlength="4" name="cvc" placeholder="CVV"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary submit-btn w-100 mt-4">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('after-style')
<style>
    .payment-method {
        margin-top: 90px;
    }

    .payment-method .customer-cardNum {
        line-height: 1;
    }

    .payment-card {
        /* border: 1px solid #D9D9D9; */
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .payment-card button,
    .payment-card a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .payment-card .nav,
    .payment-card .nav-link {
        display: inline;
    }

    .payment-card .nav-link {
        font-size: var(--px-14);
    }

    .payment-card button:hover,
    .payment-card button:focus,
    .payment-card a.btn-outline-primary:active,
    .payment-card button:active,
    .payment-card a.btn-outline-primary:hover,
    .payment-card a.btn-outline-primary:focus {
        color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        background: none;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .payment-method .modal-payment input {
        height: 48px;
        border-radius: 9px;
    }

    .payment-method .modal-payment .submit-btn {
        height: 48px;
    }

    .payment-method .modal-payment .form-label {
        font-weight: 700 !important;
    }

    .payment-method .payment-card .btn-primary:hover {
        color: white !important;
    }

    .payment-method .vertical-table th {
        font-weight: 600;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }

    input[type=number] {
        -moz-appearance: textfield !important;
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

    @media screen and (max-width: 400px) {

        .payment-card div,
        .payment-card button {
            font-size: 14px !important;
        }
    }

    @media screen and (max-width:576px) {
        .payment-method .card-expiry {
            font-style: italic;
        }

    }

    @media screen and (max-width:576px) {
        .payment-method td::before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
        }

        .payment-method .vertical-table td {
            padding: 10px 0 10px 0 !important;
        }
    }
</style>
@endpush
@push('after-script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    $(function() {
            $('#datetimepicker').datetimepicker({
                minDate: new Date(),
                viewMode: 'years'
            });
        });

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

        $('.card-number-create').on('input', function() {

            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('.card-cvc-create').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('.card-name-create').on('input', function() {
            this.value = this.value.replace(/^\s+/g, '').replace(/[^A-Za-z\s]/g, '');
        });
        $('.card-expiry-date-create').on('input', function() {
            this.value = this.value.replace(/[^0-9/]/g, '');
        });

        $('.card-number-update').on('input', function() {

            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('.card-cvc-update').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('.card-name-update').on('input', function() {
            this.value = this.value.replace(/^\s+/g, '').replace(/[^A-Za-z\s]/g, '');
        });
        $('.card-expiry-date-update').on('input', function() {
            this.value = this.value.replace(/[^0-9/]/g, '');
        });
        $('.card-number').on('input', function() {
            // this.value = this.value.replace(/[^0-9]/g, '');
            if ($(this).val().length < 17) {
                this.value = this.value.replace(/(.{4})/g, '$1 ');
            }
        });
        $('.card-number').on('keydown', function(e) {
            // this.value = this.value.replace(/(.{4})/g, '$1 ');
            if (((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 &&
                    e.keyCode <= 123) || e.keyCode === 32 || e.keyCode === 8) && $(this).val().length < 19) {
                this.value = this.value.replace(/[^0-9]/g, '');
            }

        })
</script>
<script>
    $(function() {
            var $form = $("#paymentform");
            $('#paymentform').bind('submit', function(e) {
                var $form = $("#paymentform"),
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
                    let date = $('.card-expiry-date-update').val().split('/');
                    let month = date[0];
                    let year = '20' + date[1];
                    Stripe.createToken({
                        number: $('.card-number-update').val(),
                        cvc: $('.card-cvc-update').val(),
                        exp_month: month,
                        exp_year: year,
                    }, stripeResponseHandler);


                }


            });

            function stripeResponseHandler(status, response) {
                console.log(status, response);
                if (response.error) {
                    $('.error')
                        .show()
                        .text(response.error.message);
                } else {
                    $("form").on("submit", function() {
                        $(this).find(":submit").prop("disabled", true);
                    });
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
<script>
    $(function() {
            var $form = $("#paymentformCreate");
            $('#paymentformCreate').bind('submit', function(e) {
                var $form = $("#paymentformCreate"),
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
                    let date = $('.card-expiry-date-create').val().split('/');
                    let month = date[0];
                    let year = '20' + date[1];
                    Stripe.createToken({
                        number: $('.card-number-create').val(),
                        cvc: $('.card-cvc-create').val(),
                        exp_month: month,
                        exp_year: year,
                    }, stripeResponseHandler);

                }

            });

            function stripeResponseHandler(status, response) {
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
<script>
    $("form").on("input", function() {
            $(this).find(":submit").prop("disabled", false);
        });
        $("form").on("submit", function() {
            $(this).find(":submit").prop("disabled", true);
        });
</script>
@endpush