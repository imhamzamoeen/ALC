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

                        {{--<div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Name" value="{{ old('name', @$data->name) }}" form="create-user-form">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>--}}
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-10">
                                    <label class="form-label fw-bold">Module:</label>
                                    <div>
                                        <select class="form-select form-select-solid @error('module') is-invalid @enderror @error('name') is-invalid @enderror" data-kt-select2="true" name="module"  data-placeholder="Select option" data-allow-clear="true" id="module-option"  form="create-user-form">
                                            <option></option>
                                            @foreach(\App\Classes\AlQuranConfig::$Modules as $key => $actions)
                                                <option value="{{ $key }}" data-options="{{ json_encode($actions) }}">{{ beautify_slug($key) }}</option>
                                            @endforeach
                                        </select>
                                        @error('module')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        @error('name')
                                        <strong class="invalid-feedback">
                                            {{ $message }}
                                        </strong>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-10">
                                    <label class="form-label fw-bold">Action:</label>
                                    <div>
                                        <select class="form-select form-select-solid @error('action') is-invalid @enderror" data-kt-select2="true" name="action"  data-placeholder="Select option"  data-allow-clear="true" id="module-actions"  form="create-user-form">
                                            <option></option>
                                        </select>
                                        @error('action')
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

@push('after-script')
    <script>

        $('#module-option').on('change', function () {
            var options = $(this).find(':selected').data('options');
            $('#module-actions')
                .find('option')
                .remove().end();
            options.forEach(function (item, index) {
                $('#module-actions').append('<option value="'+item+'">'+item+'</option>')
                    .val('whatever')
                ;
            })
        })

    </script>
@endpush
