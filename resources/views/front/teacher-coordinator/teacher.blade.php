<div class="container view-teachers">
    <h4 class="px-24 text-sb mb-sm-2 mb-4">{{ __('All Teachers') }}</h4>
    <table class="vertical-table table-borderless" id="teachers_table">
        <thead class="table-header">
            <tr>
                <th scope="col" class="ps-2">{{ __('Teacher Name') }}</th>
                <th scope="col" class="">{{ __('Attendance') }}</th>
                <th scope="col" class="">{{ __('Assigned Student') }}</th>
                <th scope="col" class="">{{ __('Classed Recording') }}</th>
                <th scope="col" class="pe-2 ">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($teachers as $teacher) --}}
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students" aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            {{-- @endforeach --}}


            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Saad Yasin', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Saad Yasin</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Khadija Mudassar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Khadija Mudassar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Hamza Moeen', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Hamza Moeen</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Noman Ali Khan', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Noman Ali Khan</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>

            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Nayab Riaz', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Nayab Riaz</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Talha Mubashar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Talha Mubashar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Fatima Butt', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Fatima Butt</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            {{-- @foreach ($teachers as $teacher) --}}
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students" aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            {{-- @endforeach --}}


            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Saad Yasin', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Saad Yasin</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Khadija Mudassar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Khadija Mudassar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Hamza Moeen', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Hamza Moeen</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Noman Ali Khan', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Noman Ali Khan</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>

            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Nayab Riaz', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Nayab Riaz</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Talha Mubashar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Talha Mubashar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Fatima Butt', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Fatima Butt</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students " aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>

            {{-- @foreach ($teachers as $teacher) --}}
            <tr>
                <td data-label="Teacher Name">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}</div>
                        <div
                            class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                            Haroon Mukhtar</div>
                    </div>
                </td>
                <td data-label="Attendance">
                    <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#attendance" role="tab" aria-controls="attendance" aria-selected="true">View
                            Attendance</a></div>
                </td>
                <td data-label="Assigned Student">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#students" role="tab" aria-controls="students" aria-selected="true">View
                            Students</a></div>
                </td>
                <td data-label="Class Recordings">
                    <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                            class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0" data-bs-toggle="tab"
                            data-bs-target="#recordings" role="tab" aria-controls="recordings" aria-selected="true">View
                            Recordings</a></div>
                </td>
                <td data-label="Action">
                    <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                </td>
            </tr>
            {{-- @endforeach --}}


        </tbody>
    </table>
</div>
@push('after-style')
    <style>
        .view-teachers {
            margin-bottom: 50px;
        }
        #teachers_table {
            table-layout: auto;
        }

        .view-teachers .btn-custom>a:hover {
            font-weight: 600;
            text-decoration: underline;
            color: var(--primary-color) !important;
        }

        .view-teachers .btn-custom>a {
            font-size: var(--px-14);
        }

        .vertical-table .btn:focus {
            box-shadow: none;
        }
    </style>
@endpush
@push('after-script')
    <script>
        $('.vertical-table a.nav').on('click', function() {
            $(this).removeClass('active');
        })
        $(document).ready(function() {
            $('#teachers_table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [1, 2, 3, 4]
                }]
            });
            addArrows();
            $(document).on('click', '.paginate_button', function() {
                addArrows()
            });
            $('.dataTables_length select').on('change', function() {
                addArrows()
            })
            styleSearchField();
        });
    </script>
@endpush
