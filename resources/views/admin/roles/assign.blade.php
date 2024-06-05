@extends('admin.layouts.admin_master',['page' => $module_slug, 'action' => $module_action])

@section('actions')
    <div class="text-center">
        <button type="reset" class="btn btn-light me-3" form="create-user-form">Reset</button>
        <button id="submit-user-btn" type="submit" class="btn btn-primary submit-user-btn" form="create-user-form">
            <span class="indicator-label">Submit</span>
        </button>
    </div>
@endsection
@section('content')
    <form id="create-user-form" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.'.$module_slug.'.assign_permissions', $role->id) }}">@csrf</form>
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-5">
                <div class="card-header border-0 pt-6">
                    <div class="card-title border-custom-bottom">
                        <h4>{{ beautify_slug($module_action) }} {{ $module_title }}</h4>
                    </div>
                </div>
                <div class="separator separator-dashed my-5"></div>
                <div class="card-body pt-0">
                    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="d-flex flex-column me-n7 pe-7">
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" id="select-all-check" type="checkbox" data-kt-check="true" data-kt-check-target="#permissions-list .form-check-input" value="1">
                                    <label class="form-check-label" for="select-all-check">
                                        <div class="fw-bolder text-gray-800">Select All</div>
                                    </label>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="row" id="permissions-list">
                                @foreach($permissions as $key => $permission)
                                    <div class="col-md-6">
                                        <div class="d-flex fv-row">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input me-3" name="permissions[]" type="checkbox" value="{{ $permission->id }}" id="checkbox-{{$key}}" form="create-user-form" @if($role->hasPermissionTo($permission)) checked="checked" @endif>
                                                <label class="form-check-label" for="checkbox-{{$key}}">
                                                    <div class="fw-bolder text-gray-800">{{ beautify_slug($permission->name) }}</div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-5"></div>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mt-6">
                <div class="card-body">
                    @yield('actions')
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-css')
    <style>

    </style>
@endpush
@push('after-script')
    <script>

    </script>
@endpush
