<div>
    <h4 class="px-24 text-sb">{{ __('MakeUp Class Request') }}</h4>
    <p class="px-14 text-med mb-0 mb-sm-4 pt-3">
        {{ __('From below calendar you select available date and time slot for reschedule your class') }}
    </p>
    <p class="px-14 text-med d-sm-none d-block text-danger mt-1 pb-3">{{ __('Scroll left to view more days') }}</p>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-12">
                {{-- @include(
                    'front.customer.components.schedule_calender'
                ) --}}
                @include('front.customer.components.timetable', [
                    'select_limit' => 1,
                    'action' => route('customer.student.saveRescheduleRequest', $student),
                    'reschedule' => true,
                ])
            </div>
            {{-- <div class="col-sm-5 col-12 text-sm-end">
                 <div class="right-col ms-sm-auto">
                     <h4 class="px-14 text-med mb-5 text-start">Friday, August 21</h4>
                     <div class="ms-sm-auto teacher-slots">
                         <button class="btn btn-outline-dark px-5 py-2 my-3 d-block" data-value="1:00PM">1:00
                             PM</button>
                         <button class="btn btn-outline-dark px-5 py-2 my-3 d-block" data-value="3:00PM">3:00
                             PM</button>
                         <button class="btn btn-outline-dark px-5 py-2 my-3 d-block" data-value="7:00PM">5:00
                             PM</button>
                         <button class="btn btn-outline-dark px-5 py-2 my-3 d-block" data-value="7:00PM">7:00
                             PM</button>
                     </div>
                 </div>
             </div> --}}
        </div>
        <div class="row">
            <div class="col-sm-7 col-12 d-sm-block d-none">

            </div>
            <div class="col-sm-5 col-12 mt-3 text-sm-end text-center">
                <button type="submit" form="slots-selection-form" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
