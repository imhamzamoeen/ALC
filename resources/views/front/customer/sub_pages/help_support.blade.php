@extends('front.layouts.master', ['parent' => true])
@include('front.generals.session_messages')
@section('content')
<div class="container helpSupport mb-5">
    <h4 class="text-sb pb-1 px-18">{{ __('Help and Support') }}</h4>
    <p class="px-14 text-med mb-4 pb-2">
        {{ __('You request has been submitted. Customer support will contact you within 24-48 hours.') }}
    </p>
    <div class="row my-5">
        <div class="col-sm-6 col-lg-4 col-12 bg-primary contact-info px-14">
            <h2 class="text-1 text-sb">{{ __('Contact Information') }}</h2>
            <p class="text-med">{{ __('Fill up the form and our team will Contact with you in 24 Hours') }}
            </p>
            <div class="d-flex align-items-center my-4 py-2">
                <img src="{{ asset('/images/phone_icon_contactus.svg') }}" class="me-3" alt="phone">
                <div>US +1 (866) 288-9181<br>CA +1 (866) 302-4897<br>UK +44 (142) 980-4123</div>
            </div>
            <div class="d-flex align-items-center mb-5">
                <img src="{{ asset('/images/contactus_email_icon.svg') }}" class="me-3" alt="mail">
                <div>
                    <div>support@alquranclasses.com</div>
                </div>
            </div>
            <div class="d-flex align-items-center my-3">
                <img src="{{ asset('/images/Icon awesome-calendar-alt.svg') }}" class="me-3" alt="calender">
                <div>
                    <div>{{ __('Hours of Operation') }}</div>
                    <div>{{ __('Mon - Fri : 09 : 00 AM - 10 : 00 PM') }}</div>
                    <div>{{ __('Sat - Sun : 11 : 00 AM - 04 : 00 PM') }}
                    </div>
                </div>
            </div>
            <div class="d-flex mt-5 justify-content-evenly">
                <a href="https://www.facebook.com/I.Luv.Holy.Quran"><img src="/images/facebook-circular-logo.svg"
                        alt="facebook"></a>
                <a href="https://api.whatsapp.com/send?phone=8662889181"><img src="/images/whatsapp.svg"
                        alt="whatsapp"></a>
                <a href="https://twitter.com/alquranclasses"><img src="/images/twitter.svg" alt="twitter"></a>
                <a href="https://www.linkedin.com/in/alquran-classes-2526a535/"><img
                        src="/images/icons8-linkedin-26@2x.png" width="19px" alt="linkedin"></a>
            </div>
        </div>
        <div class="col-lg-1 d-lg-block d-none">

        </div>
        <div class="col-sm-6 col-lg-7 col-12">
            <form action="{{ route('customer.submithelpSupport') }}" method="post" class="px-14 contact-form"
                validate=validate>
                @csrf
                <h5 class="text-sb px-14 mb-4">Fill the form below so we can get to know you and your needs better</h5>
                <label for="email" class="form-label text-med">{{ __('Email ID') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email','@gmail.com') }}" id="email">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <label for="subject" class="form-label mt-4 text-med">{{ __('Subject') }}</label>
                <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject','Support') }}"
                    id="subject">
                @error('subject')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br>
                <label for="details" class="form-label mt-4 text-med">{{ __('Please Specify your Details') }}</label>
                <textarea rows="4" class="form-control @error('details') is-invalid @enderror" value="{{ old('details','Hey Support,') }}"
                    placeholder="Write Here..." name="details" id="details"></textarea>
                @error('details')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary submit-btn float-end clearfix mt-5">Send Message</button>
            </form>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="text-sb px-18">{{ __('Refund Policy') }}</h4>
        <div class="d-sm-flex d-block">
            <div class="px-14 text-med pb-2 truncate" style="max-width: 450px">
                {{ __('Return and refund policy shows the context in which you are suitable for a return or a refund on
                your order.') }}
            </div>
            <span><a target="_blank" class="color-primary text-decoration-none px-14 text-med"
                    href="https://alquranclasses.com/refund-policy/">{{ __('Read More') }}</a></span>
        </div>


    </div>
    <div class="mb-4">
        <h4 class="text-sb px-18">{{ __('Privacy Policy') }}</h4>
        <div class="d-sm-flex d-block">
            <div class="px-14 text-med pb-2 truncate" style="max-width: 450px">
                {{ __('Welcome to our Privacy Policy! It accumulates, warrants, and manages customers’ information who
                have subscribed to our services.') }}
            </div><span><a target="_blank" class="color-primary text-decoration-none px-14 text-med"
                    href="https://alquranclasses.com/privacy-policy/">{{ __('Read More') }}</a></span>
        </div>

    </div>
    <div class="mb-4">
        <h4 class="text-sb px-18">{{ __('Terms And Conditions') }}</h4>
        <div class="d-sm-flex d-block">
            <div class="px-14 text-med pb-2 truncate" style="max-width: 450px">
                {{ __('The Terms and conditions establish a legal contract between Tutors, Students and Parents, and
                AlQuranClasses.') }}
            </div><span><a target="_blank" class="color-primary text-decoration-none px-14 text-med"
                    href="https://alquranclasses.com/terms-and-conditions/">{{ __('Read More') }}</a></span>
        </div>

    </div>
    <div>
        <h4 class="text-sb px-18">{{ __('Frequently Asked Questions') }}</h4>
        <div class="d-sm-flex d-block">
            <div class="px-14 text-med pb-2 truncate" style="max-width: 450px">
                {{ __('Have any Questions?') }}
            </div><span><a target="_blank" class="color-primary text-decoration-none px-14 text-med ms-sm-3"
                    href="https://alquranclasses.com/faqs/">{{ __('Read More') }}</a></span>
        </div>

    </div>
</div>
@stop
@push('after-style')
<style>
    .helpSupport {
        margin-top: 90px;
    }

    .helpSupport .contact-info {
        color: white;
        border-radius: 13px;
        padding: 50px 35px;
    }

    .helpSupport .contact-form {
        padding: 40px 0;
        max-width: 570px;
    }

    .helpSupport .contact-form input {
        height: 44px;
    }

    .helpSupport .submit-btn {
        width: 160px;
        height: 44px;
    }

    @media screen and (max-width:576px) {
        /* .helpSupport .contact-info, .helpSupport .contact-form{
                                width: 92%;
                                margin: 0 auto;
                            } */
    }

    @media screen and (max-width:768px) {
        .helpSupport.container {
            width: 95%
        }
    }
</style>
@endpush

@push('after-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> {{-- for
form validations --}}

<script>
    $(function(){
        $('.contact-form').validate({ // initialize the plugin
            errorClass: "is-invalid",
            focusCleanup: true, // whenever an element is focuesd remove its error
            validClass: "success",
            success: "valid",
        rules: {
            subject: {
                required: true
            },
            details: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
       
        },
        submitHandler: function(form) {
    form.submit();
  }
    });
    });
    $('.contact-form').submit(function (e) { 

       
        e.preventDefault();
  
    
        // $(this).unbind('submit').submit();
    });
</script>

@endpush
