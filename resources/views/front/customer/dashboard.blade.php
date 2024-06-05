@extends('front.layouts.master', ['parent' => true])

@section('content')
    <div class="student_dashboard bg-light">
        <div class="container-xl">
            <h4 class="text-center mb-5 text-sb">{{ __('Welcome to AlQuranClasses!') }}</h4>
            {{-- <div class="row">
                <div class="col-md-8 col-lg-9 col-12"> --}}
            <div class="row">
                @foreach ($profiles as $student)
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card student-card">
                            <a class="text-decoration-none text-dark"
                                href="{{ route('customer.student.studentDashboard', [app()->getLocale(), $student]) }}">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center">
                                        {!! generate_profile_picture_by_name($student->name, 80, 35) !!}

                                    </div>
                                    <h5 class="card-title mt-3 px-18 text-sb text-capitalize">{{ $student->name }}</h5>
                                    <p
                                        class="text-center mt-3 badge status-pill px-3 {{ \App\Classes\Enums\StatusEnum::$Subscription_status_color[@$student->subscription_status] ?? 'status-primary' }}">
                                        {{ beautify_slug($student->subscription_status) }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- </div> --}}
            {{-- <div class="col-md-4 col-lg-3 col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title px-18 text-sb px-2">Announcements</h5>
                            <div class="pt-3">
                                <div class="py-2 px-2">
                                    <h6 class="text-sb px-14 my-2">Class Scheduled</h6>
                                    <h6 class="px-14 text-muted my-2">Lorem ipsum lorem doler is smit</h6>
                                </div>
                                <hr class="m-0">
                                <div class="py-2 px-2">
                                    <h6 class="text-sb px-14 my-2">Class Scheduled</h6>
                                    <h6 class="px-14 text-muted my-2">Lorem ipsum lorem delor is smits</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title px-18 text-sb">Upcoming Classes</h5>
                            <div class="pt-2">
                                <div class="announce-tab pb-2 pt-2">
                                    <h5 class="px-14">Saad Yasin</h5>
                                    <h4 class="px-14 text-sb mb-2">Mon, 23 Aug - 07:00 Pm</h4>
                                    <a class="btn btn-primary py-2 w-100"
                                        href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09">Join
                                        Class!</a>
                                </div>
                                <hr class="my-2">
                                <div class="announce-tab pb-2 pt-2">
                                    <h5 class="px-14">Saad Yasin</h5>
                                    <h4 class="px-14 text-sb mb-2">Mon, 23 Aug - 07:00 Pm</h4>
                                    <a class="btn btn-primary py-2 w-100"
                                        href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09">Join
                                        Class!</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </di /v>
        </div>
    </div>
    @if (!is_null(auth()->user()->customer_pin))
        @include('front.customer.components.pinCode_modal', [
            'type' => 'auth',
        ])
    @endif
    @push('after-style')
        <style>
            .student_dashboard {
                padding-top: 90px;
                min-height: 100vh;
            }

            .student_dashboard .card {
                border: none;
                text-decoration: none;
            }

            .student_dashboard .student-card:hover {
                box-shadow: 6px 4px 20px -5px lightgrey;
                cursor: pointer;
            }
        </style>
    @endpush
    @push('after-script')
        <script>
            /*$('.student-card').click(function() {
                                                location.href = '/en/customer/student/home';
                                            })*/
        </script>
    @endpush
@stop
