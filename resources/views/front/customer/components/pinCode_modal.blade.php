<div class="modal fade" id="pinCode-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{-- <div class="modal-header border-bottom">
                <h4 class="modal-title text-sb">Trial Details</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body pinCode-modal px-4">
                @include('front.partials.overlay-loader', ['class' => 'd-none'])
                <div class="px-sm-3 py-sm-4 p-0">
                    <h4 class="px-24 text-sb my-3">{{ $type == 'auth' ? 'Enter Pin' : 'Setup Pin' }}</h4>
                    <p class="px-14 text-med mb-5">Please {{ $type == 'auth' ? 'Enter Pin' : 'Setup Pin' }}</p>
                    <form action="{{ $type == 'auth' ? route('customer.checkPin') : route('customer.setupPin') }}"
                        method="post" id="setup_pin">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                class="form-control me-sm-3 me-2 p-4 rounded text-center text-med pin-field"
                                type="text" name="pin_1" autocomplete="off" id="firstInput">
                            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                class="rounded p-4 text-med me-sm-3 me-2 form-control text-center pin-field"
                                type="text" name="pin_2" autocomplete="off" id="">
                            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                class="rounded p-4 text-med me-sm-3 me-2 form-control text-center pin-field"
                                type="text" name="pin_3" autocomplete="off" id="">
                            <input maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                class="rounded p-4 text-med form-control text-center pin-field" type="text"
                                name="pin_4" autocomplete="off" id="">
                            <input type="hidden" id="student_id" name="student_id" value="">
                            <input type="hidden" id="stDashboard" name="stDashboard" value="">
                        </div>
                        <button class="btn btn-primary text-med w-100 mt-5 py-2" id="submitButton" disabled>Submit
                            pin</button>
                        <div class="text-end">
                            @if ($type == 'auth')
                                <button type="button"
                                    class="bg-transparent border-0 my-3 text-med color-primary reset-pin-btn">Forgotten
                                    PIN?</button>
                            @else
                                <button type="button" class="bg-transparent border-0 my-3 text-med color-primary"
                                    data-bs-dismiss="modal" aria-label="Close">Not yet?</button>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('after-style')
    <style>
        .pinCode-modal input {
            font-size: 40px !important;
            width: 93px;
            height: 93px;
        }

        .pinCode-modal input:focus {
            border: 1px solid black;
        }

        /* Chrome, Safari, Edge, Opera */
        .pinCode-modal input::-webkit-outer-spin-button,
        .pinCode-modal input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        .pinCode-modal input[type=number] {
            -moz-appearance: textfield;
        }

        @media screen and (max-width:470px) {
            .pinCode-modal input {
                width: 24%;
                height: 19vw;
            }
        }
    </style>
@endpush

@push('after-script')
    <script>
        $(document).ready(function() {

            //runs when the modal is opened
            $('#pinCode-modal').on('shown.bs.modal', function() {
                // setTimeout(() => {
                $('#firstInput').focus();
                // });

            })
            $('.pin-field').on('input', function(event) {
                var key = event.keyCode || event.charCode;
                if ($(this).val().match(/^[0-9]+$/)) {
                    if ($(this).length > 0 && key !== 8) {
                        $(this).next('.pin-field').focus();
                    } else {
                        $(this).next('.pin-field').val(event);
                    }
                }

                //find the length of the filled pin fields.
                var $nonempty = $('.pin-field').filter(function() {
                    return this.value != ''
                });

                if ($nonempty.length == 4) {
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
            // $('#close-std-modal').on('click', function() {
            //     var pin = '{{ is_null(auth()->user()->customer_pin) }}'
            //     console.log(pin);
            //     if (pin) {
            //         $("#pinCode-modal").modal('toggle')
            //     } else {}
            // })

        });

        $('#setup_pin').on('submit', function(e) {
            e.preventDefault()

            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                async: false,
                beforeSend: function() {
                    $('.pinCode-modal .overlay-loader').removeClass('d-none')
                },
                success: function(response) {
                    Toast.fire({
                        icon: response.status,
                        title: response.message,
                        timer: 1500
                    })

                    if (response.data['stDashboard'] == 'true') {

                        window.location.href = "/en/customer/subscription" + '/' + response.data[
                            'student_id'];
                    } else {

                        @if ($type == 'auth')
                            window.location.replace(
                                '{{ route(auth()->user()->user_type . '.console', app()->getLocale()) }}'
                            )
                        @endif
                    }

                },
                error: function(response) {
                    Toast.fire({
                        icon: response.responseJSON.status,
                        title: response.responseJSON.message,
                        timer: 1500
                    })
                    $('#firstInput').focus();

                }
            }).then(function() {
                $('#setup_pin').trigger('reset')
                $('.pinCode-modal .overlay-loader').addClass('d-none')
                $('#pinCode-modal').modal('toggle')
            }).catch(function() {
                $('#setup_pin').trigger('reset')
                $('.pinCode-modal .overlay-loader').addClass('d-none')
            })
        });
    </script>
    <script>
        $('.reset-pin-btn').on('click', function() {
            Swal.fire({
                text: 'Are you sure you want to reset the console pin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.close()
                    resetPin()
                }
            })
        })

        function resetPin() {
            $.ajax({
                type: 'get',
                url: '{{ route('customer.resetPin') }}',
                beforeSend: function() {
                    $('.pinCode-modal .overlay-loader').removeClass('d-none')
                },
                success: function(response) {
                    Toast.fire({
                        icon: response.status,
                        title: response.message,
                        timer: 1500
                    })
                },
                error: function(response) {
                    Toast.fire({
                        icon: response.responseJSON.status,
                        title: response.responseJSON.message,
                        timer: 1500
                    })
                }
            }).then(function() {
                $('#setup_pin').trigger('reset')
                $('.pinCode-modal .overlay-loader').addClass('d-none')
            }).catch(function() {
                $('#setup_pin').trigger('reset')
                $('.pinCode-modal .overlay-loader').addClass('d-none')
            })
        }
    </script>
@endpush
