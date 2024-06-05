<div class="invoice">
    <div class="container-xl">
        <div class="header row">
            <div class="column-7 left_column ps-0">
                <img src="{{ asset('/images/logo.svg') }}" alt="logo" class="invoice-logo mb-15">
                <h5 class="text-sb px-14">Hello User, This is the receipt of the Student you are paying for.</h5>
            </div>
            <div class="column-5 pe-0">
                <h2 class="px-32 text-sb px-sm-24">INVOICE</h2>
                <h3 class="px-18 text-med mb-15">For March 2022</h3>
                <h5 class="px-14">Invoice Date</h5>
                <h6 class="px-12 mb-10 text-muted">22/03/2022</h6>
                <h5 class="px-14">Invoice ID</h5>
                <h6 class="px-12 text-muted">#876348</h6>
            </div>
        </div>
    </div>
    <div class="body px-14 text-med">
        <div class="row mb-15">
            <div class="column-6 left_column">
                <p class="mb-15">Student Name</p>
                <p class="mb-15">Course</p>
                <p>Teacher Name</p>
            </div>
            <div class="column-6 pe-0">
                <p class="mb-15 text-bold">Noman Ali khan</p>
                <p class="mb-15 text-bold">Tajweed Of Quran</p>
                <p class="text-bold">Haroon Mukhtar</p>
            </div>
        </div>
        <hr>
        <div class="row mb-15">
            <div class="column-6 left_column">
                <p>Package Summary:</p>
            </div>
            <div class="column-6 pe-0">
                <p class="text-bold">5 Classes Per week<span style="margin-left:15px">$ 115 / Month<Span></p>
            </div>
        </div>
        <hr>
        <div class="container-xl">
            <div class="row row-sm-column mb-15">
                <div class="column-6 column-md-3 column-sm-12 left_column ps-0">
                    <p>Selected Slots</p>
                </div>
                <div class="column-6 column-md-9 column-sm-12 px-0">
                    <div class="container-xl slots-container">
                        <div class="text-sb row row-sm-column text-med">
                            <div class="selected-slot column-6 column-sm-12">Mon [ 06 : 00 - 06 : 30 Pm ]</div>
                            <div class="selected-slot column-6 column-sm-12">Tue [ 07 : 00 - 06 : 30 Pm ]</div>
                            <div class="selected-slot column-6 column-sm-12">Wed [ 08 : 00 - 06 : 30 Pm ]</div>
                            <div class="selected-slot column-6 column-sm-12">Thus [ 09 : 00 - 06 : 30 Pm ]</div>
                            <div class="selected-slot column-6 column-sm-12">Fri [ 07 : 00 - 06 : 30 Pm ]</div>
                            <div class="selected-slot column-6 column-sm-12">Sat [ 06 : 00 - 06 : 30 Pm ]</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-15">
            <div class="column-6 left_column">
                <p class="mb-15">Class Per week</p>
                <p>Price per Class</p>
            </div>
            <div class="column-6 pe-0">
                <p class="mb-15 text-bold">05</p>
                <p class="text-bold">$20 / month</p>
            </div>
        </div>
        <hr>
        <div class="row mb-15">
            <div class="column-6 left_column">
                <p class="mb-15">Calculated Price</p>
                <p>Discount</p>
            </div>
            <div class="column-6 pe-0">
                <p class="mb-15 text-bold">$ 115 / Month</p>
                <p class="text-bold">$20</p>
            </div>
        </div>
        <hr>
        <div class="row mb-25 px-18">
            <div class="column-6 left_column">
                <p class="color-primary">Total Price</p>
            </div>
            <div class="column-6 pe-0">
                <p class="text-sb color-primary px-24">$94</p>
            </div>
        </div>
        <p class="px-14 text-med">In case you have any Queries related to billing, feel free to contact us at: <a
                href="mailto:someone@alquranclasses.com" class="color-primary">someone@alquranclasses.com</a></p>
        <p class="px-14 text-med">Copyright © 2020 | AlQuranClasses All rights Reserved</p>
    </div>
</div>
@push('after-style')
    <style>
        .invoice {
            font-family: Poppins, sans-serif;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .invoice p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        .invoice .invoice-logo {
            width: 172px;
            height: 94px;
        }

        .invoice .header {
            background-color: #F1F7FF;
            padding: 35px 60px;
            align-items: center;
        }

        .invoice .header h2 {
            letter-spacing: 1px;
        }

        .invoice .header h6 {
            font-weight: 400;
        }

        .invoice hr {
            border-top: lightgray;
        }

        .invoice .selected-slot {
            padding: 8px 19px;
            background-color: #F3F3F3;
            margin: 5px 5px 0 0 !important;
            border-radius: 8px;
            text-align: center;
        }

        .invoice .color-primary {
            color: #0A5CD6;
        }

        .invoice .row {
            display: flex;
            flex-wrap: wrap;
        }

        .invoice .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-top: var(--bs-gutter-y);
        }

        .invoice .column-7 {
            width: 60%;
        }

        .invoice .column-6 {
            width: 49%;
        }

        .invoice .column-5 {
            width: 40%;
        }

        .invoice .px-12 {
            font-size: 12px;
        }

        .invoice .px-14 {
            font-size: 14px;
        }

        .invoice .px-18 {
            font-size: 18px;
        }

        .invoice .px-24 {
            font-size: 24px;
        }

        .invoice .px-32 {
            font-size: 32px;
        }

        .invoice .mb-10 {
            margin-bottom: 10px;
        }

        .invoice .mb-15 {
            margin-bottom: 15px;
        }

        .invoice .mb-25 {
            margin-bottom: 25px;
        }

        .invoice .text-muted {
            color: #707070;
        }

        .invoice .left_column {
            text-align: left;
        }

        .invoice .pe-0 {
            text-align: right;
        }

        .invoice .text-med {
            font-weight: 500;
        }

        .invoice .text-sb {
            font-weight: 600;
        }

        .invoice .text-bold {
            font-weight: 700;
        }

        .invoice .body {
            padding: 20px 60px;
        }

        .invoice .slots-container {
            padding: 0;
        }

        .row-sm-column {
            justify-content: space-between;
        }

        @media screen and (max-width:575px) {
            .invoice .column-sm-12 {
                width: 100% !important;
            }

            .invoice .px-sm-24 {
                font-size: 20px !important;
                font-weight: 700 !important;
            }

            .invoice .slots-container {
                padding: 0 7px;
            }

            .invoice .selected-slot {
                padding: 8px 0;
            }

            .row-sm-column {
                flex-direction: column !important;
            }

        }

        @media screen and (max-width:767px) {
            .invoice .invoice-logo {
                width: 140px;
            }

            .invoice .header {
                padding: 35px 13px;
            }

            .invoice .body {
                padding: 20px 13px;
            }

            .invoice .selected-slot {
                margin: 5px 1px 0 !important;
            }
        }

        @media screen and (max-width:991px) {
            .invoice .column-md-9 {
                width: 75%;
            }

            .invoice .column-md-3 {
                width: 25%;
            }
        }

        @media screen and (max-width:1199px) {
            .invoice .selected-slot {
                margin: 5px 2px 0 !important;
            }
        }

    </style>
@endpush
