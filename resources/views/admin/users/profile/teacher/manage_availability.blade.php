<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Availability</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table wrapper-->
        <!-- simple form -->
        <form class="" role="form" method="post"
            action="{{ route('admin.users.'.$user->user_type.'.addAvailability') }}">
            {{-- for teacher it will submit to teacher controller in admin flder and for teacher coordinator it will
            submit to teacher coodinator controller--}}
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="table-responsive">
                <div class="form-group">
                    <label class="form-check-label mb-2" for="timezone-select">
                        <div class="fw-bolder">Select Timezone</div>
                    </label>
                    <select name="timezone" id="timezone-select" class="form-control select2-single">
                        <option value="0" selected hidden disabled>Select Teacher's Timezone</option>
                        @foreach(DateTimeZone::listIdentifiers() as $timezone)
                        <option value="{{ $timezone }}" @if($user->availability) {!! $user->timezone ==
                            $timezone ? 'selected' : '' !!} @endif >{{ $timezone }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <!--begin::Table-->
                @if($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher))
                {{-- The teacher co ordinator dont want slots and timetable --}}
                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-bold text-gray-600">
                        <label class="form-check-label mb-2" for="timezone-select">
                            <div class="fw-bolder">Select Days & Time Slots</div>
                        </label>
                        @foreach(\App\Classes\AlQuranConfig::Days as $key => $day)
                                <!-- incase you dont want to include sunday .. just make a if that its not loop first iteration -->
                        @php
                        $days = array();
                        $slots_selected = array();
                        if($user->availability){
                        $days = $user->availability->days->pluck('slots', 'day_id');
                        }

                        if(count($days)){
                        $slots_selected = isset($days[$key]) ? $days[$key]->pluck('slot_id')->toArray() : array();
                        $days = $days->toArray();
                        //dd($days);
                        //dd($slots);
                        }


                        @endphp
                        <tr>
                            <td>
                                <div class="form-check form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input me-3 days-check" id="day-{{ $key }}" name="days[]"
                                        data-select="select2-{{ $key }}" type="checkbox" {!! array_key_exists($key,
                                        $days) ? 'checked' : '' !!} value="{{ $key }}">
                                    <!--end::Input-->
                                    <!--begin::Label-->
                                    <label class="form-check-label" for="day-{{ $key }}">
                                        <div class="fw-bolder">{{ beautify_slug($day) }}</div>

                                    </label>

                                    <!--end::Label-->
                                </div>
                            </td>
                            <td style="width: 100%">
                                <div class="form-group-lg">
                                    <select class="form-control form select2-multiple select2-{{ $key }}"
                                        name="slots[{{ $key }}][]" multiple="multiple" {!! array_key_exists($key, $days)
                                        ? '' : 'disabled="disabled"' !!}>
                                        @php $slots = get_24_hour_timeslots(); @endphp
                                        @foreach($slots as $k => $slot)
                                        @if(!$loop->last)
                                        <option value="{{ $k }}" {!! in_array($k, $slots_selected) ? 'selected' : ''
                                            !!}>{{ $slot. ' - '.$slots[$k+1] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                            </td>
                            <td>
                                <div class="text-gray-600 text-sm apply-icon" data-select="select2-{{ $key }}">
                                    <span class="badge badge-light-primary cursor-pointer select2-{{$key}}-apply"
                                        style="{!! array_key_exists($key, $days) ? '' : 'display: none' !!}"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        data-bs-original-title="Clone the selected slots to other checked days.">
                                        <i class="fa fa-exchange"></i>
                                    </span>
                                </div>
                            </td>
                        </tr>
                      
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                @endif
                <!--end::Table-->
            </div>
            <div class="d-flex justify-content-end align-items-center mt-12">
                @if(!$user->availability)
                <button type="submit" id="submit-availability" class="btn btn-primary">
                    Save
                </button>
                @else
                <button type="submit" id="submit-availability" class="btn btn-danger" data-bs-toggle="popover"
                    data-bs-trigger="hover" data-bs-html="true"
                    @if($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher))
                    data-bs-content="Updating teacher's availability will effect ongoing schedule.Please make sure of
                    the changes before proceeding"
                    @endif
                    aria-hidden="true">
                    <i class="fas fa-shield-alt"></i> Update
                </button>
                @endif
                <!--end::Button-->
            </div>
        </form>
        <!--end::Table wrapper-->
    </div>
    <!--end::Card body-->
</div>