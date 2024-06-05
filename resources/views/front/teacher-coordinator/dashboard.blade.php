@extends('front.layouts.master')

@section('content')
    <div class="container-lg coordinator_dashboard">
        <div class="tab-content" id="tab-content">
            <div class="tab-pane fade  {{ request()->component == 'teacher' ? 'show active' : '' }} {{ is_null(request()->component) ? 'show active' : '' }}"
                id="teacher" data-component="teacher" role="tabpanel" aria-labelledby="teacher-tab"> </div>

            {{-- <div class="tab-pane fade show active" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
            @include('front.teacher-coordinator.teacher')
        </div> --}}

            <div class="tab-pane fade  {{ request()->component == 'schedule' ? 'show active' : '' }}" id="schedule"
                data-component="schedule" role="tabpanel" aria-labelledby="schedule-tab"> </div>

            {{-- <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">


            @include('front.teacher-coordinator.schedule')
        </div> --}}

            <div class="tab-pane fade  {{ request()->component == 'library' ? 'show active' : '' }}" id="library"
                data-component="library" role="tabpanel" aria-labelledby="library-tab"> </div>

            <div class="tab-pane fade  {{ request()->component == 'updates' ? 'show active' : '' }}" id="updates"
                data-component="updates" role="tabpanel" aria-labelledby="updates-tab"> </div>


            <div class="tab-pane fade  {{ request()->component == 'schedule_changes' ? 'show active' : '' }}"
                id="schedule_changes" data-component="schedule_changes" role="tabpanel"
                aria-labelledby="schedule_changes-tab"> </div>

            {{-- <div class="tab-pane fade" id="library" role="tabpanel" aria-labelledby="library-tab">
            @include('front.teacher-coordinator.library')
        </div> --}}
            {{-- <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
            @include('front.teacher-coordinator.upload')
        </div>
        <div class="tab-pane fade" id="updates" role="tabpanel" aria-labelledby="updates-tab">
            @include('front.teacher-coordinator.updates')
        </div>
        <div class="tab-pane fade" id="schedule_changes" role="tabpanel" aria-labelledby="schedule_changes-tab">
            @include('front.teacher-coordinator.schedule_changes')
        </div>
        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
            @include('front.teacher-coordinator.attendance')
        </div>
        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
            @include('front.teacher-coordinator.students')
        </div>
        <div class="tab-pane fade" id="recordings" role="tabpanel" aria-labelledby="recordings-tab">
            @include('front.teacher-coordinator.recordings')
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
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <style>
        .coordinator_dashboard {
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
            .coordinator_dashboard {
                margin-top: 90px;
                margin-bottom: 30px;
            }

            .tabs-footer {
                height: 85px;
            }

            ul.pagination {
                margin-bottom: 0 !important;
            }
        }
    </style>
@endpush
@push('after-script')
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    {{-- ajax components scrips --}}
    <script>
        var url = '{{ url()->current() }}';
        var WhereToPlaceHtml = '{{ request()->component ?? 'teacher' }}';
        var RouteGetComponent = '{{ route('teacher-coordinator.getComponent', [app()->getLocale()]) }}';
        $(function() {

            let currentComponent = '{{ request()->component ?? 'teacher' }}'
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

        function TeacherCoordinatorGetComponentSuccess(response) {
            $('.tab-pane[data-component="' + WhereToPlaceHtml + '"]').html(response.response);
        }

        function getComponent(currentComponent) {

            Ajax_Call_Dynamic(RouteGetComponent + '?page=' + currentComponent, "GET", {},
                "TeacherCoordinatorGetComponentSuccess",
                'FailedToasterResponse', '.tab-pane[data-component="' + currentComponent + '"]', 'False');
        }

        // refresh the page after 30 minutes ..
        $(function() {
            let currentmin = new Date().getMinutes();
            if (currentmin < 30) page_to_refresh = (Math.abs(currentmin - 30) * 60000);
            else page_to_refresh = (Math.abs(currentmin - 60) * 60000);

            // page_to_refresh=(Math.abs(currentmin-30)*60000);
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
        $('#back-btn').on('click', function() {
            window.history.back();
            setTimeout(() => {
                window.location.reload();
            }, 100);
        })
    </script>
@endpush
