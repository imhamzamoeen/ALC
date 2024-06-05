@extends('front.layouts.master', ['parent' => true, 'tooltip' => true])

@section('content')


    <div class="container student-console disable-scroll h-100">
        <div class="row mb-4">
            <div class="col-lg-9 col-sm-8 col-12 text-start">
                <h4 class="text-1 text-bold pb-2">{{ __('Your Students') }}!</h4>
                <p class="text-2">
                    @if (!count($user->profiles))
                        {{ __('Add Student for a free trial') }}.
                    @elseif($user->profiles->count() < \App\Classes\AlQuranConfig::MaxProfiles)
                        {{ __('Student has been
                                                                                                                                                                                                                                                                                                                                                                    registered for a free trial') }},
                        {{ __('add more students for trial') }}.
                </p>
                @endif

            </div>
            <?php /*dd($user->profiles->count()); */
            ?>
            <div class="col-lg-3 col-sm-4 col-12 text-md-end">
                @if ($user->profiles->count() < \App\Classes\AlQuranConfig::MaxProfiles)
                    <button class="btn addStudents btn-primary px-4 py-2" data-id="add-student"
                        wire:click="$emit('resetStudentForm')">
                        <img class="me-1" src="{{ asset('images/profile-add.svg') }}" />Add Students
                    </button>
                @else
                    <div class="alert alert-warning alert-dismissible fade show float-end" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> &nbsp;
                        {{ __(\App\Classes\AlertMessages::STUDENT_LIMIT_EXCEEDED) }}
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

               @if (\Session::has('error'))
                 @include('front.customer.partials.success-modal')
                   {{ \Session::forget('error') }}
              @elseif (\Session::has('success'))
                @include('front.customer.partials.success-modal')
                  {{ \Session::forget('success') }}
               @endif
        </div>
        <div class="h-100 d-flex justify-contwwt-center align-items-center flex-column pb-lg-5 pb-sm-0">
            @livewire('customer.add-student', ['courses' => $courses])
        </div>
    </div>
    @include('front.customer.components.pinCode_modal', ['type' => 'setup'])
    @push('after-style')
        <style>
            .student-console {
                margin-top: 90px;
            }
        </style>
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    @endpush
    @push('after-script')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
        <script>
            $(document).ready(function() {
                if ($('.transaction-status').length > 0) {
                    $('.transaction-status').modal('show');
                }
                user_pin = @JSON($user->customer_pin);
                if (!user_pin) {

                    // $('#pinCode-modal').modal('show');
                }

                const toolTipOptions = {
                    steps: [{
                        element: document.querySelector('.addStudents'),
                        title: 'Add Students',
                        intro: 'Click here to add Students 👋',
                    }],
                    tooltipClass: 'customTooltip',
                    exitOnOverlayClick: false
                };
                if ($('.student-list tr').length > 1) {
                    toolTipOptions.steps.push({
                        element: document.querySelector('.toolTipsettings'),
                        title: 'Edit Settings',
                        intro: 'Click here to edit profile settings 👋',
                    });
                }
                toolTipOptions.steps.unshift({
                    element: document.querySelector('#toolTipUser'),
                    title: 'User Settings',
                    intro: 'Click here to change user settings 👋',

                }, {
                    element: document.querySelector('#toolTipChat'),
                    title: 'Chat',
                    intro: 'Click here to chat 👋'
                }, {
                    element: document.querySelector('#toolTipNotif'),
                    title: 'Notifications',
                    intro: 'Click here to see notifications 👋',
                });

                // let intro = introJs().setOptions(toolTipOptions).start();
                // // use below code only when tooltips are displayed
                //  $('a , button').not('.introjs-button , .introjs-skipbutton').addClass('avoid-clicks');
                // intro.onexit(function() {
                //     enableScroll();
                //     $('a , button').removeClass('avoid-clicks')
                // });
                if ($(".disable-scroll").length == 0) {
                    enableScroll();
                }
                $('form input').on('keypress', function(e) {
                    return e.which !== 13;
                });
                $('.add-student-modal.modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('button[data-id="add-student"], a[data-id="add-student"], img[data-id="add-student"]').on('click',
                    function() {
                        $('#add-student-form')[0].reset();
                        Livewire.emit('resetStudentForm')
                        $('#trial-modal').modal('toggle');

                        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                        $('select[name="timezone"]').val(timezone).change();
                        Livewire.emit('setValue', {
                            'timezone': timezone
                        });
                    });

                $('#custom-course-input').on('focus', function() {
                    $('#custom-check').prop('checked', true)
                    Livewire.emit('updateCustom', 'course_id', 0)
                })
                $('#custom-check').on('click', function() {
                    $('#custom-course-input').focus()
                })
            })
            // @if (\Session::has('error'))
            //     Toast.fire({
            //         icon: "error",
            //         title: ,
            //         {{ \Session::get('error') }}
            //     });
            //     {{ \Session::forget('error') }}
            // @endif
            // @if (\Session::has('success'))
            //     Toast.fire({
            //         icon: "success",
            //         title: {{ \Session::get('success') }},
                            // timer: 1500
            //     });
            //     {{ \Session::forget('success') }}
            // @endif
        </script>
    @endpush

@stop
