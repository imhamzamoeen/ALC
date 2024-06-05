@extends('front.layouts.master')

@section('content')<div class="container vacation-request"><div class="row">
    <div class="col-lg-1 d-lg-block d-none"></div>
    <div class="col-lg-6 col-sm-8 col-12">
        <h4 class="px-18 text-bold pb-1">Vacation Mode</h4>
        <p class="px-14 text-med mb-5">You request has been submitted. Customer support will
            contact you within 24-48 hours.</p>
        <div class="row px-14 py-2">
            <div class="col-4 text-sb">
                Starting Date:
            </div>
            <div class="col-8 px-14 text-med">21 Oct 2022</div>
        </div>
        <div class="row px-14 py-2">
            <div class="col-4 text-sb">
                Ending Date:
            </div>
            <div class="col-8 px-14 text-med">23 Oct 2022</div>
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
            <div class="col-8 px-14 text-med"><span class="badge status-pill status-danger">Pending</span></div>
        </div>
        <div class="row py-2">
            <div class="col-4 text-sb">
                Action:
            </div>
            <div class="col-8 px-14 text-med"><button class="btn btn-outline-danger px-4 py-2">Delete
                    Request</button></div>
        </div>
    </div>
    <div class="col-lg-5 col-sm-4 col-12 mt-5 mt-sm-0">
    </div>
</div>
@stop
@push('after-style')
<style>
    .vacation-request{
        margin-top: 90px;
    }
    .vacation-request .package_summary {
        background-color: #F1F7FF;
    }

    .vacation-request .package_summary hr {
        background-color: #c9bcbc;
        height: 2px;
    }

    .vacation-request .payment-col {
        max-width: 500px;
    }

    @media screen and (max-width:576px) {
        .vacation-request .payment-col {
            margin: 0 auto 0 auto;
        }

    }

</style>
@endpush
