@inject('Courses', 'App\Models\Course')
<div class="modal fade" id="change-course-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content">
            <div class="modal-header border-bottom px-sm-4">
                <h4 class="modal-title text-med px-18">Change Course</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-4">
                <form id="change-course-form"
                    action="{{ route('customer.ChangeRequest',['child' => request('child')]) }}" validate=validate
                    method="post">
                    @csrf
                    <input type="hidden" name="change_type" value="course_change">
                    <label class="my-2 text-med" for="courses">Select Course</label>
                    <select
                        class="form-select form-select-solid select2-single @error('course_id') is-invalid @enderror"
                        name="course_id" id="course_id" data-placeholder="Select courses to assign">
                        <option value="">Choose a Course</option>
                        @foreach ($Courses->all() as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>

                        @endforeach
                        <option value="custom">Crete a Custom Course</option>

                        @error('course_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </select>

                    <label class="my-1 text-med" for="{{ generate_field_id_by_title(__('Reason')) }}">{{ __('Please
                        state a reason and details') }}:</label>
                    <textarea @class(['form-control', ]) placeholder="Provide a reason" name="reason" id="reason"
                        rows="4"></textarea>
                    @error('reason')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p class="mt-3">*Please note that we charge $45 for changing teacher.</p>
                </form>
            </div>
            <div class="modal-footer px-sm-4 pt-0 pb-3 border-top-0">
                <div class="h-100 d-flex justify-content-end align-items-center">
                    <a href="#" class="text-dark text-decoration-none text-med me-4 px-14" data-bs-dismiss="modal"
                        aria-label="Close">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary py-2 submit-btn" form="change-course-form">
                        {{ __('Submit Request') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('after-style')
<style>
    #change-course-modal .submit-btn {
        width: 211px;
        height: 44px;
    }

    @media screen and (max-width:400px) {
        #change-course-modal .submit-btn {
            width: 150px;
        }
    }
</style>
@endpush

@push('end-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> {{-- for
form validations --}}
<script>
    $(function(){
        $('#change-course-form').validate({ // initialize the plugin
            errorClass: "invlaid",  // what class to give to error class
            focusCleanup: true, // whenever an element is focuesd remove its error
            validClass: "success",  // if the value is true ad success class
            success: "valid",
            focusInvalid: false,
        rules: {
            reason: {
                required: true,
                maxlength: 255,
                minlength: 3
                
            },
            change_type:{
                required: true,
            },
            course_id:{
                required:false,
            },
           
      
       
        },
        submitHandler: function(form) {
            Ajax_Call_Dynamic(
                $(form).attr('action'),
                $(form).attr('method'),
        new FormData( $(form)[0]),
        "ChangeCourseSuccess", 
        'FailedToasterResponse', 
       
    );
  },

    });
    });

  function ChangeCourseSuccess(response){
    console.log(response);
    const {message}=response;   // get meessage from reponse and save it in message 
    toaster("success",`The System notifies you that ${message}`);
    $('#change-course-form').trigger("reset");
    // $("#change-course-modal").toggle("slow","swing");
    if($( "#change-course-form" ).children(".new-element").length){
    $( "#change-course-form" ).children(".new-element").remove();
    }
    $('#change-course-modal').modal('hide');

  }


  $("#course_id").change(function (e) { 
    e.preventDefault();
    console.log("change");
    valChoosen=($(this).val());
    if(valChoosen=='custom'){
        console.log("inside");
        html=`<label class="new-element"> Course Title </label>
        <input   type="text" name="course_title" placeholder="Enter Course Title" id="course_title_id" class="form-control new-element" >
        <label class="new-element"> Course Description </label>
        <input   type="text" name="course_description" placeholder="Enter Course Description" id="course_description_id" class="form-control new-element" >
        `;
        console.log(html);
        $("#change-course-form select[name=course_id]").after(html);        
        //appending a text field to get custom course title from user
        
    }else{
        $( "#change-course-form" ).children(".new-element").remove();
  
    }
    
  });

</script>
@endpush