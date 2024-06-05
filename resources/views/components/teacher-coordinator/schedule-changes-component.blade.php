<div class="container schedule_changes">
    <h4 class="px-24 text-sb mb-4">{{ __('MakeUp Classes') }}</h4>
    <table class="vertical-table table-borderless" id="schedule_changes-table">
        <thead class="table-header">
            <tr>
                <th scope="col" class="ps-2">{{ __('Teacher Name') }}</th>
                <th scope="col">{{ __('Student Name') }}</th>
                <th scope="col">{{ __('Student Reg No') }}</th>

                <th scope="col">{{ __('Course') }}</th>
                <th scope="col">{{ __('Previous Time Slot') }}</th>
                <th scope="col" class="pe-2">{{ __('New Time Slot') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($Model->Reschedule_Requests as $key => $EachRequest)
                <tr>
                    <td data-label="Teacher Name">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name($EachRequest->Teacher->name, 45) !!}</div>
                            <div class="col-12 col-lg-10 col-md-9 align-self-center pe-0 ps-0 ps-md-4"
                                style="text-transform: capitalize">
                                {{ $EachRequest->Teacher->name }}</div>
                        </div>
                    </td>
                    <td data-label="Student Name">
                        <div> {{ $EachRequest->Student->name }}</div>
                    </td>
                    <td data-label="Student Reg No">
                        <div> {{ $EachRequest->Student->reg_no }}</div>
                    </td>
                    <td data-label="Course">
                        <div>{{ $EachRequest->Student->course->title }}</div>
                    </td>
                    <td data-label="Previous Time Slot">
                        <div class="d-flex d-sm-block justify-content-end time-slot mx-sm-auto">
                            {{ is_null($EachRequest->old_class_time) ? 'Not Known ' : convertTimeToUSERzone($EachRequest->old_class_time, $EachRequest->Teacher->timezone)->format('Y-m-d h:i A') }}
                        </div>
                    </td>
                    <td data-label="New Time Slot">
                        <div class="d-flex d-sm-block justify-content-end time-slot mx-sm-auto">
                            {{ is_null($EachRequest->reschedule_date) ? 'Not Known ' : convertTimeToUSERzone(\Carbon\Carbon::parse($EachRequest->reschedule_date)->addMinutes($EachRequest->slot * 30), $EachRequest->Teacher->timezone)->format('Y-m-d h:i A') }}

                        </div>
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>

<style>
    @media screen and (min-width:576px) {
        .vertical-table .time-slot {
            width: 105px;
            text-align: left;
        }

        .schedule_changes .vertical-table th:last-child,
        .schedule_changes .vertical-table td:last-child {
            text-align: center !important;
            padding-right: 10px;
        }
    }
</style>
<script>
    $(document).ready(function() {
        $('#schedule_changes-table').on('order.dt', function() {
                editArrows()
            })
            .on('search.dt', function() {
                editArrows()
            }).DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "aaSorting": [],
                    "targets": [4, 5]
                }]
            });
        $(document).on('click', '.paginate_button', function() {
            editArrows()
        });
        $('.dataTables_length select').on('change', function() {
            editArrows()
        })
        editArrows();
        styleSearchField();
    })
</script>
