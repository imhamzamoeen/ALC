@extends('front.layouts.master')

@section('content')
    <div class="container-lg teacher_dashboard">
        <div class="tab-content" id="tab-content">

            <div class="tab-pane fade  {{ request()->component == 'timeline' ? 'show active' : '' }} {{ is_null(request()->component) ? 'show active' : '' }}"
                id="timeline" data-component="timeline" role="tabpanel" aria-labelledby="timeline-tab">

            </div>

            <div class="tab-pane fade {{ request()->component == 'schedule' ? 'show active' : '' }} " id="schedule"
                data-component="schedule" role="tabpanel" aria-labelledby="schedule-tab">

            </div>

            <div class="tab-pane fade {{ request()->component == 'students' ? 'show active' : '' }} " id="students"
                data-component="students" role="tabpanel" aria-labelledby="students-tab">

            </div>
            {{-- <div class="tab-pane fade {{ request()->component == 'vacation' ? 'show active' : '' }} " id="vacation"
            data-component="vacation" role="tabpanel" aria-labelledby="vacation-tab">

        </div> --}}
            {{-- <div class="tab-pane fade" id="vacation" role="tabpanel" aria-labelledby="vacation-tab">
            @include('front.customer.sub_pages.vacation')
        </div> --}}

            <div class="tab-pane fade {{ request()->component == 'class_stats' ? 'show active' : '' ?? 'show active' }} "
                id="class_stats" data-component="class_stats" role="tabpanel" aria-labelledby="class_stats-tab">

            </div>

            {{-- <div class="tab-pane fade {{ request()->component == 'attendance' ? 'show active' : '' ?? 'show active' }} " id="attendance" role="tabpanel" aria-labelledby="attendance-tab" > 
                @include('front.teacher.attendance')
            </div> --}}
            {{-- <div class="tab-pane fade" id="class_stats" role="tabpanel" aria-labelledby="class_stats-tab">
            @include('front.teacher.class_stats')
        </div> --}}
        </div>
    </div>
    <div class="position-fixed bottom-0 w-100 border-top bg-light" style="z-index: 2">
        <div class="d-none justify-content-center justify-content-sm-start align-items-center container-lg tabs-footer">
            <button class="btn btn-primary" id="back-btn">Back</button>
        </div>
    </div>
@stop

@push('after-style')
    {{-- Teacher dashboard global css --}}
    <style>
        .teacher_dashboard {
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
            .teacher_dashboard {
                margin-top: 90px;
                margin-bottom: 30px;
            }

            .tabs-footer {
                height: 85px;
            }
    </style>
    {{-- Attendance Styles --}}
    <style>
        @media screen and (max-width:575px) {
            .fc-daygrid {
                overflow-x: scroll;
            }

            .fc-scrollgrid {
                min-width: 800px;
            }

            .attendance-container {
                padding-top: 3rem !important;
            }
        }
    </style>
@endpush
@push('after-script')
    {{-- ajax components scrips --}}
    <script>
        var url = '{{ url()->current() }}';
        var WhereToPlaceHtml = '{{ request()->component ?? 'timeline' }}';
        var RouteGetComponent = '{{ route('teacher.getComponent', [app()->getLocale()]) }}';
        let currentmin = new Date().getMinutes();
        $(function() {
            let currentComponent = '{{ request()->component ?? 'timeline' }}'
            // console.log('comp: ' + currentComponent)
            getComponent(currentComponent);
            $(document).on('click', 'a[data-component]', function(e) {

                var component = $(this).data('component');
                WhereToPlaceHtml = component;
                window.history.pushState({
                    additionalInformation: 'Updated the URL with JS'
                }, 'Title', url + "?component=" + component);
                getComponent(component);

                //below code is used to footer on timeline component
                if (component != '') {
                    $(document).find('.tabs-footer').removeClass('d-none');
                    $(document).find('.tabs-footer').addClass('d-flex');
                }
            })
        });

        function TeacherGetComponentSuccess(response) {
            $('.tab-pane[data-component="' + WhereToPlaceHtml + '"]').html(response.response);
        }

        function getComponent(currentComponent) {

            Ajax_Call_Dynamic(RouteGetComponent + '?page=' + currentComponent, "GET", {}, "TeacherGetComponentSuccess",
                'FailedToasterResponse', '.tab-pane[data-component="' + currentComponent + '"]');
        }

        $(function() {
            currentmin = new Date().getMinutes();
            console.log('currentmin: ' + currentmin);
            if (currentmin < 30) page_to_refresh = (Math.abs(currentmin - 30) * 60000);
            else page_to_refresh = (Math.abs(currentmin - 60) * 60000);

            // page_to_refresh = 3000;
            // page_to_refresh=(Math.abs(currentmin-30)*60000);
            console.log('page_to_refresh: ' + page_to_refresh / 60000);
            window.setTimeout(function() {
                window.location.reload();
            }, page_to_refresh); // refresh a page after :30 or 00 is clocking
        });
    </script>

    <script>
        var component = "{{ request()->component }}";
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
@endpush
