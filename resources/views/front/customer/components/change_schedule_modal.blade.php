<div class="modal fade change_schedule-modal" id="change_schedule_modal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="border-0 modal-content">
            <div class="modal-header pb-0 pt-4 px-4">
                <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-sm-3 pb-sm-5 pb-3 px-4" id="change_schedule_body">
            
          <x-student.request-reschedule type="request_reschedule" :student="$student"/>
            </div>

        </div>
    </div>
</div>
{{-- @push('after-style') --}}
    <style>
        .change_schedule-modal .modal-dialog {
            max-width: 650px;
        }

        .change_schedule-modal button.btn {
            width: 205px;
            height: 53px;
        }

        .change_schedule-modal .teacher-slots button:focus,
        .change_schedule-modal .teacher-slots button:active {
            box-shadow: none
        }

        @media screen and (max-width:575px) {
            .change_schedule-modal .teacher-slots {
                width: 205px;
            }

            .change_schedule-modal .teacher-slots {
                margin: 0 auto;
            }
        }

        @media screen and (min-width:575px) {
            .change_schedule-modal .right-col {
                width: 205px;
            }
        }

    </style>
{{-- @endpush --}}
{{-- @push('after-script') --}}
    <script>
        $(document).on('click', 'button[data-action="reschedule"]', function () {
          
            let id = $(this).data('id');

            $.ajax({
                type:'get',
                data: { 'class' : id },
                url: '{{ route('customer.student.rescheduleRequest', [app()->getLocale(), $student->id]) }}',
                beforeSend: function(){
                    $('#change_schedule_modal').modal('hide')
                },
                success: function(response) {
                    $('#change_schedule_body').html(response.fillableData)
                    $('#change_schedule_modal').modal('show')
                },
                error: function(response) {
                    Toast.fire({
                        icon: 'error',
                        title: '{{ \App\Classes\AlertMessages::ERROR_500 }}'
                    })
                    $('#change_schedule_modal').modal('hide')
                }
            }).then(function() {

            }).catch(function(response) {
                console.log(response)
                $('#change_schedule_modal').modal('hide')
            })
        })
    </script>
{{-- @endpush --}}
{{-- @push('after-script')
    <script>
        $('.teacher-slots button').on('click', function() {
            $(this).toggleClass('btn-outline-dark');
            $(this).toggleClass('btn-dark active')
        })
    </script>
@endpush --}}
