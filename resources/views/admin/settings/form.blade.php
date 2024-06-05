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
                            <label class="required fw-bold fs-6 mb-2">Key</label>
                            <input type="text" name="key" class="form-control @error('key') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Key" value="{{ old('key') }}" form="create-user-form">
                            @error('key')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Value</label>
                            <input type="text" name="value" class="form-control @error('value') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Value" value="{{ old('value', @$data->name) }}" form="create-user-form">
                            @error('value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                         <div class="row">
                              <div class="col-md-6">
                                  <div class="fv-row mb-7 fv-plugins-icon-container">
                                      <label class="fw-bold fs-6 mb-2">Select Category</label>
                                      <select class="form-select form-select-solid @error('category') is-invalid @enderror" data-kt-select2="true" name="category"  data-placeholder="Select category" form="create-user-form" >
                                          <option></option>
                                          @foreach($categories as $category)
                                              <option value="{{ $category }}" @if(old('category') == $category) selected @endif>{{ beautify_slug($category) }}</option>
                                          @endforeach
                                      </select>
                                      @error('category')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="fv-row mb-7 fv-plugins-icon-container">
                                      <label class="fw-bold fs-6 mb-2">Add a new category Instead</label>
                                      <input type="text" name="new_category" class="form-control @error('new_category') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Value" value="{{ old('new_category') }}" form="create-user-form">
                                      @error('new_category')
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
                <label class="required fw-bold fs-6 mb-5">Required?</label>
                <div>
                    @php $requires = ['required' => 1, 'not_required' => 0]; @endphp
                    @foreach($requires as $key => $require)
                        <div class="d-inline-block @if(!$loop->first) ms-4 @endif">
                            <input class="form-check-input" name="is_required" type="radio" value="{{ $require }}" id="require-{{$key}}" @if(old($key) == $require) checked="checked" @endif form="create-user-form">
                            <label class="form-check-label" for="require-{{$key}}">
                                <div class="fw-bolder text-gray-800">{{ beautify_slug($key) }}</div>
                            </label>
                        </div>
                    @endforeach
                    @error('status')
                    <div class="text-danger">
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
