@extends('admin.layouts.admin_master',['page' => $module_slug, 'action' => $module_action])

@section('actions')
    <div class="text-center">
        <button type="reset" class="btn btn-light me-3" form="create-user-form">Reset</button>
        <button id="submit-user-btn" type="submit" class="btn btn-primary submit-user-btn" form="create-user-form">
            <span class="indicator-label">Update</span>
        </button>
    </div>
@endsection
@section('content')
    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>
                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>
            </svg>
        </span>
        <div class="d-flex flex-stack flex-grow-1">
            <div class="fw-bold">
                <div class="fs-6 text-gray-700">
                    <strong class="me-1">Warning!</strong>By editing the settings, you might effect the system functionality. Please ensure you're absolutely certain before proceeding.
                </div>
            </div>
        </div>
    </div>
    <form id="create-user-form" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.'.$module_slug.'.update') }}">@csrf</form>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header border-0 pt-6">
                    <div class="card-title border-custom-bottom">
                        <h4>{{ beautify_slug($module_action) }} {{ $module_title }}</h4>
                    </div>
                </div>
                <hr>
                <div class="card-body pt-0">
                    @foreach($categories as $category)
                        <h2 class="mt-7 mb-7">{{ beautify_slug($category) }}</h2>
                        <div class="container">
                            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="d-flex flex-column me-n7 pe-7">

                                    @foreach($data as $row)
                                        @if($row->category == $category)
                                            <input class="" type="hidden" name="{{$row->key}}[is_required]" id="" value="{{ $row->is_required }}"  placeholder="" form="create-user-form"/>
                                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                                <label class="@if($row->is_required == 1) required  @endif fw-bold fs-6 mb-2">{{ beautify_slug($row->key) }}</label>
                                                <input class="form-check-input float-end" name="{{$row->key}}[status]" type="checkbox" value="{{ \App\Classes\Enums\StatusEnum::Active }}" id="_status_{{$row->key}}" @if(@$row->status == \App\Classes\Enums\StatusEnum::Active) checked="checked" @endif form="create-user-form" @if($row->is_required == 1)  onclick="return false;"  @endif>
                                                @if($row->is_required == 0)
                                                    <a href="javascript:void(0);" data-name="{{ beautify_slug($row->key) }}" data-id="{{ $row->id }}" class="menu-link px-3 float-end delete-btn"><i class="fa fa-trash-alt"></i></a>
                                                @else
                                                    <span class="text-muted float-end me-4">Mandatory</span>
                                                @endif
                                                @switch($row->type)

                                                    @case('textarea')
                                                    <textarea type="text" name="{{ $row->key }}[value]" class="form-control @error($row->key) is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="{{ beautify_slug($row->key) }}"  form="create-user-form" @if($row->is_required == 1) required @endif>{{ old($row->key, settings($row->key, false)) }}</textarea>
                                                        @break
                                                    @default
                                                        <input type="text" name="{{ $row->key }}[value]" class="form-control @error($row->key) is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="{{ beautify_slug($row->key) }}" value="{{ old($row->key, settings($row->key, false)) }}" form="create-user-form" @if($row->is_required == 1) required @endif>
                                                        @break

                                                @endswitch

                                                @error($row->key.'value')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>{!! !$loop->last ? '<hr>':'' !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card float-end">
        <div class="card-body">
            @yield('actions')
        </div>
    </div>


@endsection

@push('after-css')
    <style>

    </style>
@endpush
@push('after-script')
    <script>
        $('.delete-btn').on('click', function () {
            Swal.fire({
                text: 'Are you sure you want to delete "'+ $(this).data('name') +'" setting?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('{{ URL::to('admin/'.$module_slug.'/destroy') }}/' + $(this).data('id'))
                }

            })
        })
    </script>
@endpush
