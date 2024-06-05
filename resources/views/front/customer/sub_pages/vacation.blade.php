 <div class="container container-md-fluid vacation-tab">
     <div>
         <h4 class="px-18 text-sb">Vacation Mode</h4>
         <p class="px-14 text">Choose Dates for Vacation Mode</p>
         <form action="" class="text-med px-14">
             <div class="row mt-4">
                 <div class="col-6">
                     <label for="starting_date" class="form-label my-2">Starting Date</label>
                     <div class="input-group date" id="start_time" data-target-input="nearest">
                         <input type="text" class="form-control datetimepicker-input py-3" data-target="#start_time"
                             data-toggle="datetimepicker" placeholder="{{ __('Select Date') }}" />
                         <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                     </div>
                 </div>
                 <div class="col-6">
                     <label for="ending_date" class="form-label my-2">Ending Date</label>

                     <div class="input-group date" id="end_time" data-target-input="nearest">
                         <input type="text" class="form-control datetimepicker-input py-3" data-target="#end_time"
                             data-toggle="datetimepicker" placeholder="{{ __('Select Date') }}" />
                         <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                     </div>

                 </div>
             </div>
             <label for="reason" class="form-label mb-2 mt-4">Lorem Ipsum dolor sit</label>
             <textarea name="reason" class="form-control" placeholder="Write a reason here..." id=""
                 rows="5"></textarea>
             <div class="d-flex justify-content-end mt-4">
                 <button class="bg-transparent border-0 text-dark px-3 py-2">Cancel</button>
                 @if (request()->segment(count(request()->segments())) == 'home')
                     <a class="btn btn-primary px-3 py-2 me-3 me-md-0"
                         href={{ url('/en/customer/student/vacation') }}>Send Request</a>
                 @else
                     <a class="btn btn-primary px-3 py-2 me-3 me-md-0"
                         href={{ url('/en/customer/vacation-request') }}>Send Request</a>
                 @endif

             </div>
         </form>
     </div>
 </div>

 {{-- Below div for showing Vacation Request --}}

 {{-- <div class="row">
         <div class="col-sm-9 col-12">
             <h4 class="px-18 text-bold pb-1">Vacation Mode</h4>
             <p class="px-14 text-med mb-5">You request has been submitted. Customer support will contact you within
                 24-48 hours.</p>
             <div class="row px-14 py-2">
                 <div class="col-4 text-sb">
                     Starting Date:
                 </div>
                 <div class="col-8 px-14 text-med">21 Oct 2021</div>
             </div>
             <div class="row px-14 py-2">
                 <div class="col-4 text-sb">
                     Ending Date:
                 </div>
                 <div class="col-8 px-14 text-med">22 March 2023</div>
             </div>
             <div class="row py-2">
                 <div class="col-4 text-sb">
                     Details:
                 </div>
                 <div class="col-8 px-14 text-med">Lorem ipsum dolor sit amet, consetetur
                     sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore
                     magna aliquyam erat, sed diam voluptua. At vero eos et accusam et</div>
             </div>
             <div class="row py-2">
                 <div class="col-4 text-sb">
                     Status:
                 </div>
                 <div class="col-8 px-14 text-med"><span class="badge status-pill status-danger">Pending</span></div>
             </div>
             <div class="row py-2">
                 <div class="col-4 text-sb">
                     Action:
                 </div>
                 <div class="col-8 px-14 text-med"><button class="btn btn-outline-danger">Delete
                         Request</button></div>
             </div>
         </div>
     </div> --}}

 @push('after-style')
     <style>
         .vacation-tab textarea {
             width: 100%
         }

         .vacation-tab .bootstrap-datetimepicker-widget {
             width: 100%;
         }

         @media screen and (min-width:991px) {
             .vacation-tab {
                 width: 75%;
             }
         }

     </style>
 @endpush
 @push('after-script')
     <script>
         $('#start_time').datetimepicker({
             minDate: new Date(),
             format: 'L'
         });
         $('#end_time').datetimepicker({
             minDate: new Date(),
             format: 'L'
         });
     </script>
 @endpush
