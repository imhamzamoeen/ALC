@extends('front.layouts.master', ['parent' => true, 'tooltip' => false, 'profile_header' => true])

@section('profile-header')
    @include('front.customer.partials.profile-header', ['activeTab' => 'subscription_tab'])
@stop

@section('content')

    <x-customer.customize-subscription type="buy" :student="$student" :model="$Model" :slot="$slots" :cardInfo="$cardInfo" :planPrice="$planPrice"/>

@stop
