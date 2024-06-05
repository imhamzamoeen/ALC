@extends('auth.layouts.auth_master')

@section('content')
    <div class="d-flex w-100 h-870px h-md-800px h-xl-900px justify-content-center align-items-center bg-white">
        <!--begin::Sign in-->
        <div>
            <!--begin::Form-->
            <form class="w-md-600px form flex-lg-grow-0 px-5 iphone5_topspacing" method="POST"
                action="{{ route('register') }}" id="signup-form">
                @csrf
                <!--begin: Fields-->
                <div data-wizard-type="step-content" data-wizard-state="current">
                    <!--begin::Title-->
                    <h3 class="mb-10 font-weight-bolder text-dark">{{ __('Create Free Account') }}</h3>
                    <!--End::Title-->

                    <!--begin::Form Group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Full Name') }}:</label>
                        <input id="fname" maxlength="50" oninput="this.value=this.value.replace(/[^A-Z.a-z.' ']/g,'');"
                            type="text"
                            class=" @error('name') is-invalid @enderror form-control h-auto py-3 px-4 border-2 font-size-h6"
                            name="name" placeholder="{{ __('Full Name') }}" value="{{ old('name') }}" />
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Form Group-->
                    <!--begin::Form Group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Email') }}:</label>
                        <input type="email"
                            class="form-control h-auto py-3 px-4 border-2 font-size-h6 @error('email') is-invalid @enderror"
                            name="email" placeholder="{{ __('Email') }}"
                            value="{{ old('email', request()->get('email')) }}" />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Form Group-->
                    <!--begin::Form Group-->

                    <div class="form-group password-field">
                        <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Create Password') }}:</label>
                        <input id="password-field" type="password" name="password"
                            class="@error('password') is-invalid @enderror form-control h-auto py-3 px-4 border-2 font-size-h6"
                            placeholder="{{ __('Create Password') }}" value="" />
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password input_img me-2"
                            @error('password') style="margin-right: 1.5em;" @enderror></span>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div id="popover-password">
                        <div class="progress-password">
                            <div id="password-strength" class="progress-bar-password progress-bar-success"
                                role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                style="width:0%">
                            </div>
                        </div>
                    </div><br />
                    <!--end::Form Group-->
                    <!--begin::Form Group-->
                    <div class="form-group phone-field">
                        <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Phone Number') }}:</label><br />
                        <input type="text" id="phone" name="phone" maxlength="14"
                            oninput="this.value=this.value.replace(/[^0-9.+(.).' '.-]/g,'');"
                            class="@error('phone') is-invalid @enderror form-control h-auto py-3 border-2 font-size-h6"
                            {{-- onkeyup="process(event)" --}} value="{{ old('phone') }}" placeholder="{{ __('Phone Number') }}" />
                        <div class="alert alert-success" style="display: none"></div>
                        <div class="alert alert-warning" style="display: none;"></div>
                        @error('phone')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group phone-field">
                        {!! RecaptchaV3::field('register') !!}
                        @error('g-recaptcha-response')
                            <div class="text-danger">
                                {{ __('Request is not authorized due to security concerns.') }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Form Group-->
                </div>
                <!--end: Fields-->
                <!--begin: Lower Form-->

                <!-- refereal -->
                <input type="hidden" name="pf"
                    value="{{ request()->filled('pf') ? str_replace('"', '', $request->pf) : '' }}">
                <input type="hidden" name="pn"
                    value="{{ request()->filled('pn') ? str_replace('"', '', $request->pn) : '' }}">
                @error('pf')
                    <div class="text-danger">
                        {{ __('The url parameter is not valid') }}
                    </div>
                @enderror

                <input id="form-btn" type="submit" style="display: none;">
                <button class="btn py-3 btn-primary confirmButton submitButton w-100"
                    style="background-color: #0A5CD6;">{{ __('Create Free Account') }}</button>

                {{-- <div class="d-flex justify-content-center pt-4">
                    <p class="text-center"><b>OR</b></p>
                </div>
                <div class="w-100">
                    <a href="{{ route('socialLogin', 'google') }}" class="btn btn-default w-100 py-3" style=" color:#0A5CD6;"> <svg class="" style="width: 25px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M113 309l-17 67-65 1a255 255 0 0 1-2-239l58 11 25 58a152 152 0 0 0 1 102z" fill="#fbbb00"></path><path d="M508 208a256 256 0 0 1-92 248l-73-4-10-65c30-17 53-45 66-78H262V208h246z" fill="#518ef8"></path><path d="M416 456a255 255 0 0 1-385-79l82-68a152 152 0 0 0 220 78l83 69z" fill="#28b446"></path><path d="M419 59l-83 68a152 152 0 0 0-224 80l-83-69a256 256 0 0 1 390-79z" fill="#f14336"></path></svg> Continue with Google</a>
                </div> --}}

                <p class="text-center mt-5">{{ __('By signing up for AlQuranClasses') }}, {{ __('you agree to our') }} <a
                        href="https://alquranclasses.com/terms-and-conditions/"
                        style="text-decoration:none;color: var(--primary-color);">{{ __('Terms of use') }} </a>
                    {{ __('and') }} <a href="https://alquranclasses.com/privacy-policy/"
                        style="text-decoration:none;color: var(--primary-color);">{{ __('Privacy Policy') }}</a>.</p>
                <p class="text-center mt-5 pb-70">{{ __('Already Have an Account') }} ? <b><a href="{{ route('login') }}"
                            style="text-decoration:none;color: var(--primary-color);">{{ __('Log In') }} </a></b> </p>

            </form>

            <!--end: Lower Form-->

            <!--end::Form-->
        </div>
        <!--end::Sign in-->

    </div>

    {{-- <div class="login-content flex-column-fluid d-flex flex-column p-10 rightside"> --}}
    {{-- <!--begin::Wrapper--> --}}
    {{-- <div class="d-flex flex-row-fluid flex-center rightdiv"> --}}
    {{--  --}}
    {{-- </div> --}}
    {{-- <!--end::Wrapper--> --}}
    {{-- </div> --}}
@endsection

@push('after-script')
    {{-- <script src="{{ asset('js/plugins.bundle.js') }}"></script>
<script src="{{ asset('js/scripts.bundle.js') }}"></script> --}}
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    {{-- <script src="{{ asset('js/validations.js') }}"></script> --}}
    <script>
        var maxLength = 15;
        $('fname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
        });

        $(document).ready(function() {
            $('#password-field').keyup(function() {
                var password = $('#password-field').val();
                if (checkStrength(password) == false) {

                }
            });

            $('.confirmButton').on('click', function(e) {
                /*const phoneNumber = phoneInput.getNumber();
                if (phoneInput.isValidNumber()) {
                    $('#phone').val(phoneNumber)

                }*/

                $('#form-btn').click()
            })

            function checkStrength(password) {
                var strength = 0;
                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                    strength += 1;
                }

                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
                    strength += 1;
                }
                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                    strength += 1;
                }
                if (password.length > 7) {
                    strength += 1;
                }
                if (strength < 2) {
                    $('#password-strength').addClass('progress-bar-danger');
                    $('#password-strength').css('width', '10%');
                    document.getElementById("password-strength").style.backgroundColor = "red";
                } else if (strength == 2) {
                    $('#password-strength').removeClass('progress-bar-danger');
                    $('#password-strength').addClass('progress-bar-warning');
                    $('#password-strength').css('width', '60%');
                    document.getElementById("password-strength").style.backgroundColor = "orange";
                    return 'Weak'
                } else if (strength == 4) {
                    $('#password-strength').removeClass('progress-bar-warning');
                    $('#password-strength').addClass('progress-bar-success');
                    $('#password-strength').css('width', '100%');
                    document.getElementById("password-strength").style.backgroundColor = "green";
                    return 'Strong'
                }
            }

        });
        /* function process(event) {
             event.preventDefault();

             const phoneNumber = phoneInput.getNumber();

             if (phoneInput.isValidNumber()) {
                 $('#phone').removeClass('is-invalid')
                 $('#phone').addClass('is-valid')
                 $('#phone').val(phoneNumber)
                 $('.submitButton').attr('disabled', false);
             }
             else if(phoneNumber.length === 0){
                 $('#phone').removeClass('is-valid')
                 $('#phone').removeClass('is-invalid')
             }
             else {
                 $('#phone').removeClass('is-valid')
                 $('#phone').addClass('is-invalid')
                 $('.submitButton').attr('disabled', true);
             }
         }*/
        // Password Hide and Show
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        // Phone Numbers (International)
        /*const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });*/
    </script>
@endpush
