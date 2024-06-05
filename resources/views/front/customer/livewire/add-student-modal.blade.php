<div wire:ignore.self class="modal fade add-student-modal" id="trial-modal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content">
            <div wire:loading wire:target="submit">
                @include('front.partials.overlay-loader')
            </div>
            <div class="modal-header py-4 px-4">
                <button type="button pb-2" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <div class="container d-flex justify-content-center mb-4 p-0">
                    <div class="progress-container">
                        <div class="progress" id="progress" style="width: {{ $progress }}% ; "></div>
                        <div class="circle {{ $trial1_status }}" wire:click="toggleTab(true, false, false)">1 <span
                                class="circle-text" style="left:-16px">{{ __('Information') }}</span></div>
                        <div class="circle {{ $trial2_status }}" wire:click="toggleTab(false, true, false)">2<span
                                class="circle-text" style="left:-5px">{{ __('Course') }}</span></div>
                        <div class="circle {{ $trial3_status }}" wire:click="toggleTab(false, false, true)">3<span
                                class="circle-text" style="left:-15px">{{ __('Availability') }}</span></div>
                    </div>
                </div>
                <!-- simple form -->
                <form wire:submit.prevent="submit" id="add-student-form">
                    {{-- @csrf --}}
                    <div id="trial-1" @if (!$trial_1) style="display: none " @endif>
                        <h4 class="mb-4">{{ __('Basic Information') }}</h4>
                        <div class="form-group mb-3">
                            <div class="mb-1"><label class="text-med"
                                    for="{{ generate_field_id_by_title(__('Full Name')) }}">{{ __('Full Name') }}:</label>
                            </div>
                            <input type="text" name="name" maxlength="64"
                                class="form-control py-2 @error('name') is-invalid @enderror"
                                id="{{ generate_field_id_by_title(__('Full Name')) }}" aria-describedby="emailHelp"
                                placeholder="{{ __('Full Name') }}" wire:model.lazy="name" autocomplete="off">
                            {{-- <div class="invalid-feedback error"></div> --}}
                            @error('name')
                                <div class="invalid-feedback error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-1 text-med"
                                for="{{ generate_field_id_by_title(__('Gender')) }}">{{ __('Gender') }}:</label>
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="list-group-item col mr-5 py-2">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="gender" id="male" value="male" wire:model.lazy="gender">
                                    <label class="form-check-label" for="male">
                                        {{ __('Male') }}
                                    </label>
                                </li>
                                <li class="list-group-item col py-2">
                                    <input class="form-check-input ml-3 @error('gender') is-invalid @enderror"
                                        type="radio" name="gender" id="female" value="female"
                                        wire:model.lazy=gender>
                                    <label class="form-check-label" for="female">
                                        {{ __('Female') }}
                                    </label>
                                </li>
                            </ul>
                            @error('gender')
                                <div class="text-danger error text-sm"> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-1 text-med"
                                for="{{ generate_field_id_by_title(__('Age')) }}">{{ __('Age') }}:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-control py-2 @error('age') is-invalid @enderror" type="number"
                                        name="age" min="{{ \App\Classes\AlQuranConfig::MinAge }}"
                                        data-min="{{ \App\Classes\AlQuranConfig::MinAge }}" value=""
                                        placeholder="{{ __('Age') }}" wire:model.lazy="age"
                                        max="{{ \App\Classes\AlQuranConfig::MaxAge }}" autocomplete="off">
                                    @error('age')
                                        <div class="invalid-feedback error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mt-5">
                            <a id="trial-1-next" wire:click="toggleTab(false, true, false)" href="javascript:void(0);"
                                class="btn btn-primary submitButton w-50 py-2" style="background-color: #0A5CD6;"
                                wire:loading.class="disabled">
                                <div class="py-1" wire:loading.remove wire:target="toggleTab">
                                    {{ __('Next') }}
                                </div>
                                <div wire:loading wire:target="toggleTab">
                                    {{-- {{ __('Validating') }}... --}}
                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div id="trial-2" @if (!$trial_2) style="display: none " @endif>
                        <h4 class="mb-4 px-2">{{ __('Select a Course') }}</h4>
                        <div class="row px-sm-4">
                            <div class="col-md-12">
                                @foreach ($courses as $course)
                                    <div class="form-check mb-4">
                                        <input class="form-check-input ml-3" type="radio" name="course_id"
                                            id="course-{{ $course->id }}" value="{{ $course->id }}"
                                            @if ($loop->first) checked @endif
                                            wire:model.lazy="course_id">
                                        <label class="form-check-label mb-1" for="course-{{ $course->id }}">
                                            {{ __($course->title) }}
                                        </label><br>
                                        <p id="emailHelp" class="form-text text-muted">
                                            {{ __($course->description) }}</p>
                                    </div>
                                @endforeach
                                <div class="form-check mb-4">
                                    <input class="form-check-input ml-3" type="radio" name="course_id"
                                        id="custom-check" value="0" wire:model.lazy="course_id">
                                    <label class="form-check-label mb-1" for="custom-check">
                                        {{ __('Custom Course') }}
                                    </label><br>
                                    <textarea maxlength="200" class="form-control @error('custom_course') is-invalid @enderror " name="custom_course"
                                        rows="3" data-min="5"
                                        placeholder="{{ __('If you want to add more than one course, create a custom course as per your requirement') }}."
                                        id="custom-course-input" wire:model.lazy="custom_course"></textarea>
                                    <p class="text-secondary">Maximum Words Allowed: 200</p>
                                    @error('custom_course')
                                        <div class="invalid-feedback error">{{ $message }}</div>
                                    @enderror
                                    @error('course_id')
                                        <div class="text-danger error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mt-3">
                            <a id="trial-2-next" href="javascript:void(0);"
                                wire:click="toggleTab(false, false, true)"
                                class="btn btn-primary submitButton w-50 py-2" style="background-color: #0A5CD6;"
                                wire:loading.class="disabled">
                                <div wire:loading.remove wire:target="toggleTab">
                                    {{ __('Next') }}
                                </div>
                                <div wire:loading wire:target="toggleTab">
                                    {{-- {{ __('Validating') }}... --}}
                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div id="trial-3" @if (!$trial_3) style="display: none " @endif>
                        <h4 class="mb-3">{{ __('Select Availability') }}</h4>
                        <div class="row">
                            <div class="row m-auto trial-days text-center mb-4 ps-0 pe-0">
                                <div class="col-2">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="monday" value="0" wire:loading.attr="disabled"
                                        wire:model.lazy="days.0">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="monday">{{ __('Mon') }}</label>
                                </div>
                                <div class="col-2">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="tuesday" value="1" wire:loading.attr="disabled"
                                        wire:model.lazy="days.1">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="tuesday">{{ __('Tue') }}</label>
                                </div>
                                <div class="col-2">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="wednesday" value="2" wire:loading.attr="disabled"
                                        wire:model.lazy="days.2">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="wednesday">{{ __('Wed') }}</label>
                                </div>
                                <div class="col-2">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="thursday" value="3" wire:loading.attr="disabled"
                                        wire:model.lazy="days.3">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="thursday">{{ __('Thu') }}</label>
                                </div>
                                <div class="col-2">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="friday" value="4" wire:loading.attr="disabled"
                                        wire:model.lazy="days.4">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="friday">{{ __('Fri') }}</label>
                                </div>
                                <div class="col-2 days-list">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="saturday" value="5" wire:loading.attr="disabled"
                                        wire:model.lazy="days.5">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="saturday">{{ __('Sat') }}</label>
                                </div>
                                <div class="col-2 days-list">
                                    <input class="form-check-input form-tick" type="checkbox" name="days[]"
                                        id="saturday" value="6" wire:loading.attr="disabled"
                                        wire:model.lazy="days.6">
                                    <label class="form-check-label text-sb mt-2 text-med"
                                        for="sunday">{{ __('Sun') }}</label>
                                </div>
                                @error('days')
                                    <div class="text-danger error text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-check-label mb-2 text-med">{{ __('Select Shift') }}</label>
                                <select class="form-control form-select @error('shift_id') is-invalid @enderror"
                                    name="shift_id" wire:model.lazy="shift_id">
                                    <option value="0">{{ __('Select a Shift') }}</option>
                                    @foreach (\App\Classes\AlQuranConfig::Shifts as $key => $shift)
                                        <option value="{{ $key }}">{{ $shift }}</option>
                                    @endforeach
                                </select>
                                @error('shift_id')
                                    <div class="invalid-feedback error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-check-label mb-2 text-med">{{ __('Teacher Preference') }}</label>
                                <select class="form-control form-select @error('teacher_preference') is-invalid @enderror"
                                    name="teacher_preference" wire:model.lazy="teacher_preference">
                                    <option value="">{{ __('Select Teacher Preference') }}</option>
                                    <option value="male">{{ __('Male') }}</option>
                                    <option value="female">{{ __('Female') }}</option>
                                    <option value="any">{{ __('Any') }}</option>
                                </select>
                                @error('teacher_preference')
                                    <div class="invalid-feedback error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-check-label mb-2 text-med">{{ __('Timezone') }}</label>
                                <select class="form-control form-select @error('timezone') is-invalid @enderror"
                                    name="timezone" wire:model.lazy="timezone">
                                    <option value="0">{{ __('Select a Timezone') }}</option>
                                    @foreach (DateTimeZone::listIdentifiers() as $timezone)
                                        <option value="{{ $timezone }}">{{ $timezone }}</option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="form-group mb-4">
                                <label  for="exampleFormControlInput1 mb-2" class="form-label text-med">{{ __('Pick a Date') }} <small>(Optional)</small></label>
                                <div class="input-group date" id="datetimepicker-student" data-target-input="nearest">
                                    <input type="text" class="form-control @error('request_date') is-invalid @enderror datetimepicker-input" data-target="#datetimepicker-student" data-toggle="datetimepicker" placeholder="{{ $this->request_date ?? __('Pick a Date') }}" />
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    <br> @error('request_date') <div class="invalid-feedback error">{{ $message }}</div> @enderror
                                </div>
                            </div> --}}
                        </div>
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-primary submitButton w-50 py-2"
                                style="background-color: #0A5CD6;" wire:loading.class="disabled">
                                <div wire:loading.remove wire:target="submit">
                                    {{ __('Book Trial') }}
                                </div>
                                <div wire:loading wire:target="submit">
                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                    {{ __('Booking Trial') }}...
                                </div>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content">
            <div class="modal-body add-student-modal text-center">
                <div class="row justify-content-center mt-5">
                    <img class="col-3  " src="{{ asset('images/confirmation.svg') }}" />
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 justify-content-around">
                        <h4 class="mt-4 mb-3 successfully-added">
                            {{ __('Student Added') }}! <br>
                        </h4>
                        <h6 class="add-another">
                            {{ __('Do you want to add another profile?') }}
                        </h6>
                    </div>
                </div>
                <div class="row mx-auto w-75 d-flex justify-content-center justify-content-evenly mt-4 mb-5">
                    <button id="close-std-modal" class="btn btn-outline-primary py-2 col-5"
                        data-bs-dismiss="modal">{{ __('No') }}</button>
                    <button class="btn btn-primary col-5 py-2 ad-student-btn" data-bs-dismiss="modal"
                        data-id="add-student" wire:click="$emit('resetStudentForm')">{{ __('Yes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
