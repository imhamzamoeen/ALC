@extends('front.layouts.master', ['parent' => true, 'tooltip' => false, 'profile_header' => true])

@section('profile-header')
    @include('front.customer.partials.profile-header', ['activeTab' => 'basicinfo-tab'])
@stop

@section('content')
    <div class="container">
        <div class="editStudent-info">
            <div class="row">
                <div class="col-12 col-md-6 user-profile">
                    <div class="d-flex justify-content-center">
                        <span class="profile-img position-relative ">
                            {{-- <img class="img-fluid" src="{{ asset('images/profile_picture.svg') }}" alt="user_img"> --}}
                            {!! generate_profile_picture_by_name($student->name, 140, 40) !!}
                            {{-- <button class="editIcon-wrapper"><img class="img-fluid mt-1 ms-1"
                                    src="{{ asset('images/icon_edit.svg') }}" alt="edit icon"></button> --}}
                        </span>
                    </div>
                    <div class="row mx-auto px-14 pt-5 user-info mb-md-0 mb-4">
                        <div>
                            <div class="text-bold d-table"><span>Student Name:</span></div>
                            <div class="text-bold d-table"><span>Gender:</span></div>
                            <div class="text-bold d-table"><span>Status:</span></div>
                            <div class="text-bold d-table"><span>Teacher Name:</span></div>
                            <div class="text-bold d-table"><span>Course:</span></div>
                            <div class="text-bold d-table"><span>Shift:</span></div>
                        </div>
                        <div>
                            <div class="d-table"><span>{{ ucfirst($student->name) ?? '--' }}</span></div>
                            <div class="d-table"><span>{{ ucfirst($student->gender) ?? '--' }}</span></div>
                            <div class="d-table"><span
                                    class="badge status-pill {{  \App\Classes\Enums\StatusEnum::$Subscription_status_color[@$student->subscription_status] ?? 'status-primary' }}">{{  beautify_slug(@$student->subscription_status) ?? '--' }}</span>
                            </div>
                            <div class="d-table"><span>{{ $student->teacher->name ?? '--' }}</span></div>
                            <div class="d-table"><span>{{ $student->course->title ?? '--' }}</span></div>
                            <div class="d-table">
                                <span>{{ $student->shift_id ? \App\Classes\AlQuranConfig::Shifts[$student->shift_id] : '--' }}</span>
                            </div>
                        </div>
                        {{-- <div>
                        <button
                            class="border-2 btn btn-outline-danger mt-2 mt-md-5 mt-1 text-med w-100 delete-btn">Delete
                            Profile</button>
                    </div> --}}
                    </div>
                </div>
                <div class="col-lg-2 col-md-1 col d-sm-block d-none"></div>
                <div class="col-12 col-lg-4 col-md-5 mt-1 mt-md-0 px-4 px-md-0">
                    @include('front.customer.components.student_stats', ['chart_data' => $chart_data])
                </div>
            </div>
            {{-- <div class="d-sm-block d-none"> --}}
            <!-- this dive is populated with js as the controller sends an html json and js puts it here -->
            <div id="attendance">

            </div>

            {{-- @include('front.generals.calender') --}}
            {{-- </div> --}}
        </div>
    </div>
@stop

@push('after-style')
    <style>
        .user-profile .position-relative {
            width: auto;
        }

        .editStudent-info {
            margin-top: 130px;
        }

        .editIcon-wrapper {
            border: 0;
            border-radius: 50%;
            box-shadow: 1px 1px lightgray;
            position: absolute;
            bottom: 0;
            left: 110px;
            background: white;
            height: 35px;
            width: 35px;
        }

        .user-profile .delete-btn {
            padding: 12px 0 12px 0;
        }

        .editIcon-wrapper>img {
            width: 15px;
        }

        .user-info {
            width: 80%;
        }

        .user-info>div:first-child {
            width: 55%;
        }

        .user-info>div:nth-child(2) {
            width: 45%;
        }

        .user-info div.d-table {
            height: 40px;
        }

        .user-info div.d-table>span {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
@endpush
@push('after-script')
    <script>
        $('#attendance').html(@json($data));
    </script>
@endpush
