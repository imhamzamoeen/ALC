@extends('front.layouts.master', ['parent' => true])

@section('content')


    <div class="edit-subscription">
        <div class="container-lg">
            <ul class="subscription_breadcrumb breadcrumb px-14 px-2 ms-1">
                <li id="first-request-tab">
                    <a href="javascript:void(0)" class="text-decoration-none text-dark text-med me-1">Request Status
                        <i class="fa fa-angle-right d-none mx-2 color-primary" aria-hidden="true"></i></a>
                </li>
                <li id="second-request-tab">
                    <a href="javascript:void(0)" class="active-breadcrumb text-decoration-none color-primary"></a>
                </li>
            </ul>
            <div class="tab-content" id="tab-content">
                <div class="tab-pane fade show active" id="first-Tab" role="tabpanel" aria-labelledby="first-tab">
                    <div class="container">
                        @include('front.customer.components.view_request')
                    </div>


                </div>
                <div class="tab-pane fade show" id="second-Tab" role="tabpanel" aria-labelledby="second-tab">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-12 payment-col me-md-auto px-4">
                            <h4 class="px-18 text-bold pb-1">Make Payment!</h4>
                            <p class="px-14 text-med mb-5">You can make payment via credit card or Stripe
                            </p>
                            @include(
                                'front.customer.components.payment_module'
                            )
                        </div>
                        <div class="col-lg-1 d-lg-block d-none"></div>
                        <div class="col-lg-5 col-md-4 col-12 mt-5 mt-sm-0">

                        </div>
                    </div>

                </div>
            </div>
            <div class="foooter-wrapper fixed-bottom">
                <div class="container-lg align-items-center container-lg d-flex footer justify-content-end px-xl-4 footer">

                    <ul class="nav subscription_nav justify-content-end align-items-center" id="myTab" role="tablist">
                        <button class="color-primary text-med px-14 me-4 border-0 bg-transparent text-end"
                            href="javascript:void(0)">Need Help?</button>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active p-0 text-med" id="first-tab" data-bs-toggle="tab"
                                data-bs-target="#first-Tab"  role="tab" aria-controls="first-Tab"
                                aria-selected="true">

                            </a>
                        </li>
                        <li class="nav-item active" data-label="Select Schedule" role="presentation">
                            <a class="nav-link p-0 text-med" id="second-tab" data-bs-toggle="tab"
                                data-bs-target="#second-Tab"  role="tab" aria-controls="second-Tab"
                                aria-selected="false">
                                <button class="btn btn-primary py-2">Proceed To Payment</button>
                            </a>
                        </li>
                        <li class="nav-item" data-label="Make Payment" role="presentation">
                            <a class="nav-link p-0 text-med">
                                <button class="btn btn-primary py-2">Pay
                                    $94</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('after-style')
        <style>
            .edit-subscription {
                margin-top: 90px
            }

            .edit-subscription>.container-lg {
                margin-bottom: 130px
            }

            .edit-subscription .footer {
                height: 100px;
            }

            .edit-subscription .subscription_nav .nav-item {
                display: none;
            }

            .edit-subscription .subscription_nav button {
                width: 220px;
            }

            .edit-subscription .subscription_nav .nav-item.active {
                display: block;
            }

            .edit-subscription .footer-wrapper {
                border-top: 2px solid lightgray;
                background-color: white;
            }

            @media screen and (max-width:576px) {
                .edit-subscription .subscription_nav button {
                    width: 150px;
                }

                .edit-subscription .subscription_nav button {
                    font-size: 10px !important
                }
            }

        </style>
    @endpush
    @push('after-script')
        <script>
            $('.subscription_nav .nav-item.active').click(function() {
                $('.subscription_nav .nav-item').removeClass('active');
                $(this).next().addClass('active');
            })

            function activeFirstTab() {
                $('.subscription_nav .nav-item').removeClass('active');
                $('.subscription_nav .nav-item:nth-child(3)').addClass('active');
                $('.subscription_nav .nav-link').removeClass('active');
                $('.subscription_nav .nav-link').first().addClass('active');
                $('.edit-subscription .tab-pane').removeClass('active show');
                $('.edit-subscription .tab-pane').first().addClass('active show');
                $('.subscription_breadcrumb').find('i').each(function() {
                    $(this).addClass('d-none');
                })
                var activeBreadcrumb = $('.active-breadcrumb');
                activeBreadcrumb.text('');
            }
            $("#first-request-tab").on('click', activeFirstTab);
        </script>
    @endpush
@stop
