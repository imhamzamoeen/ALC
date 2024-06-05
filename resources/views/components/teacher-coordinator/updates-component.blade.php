<div class="container-xl notifications-tab">
    <h4 class="px-24 text-sb mb-4">{{ __('Notifications') }}</h4>
    <div class="notifications-nav mb-4">
        <ul class="nav top-navs justify-content-sm-start justify-content-center mb-3" id="myTab" role="tablist">
            <li class="nav-item bg-sec active flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link active py-2 text-center" id="teachers-tab" data-bs-toggle="tab"
                    data-bs-target="#teachers-notifications" role="tab" aria-controls="teachers-notifications"
                    aria-selected="true">Teachers</a>
            </li>
            <li class="nav-item bg-sec flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link py-2 text-center" id="students-tab" data-bs-toggle="tab"
                    data-bs-target="#students-notifications" role="tab" aria-controls="students-notifications"
                    aria-selected=" true"><span>Students</span></a>
            </li>
        </ul>
    </div>
    <div class="row mx-0 flex-sm-row flex-column-reverse mx-0">
        <div class="col-sm-6 col-lg-8 col-12 mt-sm-0 mt-3 ps-sm-0 notification_result">


        </div>
        <div class="col-sm-6 col-lg-4 col-12 pe-sm-0">
            <div class="shadow p-3 pt-5">
                <h2 class="px-18 text-sb mb-4">{{ __('Select date to see notifications') }}</h2>
                @include('front.customer.components.schedule_calender')
            </div>
        </div>
    </div>

</div>

{{-- @push('after-style') --}}
<style>
    .notifications-tab .notifications-nav .bg-sec.active {
        background-color: var(--secondary-color) !important;
        font-weight: 500;
    }

    .notifications-tab>.notifications {
        border: none !important;
    }

    .notifications-tab>.notifications>div {
        border: 1px solid #dee2e6 !important;
    }

    .notifications-tab .timeline-box {
        border-radius: 10px;
    }

    . @media screen and (max-width: 400px) {
        .notifications-tab .notifications-nav .bg-sec {
            margin: 0 !important;
        }
    }

    @media screen and (max-width: 575px) {
        .notifications-tab .notifications-nav a {
            font-size: var(--px-14) !important;
        }
    }

    @media screen and (min-width:992px) {
        .notifications-tab .notifications .col-11 {
            margin-left: -15px
        }
    }
</style>
{{-- @endpush --}}
{{-- @push('after-script') --}}
<script>
    $('.notifications-nav .nav-link').click(function() {
        $('.notifications-nav .bg-sec').removeClass('active');
        $(this).parent().addClass('active');
    });

    $(document).on('click', '.day:not(.wrong-month)', function() {
        const date = $(this).data('date');
        console.log(date.split('T')[0]);
        GetNotification(date.split('T')[0]);

    })
    $(function() {
        //when load plz call the component 
        var date = "{{ \Carbon\Carbon::today()->format('y-m-d') }}";

        GetNotification(date);
    });

    function GetNotification(date) {
        var formdata = new FormData();
        formdata.append('date', date);
        Ajax_Call_Dynamic('{{ route('teacher-coordinator.GetNotifcationForCoordinator', [app()->getLocale()]) }}',
            "POST", formdata, "GetNotificationSuccess",
            'FailedToasterResponse', '.notification_result');
    }

    function GetNotificationSuccess(response) {
        $('.notification_result').html(response.response);
    }
</script>
{{-- @endpush --}}
