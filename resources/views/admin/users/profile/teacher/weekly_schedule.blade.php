<div class="card card-flush mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h2 class="mb-1">{{ $user->first_name }}'s Weekly Schedule</h2>
            <div class="fs-6 fw-bold text-muted">{{ $user->routine_classes->count() ?? 0 }} scheduled classes</div>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
    {{--<div class="card-toolbar">
        <button  class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_schedule">
            <!--SVG file not found: media/icons/duotune/art/art008.svg-->
            Add Schedule</button>
    </div>--}}
    <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body p-9 pt-4">
        <!--begin::Dates-->
        <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">
            @php
                $days = array();
                $slots_selected = array();
                if($user->availability){
                  $days = $user->availability->days->pluck('slots', 'day_id');
                }
                $slots = get_24_hour_timeslots();
            @endphp
            @foreach(get_current_week() as $key => $day)
                <li class="nav-item me-8">
                    <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary @if($loop->first) active @endif h-50px w-100px" data-bs-toggle="tab" href="#kt_schedule_day_{{ $key }}">
                        <span class="opacity-50 fs-7 fw-bold">{{$day->format('l')}}</span>
                        <span class="fs-6 fw-boldest">{{$day->format('d')}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <!--end::Dates-->
        <!--begin::Tab Content-->
        <div class="tab-content">
            @foreach(get_current_week() as $key => $day)
                <div id="kt_schedule_day_{{$key}}" class="tab-pane fade show @if($loop->first) active @endif">
                    @isset($days[$key])
                        {{--@dd($days[$key])--}}
                        @foreach($days[$key] as $k => $slot)
                            <div class="d-flex flex-stack position-relative mt-6">
                                <!--begin::Bar-->
                                <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                <!--end::Bar-->
                                <!--begin::Info-->
                                <div class="fw-bold ms-5">
                                    <!--begin::Time-->
                                    <div class="fs-7 mb-1">{{ $slots[$slot->slot_id] }} - {{ $slots[$slot->slot_id + 1] }}</div>
                                    <!--end::Time-->
                                    <!--begin::Title-->
                                    <a href="#" class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{ $slot->routine_class->student->course->title ?? 'Free Slot' }}</a>
                                    <!--end::Title-->
                                    <!--begin::User-->
                                    <div class="fs-7 text-muted">Student:
                                        <a href="#">{{ $slot->routine_class->student->name ?? '--' }}</a></div>
                                    <!--end::User-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Action-->
                                @if(!empty($slot->routine_class))
                                <button class="btn btn-primary bnt-active-light-primary btn-sm collapsible" data-bs-toggle="collapse" href="#kt_user_view_class_{{ $k }}_{{$key}}" role="button" aria-expanded="false" aria-controls="kt_user_view_class_{{ $k }}_{{$key}}">Details</button>
                                @endif
                                <!--end::Action-->
                            </div>
                            @if(!empty($slot->routine_class))
                                <div id="kt_user_view_class_{{ $k }}_{{$key}}" class="collapse">
                                    <div class="pb-5 fs-6 position-relative">
                                        <div class="position-absolute h-100 w-4px bg-primary rounded top-0 start-0"></div>
                                         <div class="row ms-4">
                                              <div class="col-md-6">
                                                  <div class="fw-bolder mt-5">Teacher Timezone</div>
                                                  <div class="text-gray-600">
                                                      {{-- <a href="#" class="text-gray-600 text-hover-primary">{{ $user->availability->timezone ?? '--' }}</a> --}}
                                                      <a href="#" class="text-gray-600 text-hover-primary">{{ $user->timezone ?? '--' }}</a>

                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="fw-bolder mt-5">Student Timezone</div>
                                                  <div class="text-gray-600">
                                                      <a href="#" class="text-gray-600 text-hover-primary">{{ $slot->routine_class->student->timezone ?? '--' }}</a>
                                                  </div>
                                              </div>
                                         </div>
                                         <div class="row ms-4">
                                              <div class="fw-bolder mt-5">Class Link</div>
                                              <div class="text-gray-600">
                                                  <a href="{{ $slot->routine_class->class_link ?? '#' }}" target="_blank" class="text-gray-600 text-hover-primary">{{ $slot->routine_class->class_link ?? '--' }}</a>
                                              </div>

                                         </div>
                                    </div>
                                    <hr>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="row"><span class="text-center text-muted mt-10 mb-5">No Schedule for this day!</span></div>
                    @endisset
                </div>
            @endforeach
        </div>
        <!--end::Tab Content-->
    </div>
    <!--end::Card body-->
</div>

