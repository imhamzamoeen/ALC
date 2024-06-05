@extends('front.layouts.master', ['parent' => true])
@section('content')
<div class="profile-settings mx-auto px-sm-0 px-4">
    <div class="px-18 text-med mb-3 text-sb text-center">
        Profile Settings

    </div>
    <div class="d-flex justify-content-center">
        <span class="profile-img position-relative ">
            {{-- <img class="img-fluid" src="{{ asset('images/profile_picture.svg') }}" alt="user_img"> --}}
            {!! generate_profile_picture_by_name($User->name ?? 'M r', 129, 40) !!}
            <button class="editIcon-wrapper d-none"><img class="img-fluid mt-1 ms-1"
                    src="{{ asset('images/icon_edit.svg') }}" alt="edit icon"></button>
        </span>
    </div>
    <form action="{{ route('customer.UpdateProfile') }}" id="profile_update_form" class="position-relative mt-4 mb-5"
        autocomplete="off" method="POST">
        @csrf
        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        <label for="f_name" class="form-label text-sb px-14 mb-1">Full Name</label>
        {{-- <button class="bg-transparent border-0 end-0 ms-auto position-absolute px-14 text-med color-primary">Change
            Email</button> --}}
        <input class="form-control mb-4 py-2" type="text" name="name" value="{{ $User->name ?? '' }}" id="f_name"
            placeholder="Enter Full Name">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="email" class="form-label text-sb px-14 mb-1">Email ID</label>
        {{-- <button data-bs-target="#change-email" data-bs-toggle="modal"
            class="bg-transparent border-0 end-0 ms-auto position-absolute px-14 text-med color-primary">Change
            Email</button> --}}
        <input class="form-control mb-4 py-2" value="{{ $User->email ?? '' }}" type="email" name="email" id="email"
            placeholder="Enter Email">
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="password" class="form-label text-sb px-14 mb-1">Password</label>
        {{-- <button data-bs-target="#change-password" data-bs-toggle="modal"
            class="bg-transparent border-0 end-0 ms-auto position-absolute px-14 text-med color-primary">Change
            Password</button> --}}
        <div class="position-relative">
            <input class="form-control mb-4 py-2" value="" type="password" name="password" id="password"
                autocomplete="nope" readonly onfocus="this.removeAttribute('readonly');" placeholder="Enter Password">
            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password input_img me-2"></span>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
        <label for="phone" class="form-label text-sb px-14 mb-1">Phone Number</label>
        {{-- <button data-bs-target="#change-number" data-bs-toggle="modal"
            class="bg-transparent border-0 end-0 ms-auto position-absolute px-14 text-med color-primary">Change
            Number</button> --}}
        <input class="form-control mb-4 py-2" type="number" name="phone" id="phone"
            oninput="this.value=this.value.replace(/[^0-9.+(.).' '.-]/g,'');" placeholder="Enter Phone Number">
        @error('phone')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="f_name" class="form-label text-sb mb-1 px-14">Customer Console Pin</label>
        {{-- <button data-bs-target="#change-pin" data-bs-toggle="modal"
            class="bg-transparent border-0 end-0 ms-auto position-absolute px-14 text-med color-primary">Change
            Pin</button> --}}
        <div class="d-flex justify-content-between pinCode-input">
            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value=""
                class="form-control me-sm-3 me-2 rounded text-center border pin-field" type="text" name=""
                id="firstinput" autocomplete="off">
            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value=""
                class="rounded text-med me-sm-3 me-2 form-control text-center border pin-field" type="text" name=""
                id="secondinput" autocomplete="off">
            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value=""
                class="rounded text-med me-sm-3 me-2 form-control text-center border pin-field" type="text" name=""
                id="thirdinput" autocomplete="off">
            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value=""
                class="rounded text-med form-control text-center  pin-field" type="text" name="" id="fourthinput"
                autocomplete="off">
        </div>
        @error('pin')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="pin_check_id" class="form-label text-sb mb-1 px-14">Pin Check</label>
        <small>If the pin is enabled the customer console needs pin everytime</small>
        <input type="checkbox"  id="pin_check_id" name="pin_check" id="pin_check" value="1" @if($User->pin_check==1) Checked @endif/>
        @error('pin_check')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="button" class="btn btn-primary w-100 submit-btn mt-3 submit_btn">Save Changes</button>
    </form>
    {{-- <div class="modal fade" id="change-email">
        <div class="modal-dialog modal-dialog-centered">
            <div class="border-0 modal-content ">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title text-med px-18">Change Email</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="">
                        <label for="email" class="form-label">New Email</label>
                        <input type="email" name="email" id="email" class="form-control py-2 mb-3">
                        <label for="password" class="form-label">Current Password</label>
                        <input type="password" name="password" id="mail" class="form-control py-2">
                    </form>
                </div>
                <div class="modal-footer pt-0 pb-3 border-top-0">
                    <div class="h-100 d-flex justify-content-end align-items-center">
                        <a href="#" class="text-dark text-decoration-none fw-bold me-3 px-14" data-bs-dismiss="modal"
                            aria-label="Close">{{ __('Cancel') }}</a>
                        <button class="btn btn-primary py-2 px-4">
                            {{ __('Change Email') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change-number">
        <div class="modal-dialog modal-dialog-centered">
            <div class="border-0 modal-content ">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title text-med px-18">Change Number</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="">
                        <label for="number" class="form-label">New Number</label>
                        <input type="number" name="number" id="number" class="form-control py-2 mb-3">
                        <label for="password" class="form-label">Current Password</label>
                        <input type="password" name="password" id="num" class="form-control py-2">
                    </form>
                </div>
                <div class="modal-footer pt-0 pb-3 border-top-0">
                    <div class="h-100 d-flex justify-content-end align-items-center">
                        <a href="#" class="text-dark text-decoration-none fw-bold me-3 px-14" data-bs-dismiss="modal"
                            aria-label="Close">{{ __('Cancel') }}</a>
                        <button class="btn btn-primary py-2 px-4">
                            {{ __('Change Number') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change-password">
        <div class="modal-dialog modal-dialog-centered">
            <div class="border-0 modal-content ">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title text-med px-18">Change Password</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="">
                        <label for="email" class="form-label">Old Password</label>
                        <input type="password" name="password" id="pass" class="form-control py-2 mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="cPassword" id="cPassword" class="form-control py-2 mb-3">
                        <label for="c_password" class="form-label">Confirm Password</label>
                        <input type="password" name="c_password" id="c_pass" class="form-control py-2">
                    </form>
                </div>
                <div class="modal-footer pt-0 pb-3 border-top-0">
                    <div class="h-100 d-flex justify-content-end align-items-center">
                        <a href="#" class="text-dark text-decoration-none fw-bold me-3 px-14" data-bs-dismiss="modal"
                            aria-label="Close">{{ __('Cancel') }}</a>
                        <button class="btn btn-primary py-2 px-4">
                            {{ __('Change Password') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change-pin">
        <div class="modal-dialog modal-dialog-centered">
            <div class="border-0 modal-content ">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title text-med px-18">Change Pin</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <label for="f_name" class="form-label text-med mb-1">Old Pin</label>
                    <div class="d-flex justify-content-between pinCode -input mb-3">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="form-control me-sm-3 me-2 rounded text-center border pin-field" type="password"
                            name="" id="firstInput">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="rounded text-med me-sm-3 me-2 form-control text-center border pin-field"
                            type="password" name="" id="">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="rounded text-med me-sm-3 me-2 form-control text-center border pin-field"
                            type="password" name="" id="">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="rounded text-med form-control text-center  pin-field" type="password" name="" id="">
                    </div>
                    <label for="f_name" class="form-label text-med mb-1">New Pin</label>
                    <div class="d-flex justify-content-between pinCode-input">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="form-control me-sm-3 me-2 rounded text-center border pin-field" type="password"
                            name="" id="firstInput">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="rounded text-med me-sm-3 me-2 form-control text-center border pin-field"
                            type="password" name="" id="">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="rounded text-med me-sm-3 me-2 form-control text-center border pin-field"
                            type="password" name="" id="">
                        <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                            class="rounded text-med form-control text-center  pin-field" type="password" name="" id="">
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 border-top-0">
                    <div class="h-100 d-flex justify-content-end align-items-center">
                        <a href="#" class="text-dark text-decoration-none fw-bold me-3 px-14" data-bs-dismiss="modal"
                            aria-label="Close">{{ __('Cancel') }}</a>
                        <button id="submitButton" disabled='true' class="btn btn-primary py-2 px-4">
                            {{ __('Change Pin') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@stop
@push('after-style')
<style>
    .profile-settings {
        max-width: 500px;
        margin-top: 90px;
        min-width: 320px;
    }

    .profile-settings input {
        height: 44px;
        font-size: var(--px-14) !important;
    }

    .profile-settings input[type='password'] {
        font-size: 24px !important;
    }

    .profile-img .position-relative {
        width: auto;
    }

    .editIcon-wrapper {
        border: 0;
        border-radius: 50%;
        box-shadow: 1px 1px lightgray;
        position: absolute;
        bottom: 0;
        left: 95px;
        background: white;
        height: 35px;
        width: 35px;
    }

    .editIcon-wrapper>img {
        width: 15px;
    }

    .pinCode-input input {
        font-size: 20px !important;
        width: 22%;
        height: 41px;
        /* background-color: #d4d4d466; */
    }

    .modal-body .pinCode-input input {
        background-color: white;

    }

    .input_img {
        position: absolute;
        right: 10px;
        top: 14px;
        cursor: auto;
        font-size: 15px;
    }

    .submit-btn {
        height: 41px;
    }

    /* .pinCode-modal input:focus {
                                                            border: 1px solid black;
                                                        } */

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    /* @media screen and (max-width:380px) {
                                    .pinCode-input input {
                                        width: 57px !important;
                                    }
                                } */

    /* @media screen and (max-width:500px) {
                                    .pinCode-input input {
                                        width: 22%;
                                    }
                                } */
</style>
@endpush
@push('end-scripts')
<script>
    $(document).ready(function() {
            $('.pin-field').on('input', function(event) {
                var key = event.keyCode || event.charCode;
                if ($(this).val().match(/^[0-9]+$/)) {
                    if ($(this).length > 0 && key !== 8) {
                        $(this).next('.pin-field').focus();
                    } else {
                        $(this).next('.pin-field').val(event);
                    }
                }
                var $nonempty = $('.pin-field').filter(function() {
                    return this.value != ''
                });

                if ($nonempty.length === 8) {
                    $('#submitButton').prop('disabled', false);
                } else {
                    $('#submitButton').prop('disabled', true);
                }
            })
            $('.pin-field').on('keydown', function(event) {
                var key = event.keyCode || event.charCode;
                if (key == 8 && $(this).val() === '') {
                    $(this).prev('.pin-field').focus();
                }
                if (key == 9 && $(this).val() === '') {
                    return false;
                }
            })
        })
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".submit_btn").click(function(e) {
            e.preventDefault();
            pin = $('#firstinput').val() + $('#secondinput').val() + $('#thirdinput').val() + $('#fourthinput')
                .val();

            $("#profile_update_form").append(
                '<input type="hidden" name="customer_pin" value="' + pin + '"/> '
            );
            $("#profile_update_form").submit();
        });
        @if (Session::has('success'))
            toaster('success', 'profile updated successfully')
        @endif
        @if (Session::has('error'))
            toaster('success', 'profile Could not be updated')
        @endif
</script>
@endpush