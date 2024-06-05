@extends('front.layouts.master')

@section('content')
<div class="container-lg student_home">
    <div class="tab-content student_home" id="tab-content">
        @if ($student->is_subscribed == 2)
        <div class="alert alert-danger d-flex align-items-center mb-2" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                Your Subscription has been Expired <a href="{{route('customer.buySubscription',['student'=>$student->id,app()->getLocale()])}}" class="alert-link ">Click here<a> to
                        subscribe again
            </div>
            <input type="hidden" id="student" value="{{$student->id}}" >
            @include('front.customer.components.pinCode_modal', [
            'type' => 'auth',
            ])
        </div>
        <div class="text-danger mt-2">Please note that your classes will end after 7 days</div>
        @elseif($student->is_subscribed == 3)
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                Your Subscription has been Ended <a href="#" class="alert-link">Click here<a> to
                        subscribe again
            </div>
        </div>
        @endif
        <div class="tab-pane fade {{ request()->component == 'timeline' ? 'show active' : '' ?? 'show active' }} {{ is_null(request()->component) ? 'show active' : '' }}"
            id="timeline" data-component="timeline" role="tabpanel" aria-labelledby="timeline-tab">
            {{-- AJAX COMPONENT --}}
        </div>
        <div class="tab-pane fade {{ request()->component == 'class_schedule' ? 'show active' : '' }}"
            id="class_schedule" data-component="class_schedule" role="tabpanel" aria-labelledby="class_schedule-tab">
            {{-- AJAX COMPONENT --}}
        </div>
        <div class="tab-pane fade {{ request()->component == 'helping_material' ? 'show active' : '' }}"
            id="helping_material" data-component="helping_material" role="tabpanel"
            aria-labelledby="helping_material-tab">
            {{-- AJAX COMPONENT --}}
        </div>
        {{-- <div class="tab-pane fade" id="vacation" role="tabpanel" aria-labelledby="vacation-tab">
            @include('front.customer.sub_pages.vacation')
        </div> --}}
        <div class="tab-pane fade {{ request()->component == 'recorded_classes' ? 'show active' : '' }}"
            id="recorded_classes" role="tabpanel" data-component="recorded_classes"
            aria-labelledby="recorded_classes-tab">
            {{-- @include('front.customer.student.recorded_classes') --}}
            {{-- AJAX COMPONENT --}}
        </div>

        {{-- <div class="tab-pane fade" id="change_teacher" role="tabpanel" aria-labelledby="change_teacher-tab">
            @include('front.customer.student.teacher')
        </div> --}}


    </div>

</div>

<div class="position-fixed bottom-0 w-100 border-top bg-light" style="z-index: 2">
    <div class="d-none justify-content-center justify-content-sm-start align-items-center container-lg tabs-footer">
        <button class="btn btn-primary" id="back-btn">Back</button>
    </div>
</div>
@push('after-style')
<style>
    .student_home {
        margin-top: 70px;
        margin-bottom: 140px;
    }

    #back-btn {
        width: 200px;
        height: 50px;
        font-size: 14px !important;
    }

    .tabs-footer {
        height: 120px;
    }

    @media screen and (max-width:576px) {
        .student_home {
            margin-top: 90px;
            margin-bottom: 30px;
        }

        .tabs-footer {
            height: 85px;
        }
    }
</style>

{{-- RECORDED CLASS CSS --}}
<style>
    .video-btn,
    .videovideo-btn:active,
    .video-btn:focus {
        background-color: var(--primary-color);
        color: white;
        font-size: 15px;
        outline: none;
    }

    .video-btn img {
        width: 42px;
        height: 42px;
    }

    @media screen and (max-width:576px) {
        .recordings.vertical-table td {
            padding: 10px 0 10px 0 !important;
        }
    }
</style>
@endpush
@push('after-script')
<script>
    var url = '{{ url()->current() }}'
            $(document).ready(function() {
                let currentComponent = '{{ request()->component ?? 'timeline' }}'
                getComponent(currentComponent);
                $(document).on('click', 'a[data-component]', function(e) {
                    var component = $(this).data('component');
                    window.history.pushState({
                        additionalInformation: 'Updated the URL with JS'
                    }, component, url + "?component=" + component);

                    getComponent(component);

                    //below code is used to footer on timeline component
                    if (component != '') {
                        $(document).find('.tabs-footer').removeClass('d-none');
                        $(document).find('.tabs-footer').addClass('d-flex');
                    }
                })
            })

            function getComponent(component) {
                $.ajax({
                    type: 'get',
                    url: '{{ route('customer.student.getComponent', [app()->getLocale(), $student->id]) }}?page=' +
                        component,
                    beforeSend: function() {
                        $('.tab-pane[data-component="' + component + '"]').html(
                            '<div class="overlay-loader d-flex align-items-center justify-content-center flex-column " id="loader" style="background-color: transparent;"><div class="spinner-border color-primary text-light" role="status"></div></div>'
                        )

                    },
                    success: function(response) {
                        $('.tab-pane[data-component="' + component + '"]').html(response.fillableData)
                    },
                    error: function(response) {
                        // setTimeout(() => {
                        //     window.location.reload();
                        // }, 1000);
                    }
                })
            }
</script>

<script>
    var component = "{{ request()->component }}";
            // if (component === '') {
            //     $(document).find('.tabs-footer').removeClass('d-flex');
            //     $(document).find('.tabs-footer').addClass('d-none');
            // } else {
            if (component != '') {
                $(document).find('.tabs-footer').removeClass('d-none');
                $(document).find('.tabs-footer').addClass('d-flex');
            }
            // alert(component);
            $('#back-btn').on('click', function() {
                window.history.back();
                setTimeout(() => {
                    window.location.reload();
                }, 100);
            })
</script>
<script>
    $('.console-btn').on('click', function(e) {
        e.preventDefault()
        $('#stDashboard').val('true');        
        let student = $('#student').val();
        $('#student_id').val(student);
        $('#pinCode-modal').modal('toggle');
       
    })
</script>
@endpush
@stop