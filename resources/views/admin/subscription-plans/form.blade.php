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
                            <label class="required fw-bold fs-6 mb-2">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Title" value="{{ old('title', @$data->title) }}" form="create-user-form">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Description</label>
                            <textarea rows="6" type="text" name="description" class="form-control @error('description') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Description" form="create-user-form">{{ old('description', @$data->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                         <div class="row">
                              <div class="col-md-6">
                                  <div class="fv-row mb-7 fv-plugins-icon-container">
                                      <label class="required fw-bold fs-6 mb-2">US price</label>
                                      <input type="text" name="us_price" class="form-control @error('us_price') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="US price" value="{{ old('us_price', @$data->us_price) }}" form="create-user-form">
                                      @error('us_price')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                      @enderror
                                  </div>
                              </div>
                             <div class="col-md-6">
                                  <div class="fv-row mb-7 fv-plugins-icon-container">
                                      <label class="required fw-bold fs-6 mb-2">UK price</label>
                                      <input type="number" name="uk_price" class="form-control @error('uk_price') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="UK price" value="{{ old('uk_price', @$data->uk_price) }}" form="create-user-form">
                                      @error('uk_price')
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

    <div class="col-md-3">
        @include('admin.partials.status-input')
        <div class="card mt-6">
            <div class="card-body">
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <label class="fw-bold fs-6 mb-2">Select Type</label>
                    <select class="form-select form-select-solid select2-selection--clearable @error('type') is-invalid @enderror" data-kt-select2="true" name="type"  data-placeholder="Select category" form="create-user-form"  data-allow-clear="true">
                        <option></option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" @if(old('type') == $type || @$data->type == $type) selected @endif>{{ beautify_slug($type) }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <label class="fw-bold fs-6 mb-2">Add a new Type Instead</label>
                    <input type="text" name="new_type" class="form-control @error('new_type') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Value" value="{{ old('new_type') }}" form="create-user-form">
                    @error('new_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card mt-6">
            <div class="card-body">
                @yield('actions')
            </div>
        </div>
    </div>
</div>
