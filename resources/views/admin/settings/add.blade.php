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
    <form id="create-user-form" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.'.$module_slug.'.save') }}">@csrf</form>
    @include(auth()->user()->user_type.'.'.$module_slug.'.form')
@endsection

@push('after-css')
    <style>

    </style>
@endpush
@push('after-script')
    <script>

    </script>
@endpush
