<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ !empty($page) ? beautify_slug($page) : 'AlQuran Admin' }}
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">
                    <a href="{{ route('admin.dashboard') }}">{{ ucfirst(auth()->user()->user_type) }} </a>
                    @if(!empty($page))
                        /
                    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.'.$page.'.list') ? route('admin.'.$page.'.list') : '#' }}">{{ beautify_slug($page) }} </a>
                    @endif
                    {{ !empty($action) ? '/ '.beautify_slug($action) : '' }}
                </small>
            </h1>
        </div>
        <!--begin::Actions-->
            @yield('actions')
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
