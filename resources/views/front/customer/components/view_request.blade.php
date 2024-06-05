     <div class="row">
         <div class="col-lg-6 col-sm-8 col-12">
             <h4 class="px-18 text-bold pb-1">Change Schedule Request!</h4>
             <p class="px-14 text-med mb-5">You request has been submitted. Customer support will
                 contact you within 24-48 hours.</p>
             <div class="row px-14 py-2">
                 <div class="col-4 text-sb">
                     Request Date:
                 </div>
                 <div class="col-8 px-14 text-med">21 Oct 2021</div>
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
             {{-- <div class="row py-2">
                 <div class="col-4 text-sb">
                     Action:
                 </div>
                 <div class="col-8 px-14 text-med"><button class="btn btn-outline-danger">Delete
                         Request</button></div>
             </div> --}}
         </div>
         <div class="col-lg-1 d-lg-block d-none"></div>
         <div class="col-lg-5 col-sm-4 col-12 mt-5 mt-sm-0">
             <h4 class="px-18 text-bold pb-2">Invoice:</h4>
             <div class="package_summary">
                 <div class="container p-3 px-14 text-med">
                     <div class="row py-2">
                         <div class="col-6">Student Name</div>
                         <div class="col-6 text-end">Noman Ali khan</div>
                     </div>
                     <div class="row py-2">
                         <div class="col-6">Course</div>
                         <div class="col-6 text-end">Tajweed Of Quran</div>
                     </div>
                     <div class="row py-2">
                         <div class="col-6">Course Change Fee</div>
                         <div class="col-6 text-end text-bold">20$</div>
                     </div>
                     <hr class="my-2">
                     <div class="row py-2 color-primary">
                         <div class="col-6">Total Price</div>
                         <div class="col-6 text-bold px-24 text-end">- $63</div>
                     </div>
                 </div>

             </div>
                <div class="px-14 text-med pt-3 text-end"><a class="text-danger">Delete
                        Request</a></div>
         </div>
     </div>
 @push('after-style')
     <style>
         .view-request .package_summary {
             background-color: #F1F7FF;
         }

         .view-request .package_summary hr {
             background-color: #c9bcbc;
             height: 2px;
         }

         .view-request .payment-col {
             max-width: 500px;
         }

         @media screen and (max-width:576px) {
             .view-request .payment-col {
                 margin: 0 auto 0 auto;
             }

         }

     </style>
 @endpush
