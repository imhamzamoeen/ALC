@extends('front.layouts.master', ['parent' => true])

@section('profile-header')
    @include('front.customer.partials.profile-header', ['activeTab' => 'basicinfo-tab'])
@stop

@section('content')
    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
            @include('front.customer.sub_pages.basicInfo')
        </div>
        <div class="tab-pane fade" id="subscription" role="tabpanel" aria-labelledby="subscription-tab">
            @include('front.customer.sub_pages.subscriptions')
        </div>
        {{-- <div class="tab-pane fade" id="vacation" role="tabpanel" aria-labelledby="vacation-tab">
            @include('front.customer.sub_pages.vacation')
        </div> --}}
        <div class="tab-pane fade" id="changeSubscription" role="tabpanel" aria-labelledby="changeSubscription-tab">
            {{-- @include('components.customer.customize-subscription') --}}
        </div>
        <div class="tab-pane fade" id="viewTeacherRequest" role="tabpanel" aria-labelledby="viewTeacherRequest-tab">
            @include('front.customer.sub_pages.view_request_page')
        </div>
    </div>
@stop
@push('after-style')
    <style>
        #basicinfo,
        #subscription,
        #vacation,
        #changeSubscription,
        #viewTeacherRequest {
            margin-top: 130px;
        }
    </style>
@endpush
