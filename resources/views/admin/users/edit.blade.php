@extends('admin.layouts.admin_master',['page' => 'users', 'action' => 'edit'])

@section('actions')
    <div class="text-center">
        <button type="reset" class="btn btn-light me-3" form="create-user-form">Reset</button>
        <button id="submit-user-btn" type="submit" class="btn btn-primary submit-user-btn" form="create-user-form">
            <span class="indicator-label">Submit</span>
        </button>
    </div>
@endsection
@section('content')
    <form id="create-user-form" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.users.update') }}">@csrf</form>
    <input type="hidden" form="create-user-form" name="user_id" value="{{ $id }}">
    @include('admin.users.form', ['action' => 'edit'])
@endsection

@push('after-css')
    <style>
        .iti--allow-dropdown{
            width: 100% !important;
        }
    </style>
@endpush
@push('after-script')
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        const info = document.querySelector(".alert-info");
        const error = document.querySelector(".alert-warning");
        function process(event) {
            event.preventDefault();

            const phoneNumber = phoneInput.getNumber();

            info.style.display = "none";
            error.style.display = "none";

            if (phoneInput.isValidNumber()) {
                info.style.display = "";
                info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
                $('#phone').val(phoneNumber)
                $('.submit-user-btn').attr('disabled', false);
            }
            else {
                error.style.display = "";
                error.innerHTML = `Invalid phone number.`;
                $('.submit-user-btn').attr('disabled', true);
            }
        }
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

        $('#create-user-form').on('submit', function (e) {
            const phoneNumber = phoneInput.getNumber();
            if (phoneInput.isValidNumber()) {
                $('#phone').val(phoneNumber)

            }
        })
    </script>
@endpush
