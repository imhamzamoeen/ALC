@extends('auth.layouts.auth_master')

@section('content')

    <div class="d-flex w-100 h-700px h-lg-500px h-xl-900px justify-content-center align-items-center bg-white login_form">
        <div class="w-md-600px top-space mx-2 mx-lg-0">
            <h3 class="mb-8 font-weight-bolder text-center text-dark display5">{{ __('Welcome To AlQuranClasses') }}</h3>

            <p class="mb-2 text-sm text-center">
                {{ __('Before getting started, we just need some additional information for official use against your email:') }}
            </p>
            <p class="mb-8 text-sm text-center text-sb">
                {{ auth()->user()->email }}
            </p>

            <div>
                <div class="d-flex w-100 justify-content-center align-items-center bg-white login_form">
                    <form class="w-md-600px  w-100 form flex-lg-grow-0 px-5 top_space" method="POST" action="{{ route('customer.submitDetails') }}">
                        @csrf
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Full Name') }}:</label>
                                <input id="fname" maxlength="50" oninput="this.value=this.value.replace(/[^A-Z.a-z.' ']/g,'');" type="text" class=" @error('name') is-invalid @enderror form-control h-auto py-3 px-4 border-2 font-size-h6" name="name" placeholder="{{ __('Full Name') }}" value="{{ old('name', auth()->user()->name) }}"/>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group phone-field">
                                <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Phone Number') }}:</label><br/>
                                <input type="text" id="phone" name="phone" oninput="this.value=this.value.replace(/[^0-9.+(.).' '.-]/g,'');" class="@error('phone') is-invalid @enderror form-control h-auto py-3 border-2 font-size-h6"{{-- onkeyup="process(event)"--}} value="{{ old('phone', auth()->user()->phone) }}" placeholder="{{ __('Phone Number') }}"/>
                                @error('phone')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button class="btn py-3 btn-primary confirmButton submitButton w-100" style="background-color: #0A5CD6;">{{ __('Submit') }}</button>

                        </div>
                    </form>
                </div>
            </div>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="hidden" name="redirect_route" value="{{ route('register') }}">
            </form>
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


@endsection
