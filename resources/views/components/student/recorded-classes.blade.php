<div>
    <h4 class="text-1 text-med pb-2 mb-3">Recordings</h4>
    <table class="vertical-table table-borderless recordings" id="recorded_classes-table">
        <thead class="table-header">
            <tr>
                <th scope="col" class="ps-2">Day & Time</th>
                <th scope="col">Teacher Name</th>
                <th scope="col">Course</th>
                <th scope="col" class="pe-2">Recordings</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Day & Time">
                    <span class="text-sb me-2 d-sm-none d-inline">Mon 21 Aug</span>
                    <span class="d-sm-none d-inline">07:00 Pm</span>
                    <div class="text-sb d-sm-block d-none">Mon 21 Aug</div>
                    <div class="d-sm-block d-none">07:00 Pm</div>

                </td>
                <td data-label="Teacher Name">Saad Yasin</td>
                <td data-label="Course">Tajweed of Quran</td>
                <td data-label="Recordings">
                    <button class="bg-transparent rounded-circle video-btn border-0" data-bs-target="#videoModal"
                        data-bs-toggle="modal"><img src="/images/video-call (1).svg" alt="home"></button>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="modal fade" id="videoModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="border-0 modal-content">
                <div class="modal-header border-bottom">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <video id="video" width="100%" controls disablePictureInPicture>
                        <source
                            src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4"
                            type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <div class="px-3 py-2 text-center">
        <div class="py-1 text-bold">{{ __('No recordings found!') }}</div>
    </div>
</div>

{{-- @push('after-style') --}}
<style>
    @media screen and (min-width:576px) and (max-width:991px) {
        #videoModal .modal-dialog {
            max-width: 95%;
        }
    }
</style>
<script>
    $("#videoModal").modal({
        backdrop: 'static',
        keyboard: false,
        focus: true
    });
    $('#videoModal').on('shown.bs.modal', function() {
        document.activeElement.blur();
        $('#videoModal #video').focus();

    })
    $('#videoModal').on('hidden.bs.modal', function() {
        const el = $(this).find('#video');
        stopVideo(el);
        document.activeElement.blur();
    })

    function stopVideo(video) {
        $(video).get(0).play();
        setTimeout(function() {
            $(video).get(0).pause();
            $(video).get(0).currentTime = 0;
        }, 100);
    }
</script>
{{-- @endpush --}}
{{-- @push('after-script')
    <script>
        if (!$.fn.DataTable.isDataTable('#recorded_classes-table')) {
            $('#recorded_classes-table').on('order.dt', function() {
                    editArrows()
                })
                .on('search.dt', function() {
                    editArrows()
                }).DataTable({
                    "language": {
                        "emptyTable": "No Recordings Found"
                    },
                    "aaSorting": [],

                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 3]
                    }, ],
                });
            styleSearchField();
                    $(document).on('click', '.paginate_button', function() {
            editArrows()
        });
        $('.dataTables_length select').on('change', function() {
            editArrows()
        })
        }
    </script>
@endpush --}}
