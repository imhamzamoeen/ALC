
<div class="modal fade" id="change-teacher-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="change-teacher-form" method="POST"
            action="{{ route('customer.ChangeRequest',['child' => request('child')]) }}" validate=validate>
            @csrf
            <input type="hidden" name="change_type" value="teacher_change">
            <div class="border-0 modal-content">
                <div class="modal-header border-bottom px-sm-4">
                    <h4 class="modal-title text-med px-18">Change Teacher</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-4">
                    <label class="my-1 text-med" for="{{ generate_field_id_by_title(__('Reason')) }}">{{ __('Please
                        state a reason and details') }}:</label>
                    <textarea @class(['form-control', ]) placeholder="Provide a reason" name="reason" id="reason"
                        rows="4"></textarea>
                    @error('reason')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p class="mt-3">*Please note that we charge $45 for changing teacher. Customer Support will
                        contact you for further assistance.</p>

                </div>
                <div class="modal-footer pt-0 pb-3 border-top-0 px-sm-4">
                    <div class="h-100 d-flex justify-content-end align-items-center">
                        <a href="#" class="text-dark text-decoration-none text-med me-4 px-14" data-bs-dismiss="modal"
                            aria-label="Close">{{
                            __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary py-2 submit-btn">
                            {{ __('Submit Request') }}
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
@push('after-style')
<style>
    #change-teacher-modal .submit-btn {
        width: 211px;
        height: 44px;
    }

    .invlaid {
        color: red;
        background: transparent;
        border-color: red;
    }

    @media screen and (max-width:400px) {
        #change-teacher-modal .submit-btn {
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
        $('#change-teacher-form').validate({ // initialize the plugin
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
            }
      
       
        },
        submitHandler: function(form) {
            Ajax_Call_Dynamic(
                $(form).attr('action'),
                $(form).attr('method'),
        new FormData( $(form)[0]),
        "ChangeTeacherSuccess", 
        'FailedToasterResponse', 
       
    );
  },

    });
    });

  function ChangeTeacherSuccess(response){
    console.log(response);
    $('#change-teacher-form').trigger("reset");
    toaster("success",`${response.message}`);
    $('#change-teacher-modal').modal('hide');

  }
</script>
@endpush