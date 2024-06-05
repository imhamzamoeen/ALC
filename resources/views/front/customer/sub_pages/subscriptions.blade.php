@inject('Enum','App\Classes\Enums\StatusEnum')
@extends('front.layouts.master', ['parent' => true, 'tooltip' => false, 'profile_header' => true])

@section('profile-header')
    @include('front.customer.partials.profile-header', ['activeTab' => 'subscription-tab'])
@stop

@section('content')
    <div class="subscriptionDetails container disable-scroll">
        <div class="px-18 text-bold pb-3">
            Invoice
        </div>
        <div class="subscription-card px-3 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-7 col-sm-9 py-3 px-sm-3 px-0">
                        <div class="px-14 text-sb pb-2">
                            Next Payable Amount:
                        </div>
                        <div class="px-14">
                            @if ($student->is_subscribed == '1' && isset($subscription))
                                ${{ number_format($subscription->price, 2) }} - Due {!! date('M d Y', strtotime($subscription->ends_at)) !!}
                            @else
                                Subscription End
                            @endif

                        </div>
                    </div>
                    <div class="col-6 d-sm-none d-block"></div>
                    <div class="col-6 d-sm-none d-block"></div>
                    <div class="col-12 col-sm-3 text-end">
                        <a class="color-primary px-14 text-sb bg-transparent border-0 text-decoration-none"
                            href={{ url('/en/customer/bill-history') }} id="billingHistory">View Billing
                            History</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="px-18 text-bold pb-3">
            Subscription Plan
        </div>
        <div class="subscription-card px-3 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-sm-2 ps-0 pe-4">
                        <div class="sub-card text-center d-flex align-items-center justify-content-center">
                            <span class="px-14 text-bold">Plus</span>
                        </div>

                    </div>
                    <div class="col-6 py-2 py-sm-3 ps-0">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="px-14 text-sb pb-2">
                                    5 Classes Per week
                                </div>
                                <div class="px-14">
                                    $ 115 / Month
                                </div>
                            </div>
                            <div class="col-sm-5 col-12 text-sm-center text-start pt-2">
                                <span class="badge status-pill status-primary">Pending</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-6 col-sm-1"></div>
                    <div class="col-6 col-sm-3 text-sm-end text-start ps-0 pt-sm-2 mt-2 mt-sm-0 pt-0">
                        <a class="nav nav-item nav-link btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                            href="{{ route('customer.changeSubscription', [app()->getLocale(), 'child' => $student]) }}">
                            <img class="img-fluid me-2" src="{{ asset('/images/Icon feather-edit-3.svg') }}" alt="edit-icon"
                                width="18px" height="18px">
                            <span class="px-2">Change</span>
                        </a>
                        {{-- <a class="btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                        href={{ url('/en/customer/change-subscription') }} id="changeSubscription"><img
                            class="img-fluid me-2" src="{{ asset('/images/Icon feather-edit-3.svg') }}"
                            alt="edit-icon" width="18px" height="18px"><span>Change</span></a> --}}
                        {{-- <a class="btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                            href="{{ route('customer.viewRequest', [app()->getLocale(), 'child' => $student]) }}"><span>View
                                Request</span></a> --}}

                    </div>
                </div>
            </div>

        </div>
        <div class="px-18 text-bold pb-3">
            Teacher Change
        </div>
        <div class="subscription-card px-3 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-sm-2 ps-0 pe-4">
                        <div class="teacher-card text-center d-flex align-items-center justify-content-center">
                            <span class="px-14 text-bold">Teacher Change</span>
                        </div>
                    </div>
                    <div class="col-6 py-2 py-sm-3 ps-0">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                {{ beautify_slug(optional($student->teacher)->name) }}
                            </div>
                            <?php 
                                $Teacher_Status =optional($student->latestChangeRequestOfTeacher)->status ;
                            ?>
                            <div class="col-sm-5 col-12 text-sm-center text-start">
                                <span 
                                @class([
                                    'badge',
                                    'is_invalid',
                                    'status-pill',
                                    'mt-sm-0 ',
                                    'mt-2',
                                    'status-warning'=> $Teacher_Status=='pending',
                                    'status-success'=> $Teacher_Status=='completed',

                                ])
                                >{{  beautify_slug($Teacher_Status) }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-6 col-sm-1"></div>
                    <div class="col-6 col-sm-3 text-sm-end ps-sm-2 ps-0 text-start">
                        @if(!$Teacher_Status || $Teacher_Status==$Enum::ChangeRequestCancelled)
                        <button class="btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                            data-bs-toggle="modal" data-bs-target="#change-teacher-modal" id="changeTeacher"><img
                                class="img-fluid me-2" src="{{ asset('/images/Icon feather-edit-3.svg') }}" alt="edit-icon"
                                width="18px" height="18px"><span class="ms-1 px-2">Change</span></button>
                        @else
                         <a class="nav nav-item nav-link btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                      href="{{ route(auth()->user()->user_type . '.viewRequest', [app()->getLocale(),'child'=>$student]) }}"><span>View
                            Request</span></a>
                         @endif       

                        {{-- <a class="nav nav-item nav-link btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                      href="{{ route(auth()->user()->user_type . '.viewRequest', [app()->getLocale(),'child'=>$student]) }}"><span>View
                            Request</span></a> --}}


                    </div>
                </div>
            </div>

        </div>
        <div class="px-18 text-bold pb-3">
            Courses
        </div>
        <div class="subscription-card px-3 mb-5">
            <div class="container">
                <div class="row align-items-center course-change">
                    <div class="col-6 col-sm-2 ps-0">
                        <img width="100%" height="95px" src="{{ asset('/images/img.png') }}" alt="course-img">
                    </div>
                    <div class="col-6 col-sm-4 ps-0 py-3">
                        <div class="px-14 text-sb pb-2 truncate">
                           {{ optional($student->course)->title }}
                        </div>
                        <div class="px-14 truncate">
                            {{ optional($student->course)->description }}
                        </div>
              
                    </div>
                    <div class="col-6 col-sm-3">
                        <?php 
                        $Course_Status =optional($student->latestChangeRequestOfCourse)->status ;
                    ?>
                <span 
                @class([
                    'badge',
                    'is_invalid',
                    'status-pill',
                    'mt-sm-0 ',
                    'mt-2',
                    'status-warning'=> $Course_Status=='pending',
                    'status-success'=> $Course_Status=='completed',

                ])
                >{{  beautify_slug($Course_Status) }}</span>
                    </div>
                
                    <div class="col-6 col-sm-3 text-sm-end text-start ps-0">
                        @if(!$Course_Status || $Course_Status==$Enum::ChangeRequestCancelled)
                        {{--  This customer has not setted up a request against it  --}}
                        <button class="btn btn-outline-primary text-sb px-sm-4 px-2 change-btn" data-bs-toggle="modal"
                            data-bs-target="#change-course-modal" id="changeCourses"><img class="img-fluid me-2"
                                src="{{ asset('/images/Icon feather-edit-3.svg') }}" alt="edit-icon" width="18px"
                                height="18px"><span class="ms-1 px-2">Change</span></button>
                                @else
                                <a class="nav nav-item nav-link btn btn-outline-primary color-primary px-sm-4 px-2 text-sb change-btn"
                             href="{{ route(auth()->user()->user_type . '.viewRequest', [app()->getLocale(),'child'=>$student]) }}"><span>View
                                   Request</span></a>
                            @endif
                     
                    </div>
                </div>
            </div>
        </div>
        @include('front.customer.components.change_teacher')
        @include('front.customer.components.change_course')
        <div class="row justify-content-end mb-lg-5 mb-0">
            <div class="col-8 col-sm-5 col-lg-3 text-end">
                {{-- <a class="btn cancel-sub px-4 py-2 px-14 text-med" href={{ url('/en/customer/cancel-subscription') }}>Cancel
                    Subscription</a> --}}
                <a class="btn cancel-sub px-4 py-2 px-14 text-med" href="javascript:void(0)">Cancel
                    Subscription</a>
            </div>
        </div>
    </div>
@stop
@push('after-style')
    <style>
        .subscriptionDetails {
            margin-top: 130px;
        }

        .subscription-card {
            border: 1px solid #D9D9D9;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .sub-card {
            background-color: #FFAA0028;
            height: 83px;
        }

        .teacher-card {
            background-color: #99FF6E28;
            height: 83px;
        }

        .subscription-card button,
        .subscription-card a.btn {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .subscription-card .nav,
        .subscription-card .nav-link {
            display: inline;
        }

        .subscription-card .nav-link {
            font-size: var(--px-14);
        }

        .subscription-card button:hover,
        .subscription-card button:focus,
        .subscription-card a.btn:active,
        .subscription-card button:active,
        .subscription-card a.btn:hover,
        .subscription-card a.btn:focus {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            background: none;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .text-break {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .cancel-sub,
        .cancel-sub:hover,
        .cancel-sub:active {
            color: #FF3B3B;
            background-color: #FF3B3B17;
        }

        .subscription-card .change-btn {
            width: 160px;
            height: 44px;
        }

        @media screen and (max-width: 400px) {

            .subscription-card div,
            .subscription-card button {
                font-size: 14px !important;
            }

            .subscription-card .change-btn {
                width: 130px;
                height: 44px;
            }

        }
    </style>
@endpush
@push('after-script')
    <script>
        $('#subscription-tab').on('click', function() {
            setTimeout(() => {
                let intro = introJs().setOptions({
                    steps: [{
                            element: document.querySelector('#billingHistory'),
                            title: 'Billing History',
                            intro: 'Click here to view Billing History 👋'
                        },
                        {
                            element: document.querySelector('#changeSubscription-tab'),
                            title: 'Change Subscription',
                            intro: 'Click here to change subscription 👋'
                        },
                        {
                            element: document.querySelector('#changeTeacher'),
                            title: 'Change Teacher',
                            intro: 'Click here to change teacher 👋'
                        },
                        {
                            element: document.querySelector('#changeCourses'),
                            title: 'Change Course',
                            intro: 'Click here to change courses 👋'
                        }
                    ],
                    tooltipClass: 'customTooltip',
                    exitOnOverlayClick: false
                });
                // intro.start();
                // use below code only when tooltips are displayed
                // $('a , button').not('.introjs-button , .introjs-skipbutton').addClass('avoid-clicks');
                $('.customTooltip').find('.introjs-bullets li').first().addClass('active');
                $('.customTooltip .introjs-nextbutton').on('click', function() {
                    $('.customTooltip li').removeClass('active');
                    $('.customTooltip').find('li > a.active').parent().next().addClass('active')
                });
                $('.customTooltip .introjs-prevbutton').on('click', function() {
                    $('.customTooltip li').removeClass('active');
                    $('.customTooltip').find('li > a.active').parent().prev().addClass('active')
                });
                intro.onexit(function() {
                    enableScroll();
                    $('a , button').removeClass('avoid-clicks')

                });
            }, 200);
            // disableScroll();
            if ($(".disable-scroll").length == 0) {
                enableScroll();
            }
        })
        $("#changeSubscription-tab , #viewTeacherRequest-tab").on('click', function() {
            $(this).removeClass('active');
        })
    </script>
@endpush
