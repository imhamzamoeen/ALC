@extends('front.layouts.master')
@section('content')

    <div class="container-lg salesDashboard">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="unscheduled" role="tabpanel" aria-labelledby="unscheduled-tab">

                @livewire('sales-support.assign-teacher', ['status' => ''])

            </div>
        </div>
    </div>



@endsection
@push('after-style')
    <style>
        .salesDashboard{
            margin-top: 90px;
        }
    </style>
@endpush
