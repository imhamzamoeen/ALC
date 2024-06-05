@extends('auth.layouts.auth_master')

@section('content')

    <div class="d-flex w-100 h-700px h-lg-500px h-xl-900px justify-content-center align-items-center bg-white login_form">
        <div class="w-md-600px top-space mx-2 mx-lg-0">
            <h3 class="mb-8 font-weight-bolder text-center text-dark display5">{{ __('Email Verification Required') }}</h3>

            <p class="mb-2 text-sm text-center">
                {{ __('Before getting started, verify your email address by clicking on the link') }}
            </p>
            <p class="mb-2 text-sm text-center">
                {{ __('We have sent you an email at') }}
            </p>
            <p class="mb-8 text-sm text-center text-sb">
                {{ auth()->user()->email }}
            </p>
            <div class="text-center mb-8">
                <img src="/images/icon.svg" alt="email-sent">

            </div>

            <div >
                <form id="resend-form" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="redirect_route" value="{{ route('register') }}">
                </form>
                <p class="text-center text-sm mb-1">
                    <span class="me-2">Didn't Receive Email?</span><button form="resend-form" type="submit" class="color-primary border-0 text-sb bg-white p-0">
                        {{ __('Resend Email') }}
                    </button>
                </p>
                <p class="text-center text-sm">
                    {{--<span class="me-2">Want To Change Email?</span>--}}
                    <button form="logout-form" type="submit" class="text-dark mt-4 border-0 text-sb bg-white p-0" style="font-size: 14px; text-decoration: underline">
                        {{ __('Back to Signup') }}
                    </button>
                </p>
            </div>
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success bg-primary mt-3">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

        </div>

        </div>




{{--    <div class="login-content flex-column-fluid d-flex flex-column p-10 rightside">--}}

{{--        <div class="d-flex flex-row-fluid flex-center rightdiv">--}}

{{--            <div class="login-form login-form-signup" id="kt_login_singin_form">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="mb-4 text-sm text-gray-600">--}}
{{--                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}--}}
{{--                        </div>--}}
{{--                        <div class="mt-4 flex items-center justify-between">--}}
{{--                            <form id="resend-form" method="POST" action="{{ route('verification.send') }}">--}}
{{--                                @csrf--}}
{{--                            </form>--}}

{{--                            <form id="logout-form" method="POST" action="{{ route('logout') }}">--}}
{{--                                @csrf--}}
{{--                            </form>--}}
{{--                            <button form="resend-form" type="submit" class="btn btn-primary bg-primary">--}}
{{--                                {{ __('Resend Verification Email') }}--}}
{{--                            </button>--}}
{{--                            <button form="logout-form" type="submit" class="btn btn-default float-right">--}}
{{--                                {{ __('Log Out') }}--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                @if (session('status') == 'verification-link-sent')--}}
{{--                    <div class="alert alert-primary mt-3">--}}
{{--                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}

@endsection
