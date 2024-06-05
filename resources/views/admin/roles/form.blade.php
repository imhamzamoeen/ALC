<div class="row">
    <div class="col-md-9">
        <div class="card mb-5">
            <div class="card-header border-0 pt-6">
                <div class="card-title border-custom-bottom">
                    <h4>{{ beautify_slug($module_action) }} {{ $module_title }}</h4>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="d-flex flex-column me-n7 pe-7">

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Name" value="{{ old('name', @$data->name) }}" form="create-user-form">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        @include('admin.partials.status-input')
        <div class="card mt-6">
            <div class="card-body">
                @yield('actions')
            </div>
        </div>
    </div>
</div>
