@extends('auth.layouts.auth_master')

@section('content')

    <div class="d-flex w-100 h-800px h-lg-500px h-xl-900px justify-content-center align-items-center bg-white login_form">
        <form class="w-md-600px  w-100 form flex-lg-grow-0 px-5 top_space" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">

                <h3 class="mb-10 font-weight-bolder text-dark">{{ __('Log In') }}</h3>
                @if (session('status'))
                    <div class="alert alert-success fade show">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="form-group">
                    <label class="font-weight-bolder text-dark">{{ __('Email') }}:</label>
                    <input type="email" class="form-control h-auto py-3 px-4 border-2 font-size-h6 @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}"/>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group password-field">
                    <label class="font-weight-bolder text-dark">{{ __('Password') }}:</label>

                    <input id="password-field" type="password" name="password" class="@error('password') is-invalid @enderror @error('email') is-invalid @enderror form-control h-auto py-3 px-4 border-2 font-size-h6" placeholder="{{ __('Password') }}" value=""/>

                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password input_img me-2"></span>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="checkbox rememberAndForget ml-0">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember" >
                        <label class="form-check-label ms-1 font-weight-bolder text-dark" for="remember_me" style="line-height:1.7">{{ __('Remember Me') }}</label>
                    </div>
                    <div>
                        <a href="{{ route('password.request') }}" style="text-decoration:none;color:#0A5CD6;">{{ __('Forgot Password?') }}</a>
                    </div>
                </div>
            </div>
            <div class="w-100">
                <button type="submit" class="btn btn-primary w-100 py-3" style="background-color: #0A5CD6;">{{ __('Log In') }}</button>
            </div>
            {{-- <div class="d-flex justify-content-center pt-4">
                <p class="text-center"><b>OR</b></p>
            </div>
            <div class="w-100">
                <a href="{{ route('socialLogin', 'google') }}" class="btn btn-default w-100 py-3" style=" color:#0A5CD6;"> <svg class="" style="width: 25px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M113 309l-17 67-65 1a255 255 0 0 1-2-239l58 11 25 58a152 152 0 0 0 1 102z" fill="#fbbb00"></path><path d="M508 208a256 256 0 0 1-92 248l-73-4-10-65c30-17 53-45 66-78H262V208h246z" fill="#518ef8"></path><path d="M416 456a255 255 0 0 1-385-79l82-68a152 152 0 0 0 220 78l83 69z" fill="#28b446"></path><path d="M419 59l-83 68a152 152 0 0 0-224 80l-83-69a256 256 0 0 1 390-79z" fill="#f14336"></path></svg> Continue with Google</a>
            </div> --}}
            <div class="d-flex justify-content-center pt-3 submitButton alreadyAccount">
                <p><b>{{ __("Don't have an account") }} ? </b><a class="text-decoration-none" href="{{ route('register') }}" style=" color:#0A5CD6;">{{ __('Create Free Account') }} </a></p>
            </div>
        </form>
    </div>


    </div>
@endsection


@push('after-script')
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        // function changeFunction(){
        //     $(".toggle-password").toggleClass("fa-eye fa-eye-slash");
        //     var input = $($(".toggle-password").attr("toggle"));
        //     if (input.attr("type") == "password") {
        //         input.attr("type", "text");
        //     } else {
        //         input.attr("type", "password");
        //     }
        // }
        // $("#password-field").change(function() {

        // });
    </script>
@endpush
