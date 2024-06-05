<div class="container view-students">
    <h4 class="px-24 text-sb mb-4">{{__('All Students')}}</h4>
    <table class="vertical-table table-borderless" id="students-table">
        <thead class="table-header">
            <tr>
                <th scope="col" class="ps-2">{{ __('Student Name') }}</th>
                <th scope="col">{{ __('Attendance') }}</th>
                <th scope="col" class="pe-2">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($teachers as $teacher) --}}
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div class="align-self-center text-md-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a class="nav nav-link nav-item px-0 text-dark py-sm-2  py-0" id="attendance-tab"
                        data-bs-toggle="tab" data-bs-target="#attendance"  role="tab"
                        aria-controls="attendance" aria-selected="true">View Attendance</a></div></td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            {{-- @endforeach --}}

            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div class="align-self-center text-md-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a class="nav nav-link nav-item px-0 text-dark py-sm-2  py-0" id="attendance-tab"
                        data-bs-toggle="tab" data-bs-target="#attendance"  role="tab"
                        aria-controls="attendance" aria-selected="true">View Attendance</a></div></td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div class="align-self-center text-md-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a class="nav nav-link nav-item px-0 text-dark py-sm-2  py-0" id="attendance-tab"
                        data-bs-toggle="tab" data-bs-target="#attendance"  role="tab"
                        aria-controls="attendance" aria-selected="true">View Attendance</a></div></td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div class="align-self-center text-md-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a class="nav nav-link nav-item px-0 text-dark py-sm-2  py-0" id="attendance-tab"
                        data-bs-toggle="tab" data-bs-target="#attendance"  role="tab"
                        aria-controls="attendance" aria-selected="true">View Attendance</a></div></td><td data-label="Action">
                            <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                        </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div class="align-self-center text-md-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a class="nav nav-link nav-item px-0 text-dark py-sm-2  py-0" id="attendance-tab"
                        data-bs-toggle="tab" data-bs-target="#attendance"  role="tab"
                        aria-controls="attendance" aria-selected="true">View Attendance</a></div></td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@push('after-style')
    <style>
        .view-students .btn-custom > a:hover {
            font-weight: 600;
            text-decoration: underline;
            color: var(--primary-color) !important;
        }
        .view-students .btn-custom > a {
            font-size: var(--px-14);
        }
        .vertical-table .btn:focus {
            box-shadow: none;
        }
    </style>
@endpush
@push('after-script')
    <script>
        $(document).ready(function() {
            $('#students-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [1, 2]
                }]
            });
            styleSearchField();
        })
    </script>
@endpush