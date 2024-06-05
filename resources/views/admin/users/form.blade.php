<div class="row">
    <div class="col-md-9">
        <div class="card mb-5">
            <div class="card-header border-0 pt-6">
                <div class="card-title border-custom-bottom">
                    <h4>{{ beautify_slug($action) }} User</h4>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="d-flex flex-column me-n7 pe-7">

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Full Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror form-control-solid mb-3 mb-lg-0"
                                placeholder="Full name" value="{{ old('name', @$user->name) }}" form="create-user-form">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror form-control-solid mb-3 mb-lg-0"
                                placeholder="example@domain.com" value="{{ old('email', @$user->email) }}"
                                autocomplete="false" form="create-user-form" @if ($action=='edit' ) readonly @endif>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Phone</label>
                            <input style="width: 100%" type="tel" id="phone" name="phone"
                                oninput="this.value=this.value.replace(/[^0-9.(.).' '.-]/g,'');"
                                class="@error('phone') is-invalid @enderror form-control @error('phone') is-invalid @enderror form-control-solid mb-3 mb-lg-0"
                                onkeyup="process(event)" value="{{ old('phone', @$user->phone) }}" required
                                form="create-user-form" />
                            <div class="alert alert-info" style="display: none"></div>
                            <div class="alert alert-warning" style="display: none;"></div>
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="separator separator-dashed my-5"></div>
                        <div class="card-title border-custom-bottom">
                            <h4>Set Password</h4>
                        </div>

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror form-control-solid mb-3 mb-lg-0"
                                placeholder="Minimum 6 characters" value="" form="create-user-form">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="required fw-bold fs-6 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password') is-invalid @enderror form-control-solid mb-3 mb-lg-0"
                                placeholder="Password confirmation" value="" form="create-user-form">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            @if ($action == 'add')
                            <div class="col-md-6">
                                <div class="d-inline-block">
                                    <input class="form-check-input" name="should_verify" type="checkbox" value="1"
                                        id="user_should_verify" form="create-user-form">
                                    <label class="form-check-label ms-5" for="user_should_verify">
                                        <div class="fw-bolder text-gray-800">Verified Email Address</div>
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-inline-block">
                                    <input class="form-check-input" name="notify_user" type="checkbox" value="1"
                                        id="notify_user" form="create-user-form">
                                    <label class="form-check-label ms-5" for="notify_user">
                                        <div class="fw-bolder text-gray-800">Notify user with credentials</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <label class="required fw-bold fs-6 mb-5">Status</label>
                <div>
                    @foreach (\App\Classes\Enums\StatusEnum::$Basic_statuses as $key => $status)
                    <div class="d-inline-block @if (!$loop->first) ms-4 @endif">
                        <input class="form-check-input" name="status" type="radio" value="{{ $status }}"
                            id="status-{{ $key }}" @if (@$user->status == $status || $loop->first) checked="checked"
                        @endif form="create-user-form">
                        <label class="form-check-label" for="status-{{ $key }}">
                            <div class="fw-bolder text-gray-800">{{ beautify_slug($status) }}</div>
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
        {{-- @if ($action != 'edit') --}}
        <div class="card mt-6 @if ($action == 'edit') d-none @endif">
            <div class="card-body">
                <div class="mb-7">
                    <label class="required fw-bold fs-6 mb-5">Role</label>
                    {{-- to filter out which roles should be shown to admin and tc and customer support --}}
                    <?php   $query = \Spatie\Permission\Models\Role::query()->where(
                        'status',
                        \App\Classes\Enums\StatusEnum::Active
                    );
                    $query->when(auth()->user()->hasRole(\App\Classes\Enums\UserTypesEnum::TC), function ($q, $role) {
                        return $q->where('name', \App\Classes\Enums\UserTypesEnum::Teacher);
                    });
                    $query->when(auth()->user()->hasRole(\App\Classes\Enums\UserTypesEnum::CustomerSupport), function ($q) {
                        return $q->where('name', \App\Classes\Enums\UserTypesEnum::Customer);
                    });
                     $roles = $query->get();
                        ?>
                    @foreach ($roles as $key => $role)
                    <div class="d-flex fv-row">
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input me-3" name="user_type" type="radio" value="{{ $role->name }}"
                                id="user_type-{{ $key }}" @isset($user) @if (@$user->hasRole($role->name))
                            checked="checked" @endif @endisset
                            form="create-user-form">
                            <label class="form-check-label" for="user_type-{{ $key }}">
                                <div class="fw-bolder text-gray-800">{{ beautify_slug($role->name) }}</div>
                            </label>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-5"></div>
                    @endforeach
                    @error('user_type')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        {{-- @endif --}}
        <div class="card mt-6">
            <div class="card-body">
                @yield('actions')
            </div>
        </div>
    </div>
</div>