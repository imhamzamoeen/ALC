   <div class="container teacher-request">
       <h4 class="px-18 text-med">Change Request For Teacher</h4>
       <table class="vertical-table table-borderless">
           <thead class="table-header">
               <tr>
                   <th scope="col" class="ps-2">{{ __('Name') }}</th>
                   <th scope="col">{{ __('Course') }}</th>
                   <th scope="col">{{ __('Status') }}</th>
                   <th scope="col" class="pe-2">{{ __('Action') }}</th>
               </tr>
           </thead>
           <tbody>
               {{-- @foreach ($students as $student) --}}
               <tr>
                   <td data-label="Name">
                       Sheikh Arslan
                   </td>
                   <td data-label="Course">Monthly</td>
                   <td data-label="Status">
                       <p class="mt-0 mb-0"> <span class="badge status-pill status-primary">Pending</span></p>
                   </td>
                   <td data-label="Action">
                       <button class="btn btn-primary py-2 px-3" data-bs-target="#change-teacher-modal"
                           data-bs-toggle="modal">Change Teacher</button>
                   </td>
               </tr>
               {{-- @endforeach --}}
               <tr>
                   <td data-label="Name">
                       Sheikh Arslan
                   </td>
                   <td data-label="Course">Monthly</td>
                   <td data-label="Status">
                       <p class="mt-0 mb-0"> <span class="badge status-pill status-primary">Pending</span></p>
                   </td>
                   <td data-label="Action">
                       <button class="btn btn-primary py-2 px-3" data-bs-target="#change-teacher-modal"
                           data-bs-toggle="modal">Change Teacher</button>
                   </td>
               </tr>
               <tr>
                   <td data-label="Name">
                       Sheikh Arslan
                   </td>
                   <td data-label="Course">Monthly</td>
                   <td data-label="Status">
                       <p class="mt-0 mb-0"> <span class="badge status-pill status-primary">Pending</span></p>
                   </td>
                   <td data-label="Action">
                       <button class="btn btn-primary py-2 px-3" data-bs-target="#change-teacher-modal"
                           data-bs-toggle="modal">Change Teacher</button>
                   </td>
               </tr>
               <tr>
                   <td data-label="Name">
                       Sheikh Arslan
                   </td>
                   <td data-label="Course">Monthly</td>
                   <td data-label="Status">
                       <p class="mt-0 mb-0"> <span class="badge status-pill status-primary">Pending</span></p>
                   </td>
                   <td data-label="Action">
                       <button class="btn btn-primary py-2 px-3" data-bs-target="#change-teacher-modal"
                           data-bs-toggle="modal">Change Teacher</button>
                   </td>
               </tr>
               <tr>
                   <td data-label="Name">
                       Sheikh Arslan
                   </td>
                   <td data-label="Course">Monthly</td>
                   <td data-label="Status">
                       <p class="mt-0 mb-0"> <span class="badge status-pill status-primary">Pending</span></p>
                   </td>
                   <td data-label="Action">
                       {{-- <button class="btn btn-outline-primary py-2 px-3" data-bs-target="#change-teacher-modal"
                           data-bs-toggle="modal">Change Teacher</button> --}}
                       <button  class="btn btn-outline-danger border-0 bg-transparent py-2 text-sm-center text-end"><i
                               class="fa fa-times me-1"></i> {{ __('Delete Request') }}</button>
                   </td>
               </tr>
           </tbody>
       </table>

   </div>
   @include('front.customer.components.change_teacher')
   @push('after-style')
   <style>
       .teacher-request .btn-outline-danger:hover {
           color: #dc3545;
       }

   </style>
@endpush