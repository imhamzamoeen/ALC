@extends('front.layouts.master')
@section('content')
    <div class="mx-auto summary_container">
        <h4 class="d-inline mb-3 mb-md-4 text-sb">Monthly Summary</h4>
        <div class="dark mt-4 p-5 summary_wrapper">
            <div class="pb-4 text-bold text-bold">
                Total Number of Classes In September
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Total Trials Conducted
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Trial Successful
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Trial Unsuccessful
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Customer Absent
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Trial Rescheduled
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Valid Routes
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
            <div class="py-4 row summary_item">
                <div class="col-6 text-start text-med">
                    Invalid Routes
                </div>
                <div class="col-6 text-end text-sb">
                    20
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
@endpush
