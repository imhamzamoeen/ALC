@isset($Model->students)
    @forelse ($Model->Students[0]->files as $each_file)
        @if ($loop->first)
            <h4 class="px-18 text-sb mb-4">
                Attached Books / Notes
            </h4>
            <h4 class="px-18 text-sb empty-state pt-4" style="display: none">
                {{ __('No Attachments To Show') }}
            </h4>
        @endif
        <div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom file-row mb-3"
            id="{{ $each_file->pivot->id }}">
            <div class="d-flex align-items-center">
                {{-- <img src="{!! get_icon_of_resource_file($each_file->file_type) !!}" alt="file" class="me-2" height="45px" width="45px"> --}}
                <object type="image/svg+xml" data="{!! get_icon_of_resource_file($each_file->file_type) !!}" width="45" height="45">
                    Your browser does not support SVG.
                </object>
                <div>
                    <h5 class="mb-1 px-14 text-sb">{{ $each_file->title . '.' . $each_file->file_type }}</h5>
                    <p class="mb-0 px-12 text-med">{{ $each_file->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="rounded-circle cross-icon student_resource_remove_div">
                <i class="fa fa-times remove_stuednt_resource" data-fileableid="{{ $each_file->pivot->id }}"></i>
            </div>
            <div class="spinner-border color-primary text-light" style="display: none" role="status"></div>
        </div>
    @empty
        <h4 class="px-18 text-sb">
            {{ __('No Resources Assigned') }}
        </h4>
    @endforelse
@endisset

<script>
    $('.student_resource_remove_div > .remove_stuednt_resource').click(function(e) {
        $(this).parent().hide();
        const el = $(this);
        $(this).parent().next().show()
        e.preventDefault();
        e.preventDefault();
        var formdata = new FormData();
        var data = $(this).data("fileableid")
        formdata.append('fileableid', $(this).data("fileableid"))
        // const response = Ajax_Call_Dynamic(
        //     '{{ route('teacher.RemoveResourceToStudent', [app()->getLocale()]) }}', 'POST',
        //     formdata, "StudentUnAssignResourceSuccess", 'FailedToasterResponse',
        //     '.each_student_note > .student_note', 'False').then(function() {
        //     const id = $(this).parent().parent().attr('id');
        //     $('#' + id).remove();
        //     if ($('.file-row').length === 0) {
        //         $('.empty-state').show();
        //     } else {
        //         $('.empty-state').hide();
        //     }
        // });
        $.ajax({
                url: '{{ route('teacher.RemoveResourceToStudent', [app()->getLocale()]) }}',
                method: 'POST',
                contentType: false,
                processData: false,
                data: formdata,
                dataType: "json",
                // beforeSend: function () {
                //     if(LoaderOption!=="False") 
                //     $(LoaderClass).html(
                //         '<div class="overlay-loader d-flex align-items-center justify-content-center flex-column " id="loader" style="background-color: transparent;"><div class="spinner-border color-primary text-light" role="status"></div></div>'
                //     );
                // },
                success: function(response) {
                    // console.log("success");
                    const id = $(el).parent().parent().attr('id');
                    $('#' + id).remove();
                    if ($('.file-row').length === 0) {
                        $('.empty-state').show();
                    } else {
                        $('.empty-state').hide();
                    }
                    // window[callBackFuncSuccess](response);
                },
                error: function(response) {
                    // console.log("error");
                    $(el).parent().next().hide();
                    $(el).parent().show();
                    // window[callBackFuncError](response);
                },
                complete: function() {
                    // console.log("complete");
                },
            })
            .then(function() {})
            .catch(function(e) {

                Toast.fire({
                    icon: "info",
                    title: e.responseJSON.message,
                    timer: 1500
                });
                $(LoaderClass).html('');
            });

    });

    function StudentUnAssignResourceSuccess(response) {
        toaster('success', 'Resources Un Assigned Successfully');

        // $('.each_student_note > .student_note').html(response.response)
    }
</script>
