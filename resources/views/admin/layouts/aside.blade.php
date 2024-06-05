@php

$aside = [
    
    [
        'name' => 'Dashboard',
        'url' => \Illuminate\Support\Facades\Route::has(auth()->user()->user_type. '.dashboard') ? route(auth()->user()->user_type . '.dashboard') : '#',
        'icon' => 'fas fa-chart-line',
        'type' => 'menu-item',
        'child' => [],
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'dashboard',
    ],
    [
        'name' => 'Generals',
        'type' => 'menu-title',
    ],
    [
        'name' => 'Courses',
        'type' => 'menu-parent',
        'icon' => 'fas fa-book',
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'courses',
        'active_list' => [ \Illuminate\Support\Facades\Route::has(auth()->user()->user_type . '.courses.list') ? route(auth()->user()->user_type.'.courses.list') : '#',  \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.courses.add') ? route(auth()->user()->user_type.'.courses.add') : '#'],
        'child' => [
            [
                'name' => 'Courses List',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.courses.list') ? route(auth()->user()->user_type.'.courses.list') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::View,
                'module' => 'courses',
            ],
            [
                'name' => 'Add Courses',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.courses.add') ?  route(auth()->user()->user_type.'.courses.add') : '#', 
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::Add,
                'module' => 'courses',
            ],
        ],
    ],
    [
        'name' => 'Subscription Plan',
        'type' => 'menu-parent',
        'icon' => 'fas fa-tag',
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'subscription-plans',
        'active_list' => [ \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.subscription-plans.add')  ? route(auth()->user()->user_type.'.subscription-plans.add') : '#',  \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.subscription-plans.list') ? route(auth()->user()->user_type.'.subscription-plans.list') : '#'],
        'child' => [
            [
                'name' => 'Subscriptions List',
                'url' => \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.subscription-plans.list') ? route(auth()->user()->user_type.'.subscription-plans.list') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::View,
                'module' => 'subscription-plans',
            ],
            [
                'name' => 'Add Subscriptions',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.subscription-plans.add') ?  route(auth()->user()->user_type.'.subscription-plans.add') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::Add,
                'module' => 'subscription-plans',
            ],
        ],
    ],
    [
        'name' => 'Shared Library',
        'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.shared-library.list') ?  route(auth()->user()->user_type.'.shared-library.list') : '#',
        'type' => 'menu-item',
        'icon' => 'fas fa-folder-open',
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'shared-library',
    ],
    // [
    //     'name' => 'Class Schedule',
    //     'url' => route('admin.class-schedule.view'),
    //     'type' => 'menu-item',
    //     'icon' => 'fas fa-calendar-alt',
    //     'permission' => \App\Classes\AlQuranConfig::View,
    //     'module' => 'class-scheudle',
    // ],
    [
        'name' => 'Users & Settings',
        'type' => 'menu-title',
        'role' => 'admin',
    ],
    [
        'name' => 'Users',
        'type' => 'menu-parent',
        'icon' => 'fas fa-users',
        'active_list' => [ \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.users.list') ?  route(auth()->user()->user_type.'.users.list') : '#',  \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.users.add') ?  route(auth()->user()->user_type.'.users.add') : '#'],
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'users',
        'child' => [
            [
                'name' => 'Users List',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.users.list') ?  route(auth()->user()->user_type.'.users.list') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::View,
                'module' => 'users',
            ],
            [
                'name' => 'Add Users',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.users.add') ?  route(auth()->user()->user_type.'.users.add') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::Add,
                'module' => 'users',
            ],
        ],
    ],
    [
        'name' => 'Roles',
        'type' => 'menu-parent',
        'icon' => 'fas fa-users-cog',
        'active_list' => [ \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.roles.list') ?  route(auth()->user()->user_type.'.roles.list') : '#',  \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.roles.add') ?  route(auth()->user()->user_type.'.roles.add') : '#'],
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'roles',
        'child' => [
            [
                'name' => 'Roles List',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.roles.list') ?  route(auth()->user()->user_type.'.roles.list') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::View,
                'module' => 'roles',
            ],
            [
                'name' => 'Add Roles',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.roles.add') ?  route(auth()->user()->user_type.'.roles.add') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::Add,
                'module' => 'roles',
            ],
        ],
    ],
    [
        'name' => 'Permissions',
        'type' => 'menu-parent',
        'icon' => 'fas fa-user-shield',
        'active_list' => [ \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.permissions.add') ?  route(auth()->user()->user_type.'.permissions.add') : '#',  \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.permissions.list') ?  route(auth()->user()->user_type.'.permissions.list') : '#'],
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'permissions',
        'child' => [
            [
                'name' => 'Permissions List',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.permissions.list') ?  route(auth()->user()->user_type.'.permissions.list') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::View,
                'module' => 'permissions',
            ],
            [
                'name' => 'Add Permissions',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.permissions.add') ?  route(auth()->user()->user_type.'.permissions.add') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::Add,
                'module' => 'permissions',
            ],
        ],
    ],
    [
        'name' => 'Settings',
        'type' => 'menu-parent',
        'icon' => 'fas fa-cog',
        'permission' => \App\Classes\AlQuranConfig::View,
        'module' => 'settings',
        'active_list' => [ \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.settings.list')  ? route(auth()->user()->user_type.'.settings.list') : '#',  \Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.settings.add')  ?  route(auth()->user()->user_type.'.settings.add') : '#'],
        'child' => [
            [
                'name' => 'Settings List',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.settings.list') ?  route(auth()->user()->user_type.'.settings.list') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::View,
                'module' => 'settings',
            ],
            [
                'name' => 'Add Settings',
                'url' =>\Illuminate\Support\Facades\Route::has(auth()->user()->user_type.'.settings.add') ?  route(auth()->user()->user_type.'.settings.add') : '#',
                'type' => 'menu-item',
                'permission' => \App\Classes\AlQuranConfig::Add,
                'module' => 'settings',
            ],
        ],
    ],
];
@endphp

<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ url('/') }}">
            <img alt="Logo" src="{{ asset('images/logo_white.png') }}" class="h-50px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                @foreach ($aside as $menu)
                    @if ($menu['type'] == 'menu-item' &&
                        auth()->user()->can($menu['permission'] . '-' . $menu['module']))
                        <div class="menu-item">
                            <a class="menu-link {{ $menu['url'] == request()->url() ? 'active' : '' }}"
                                href="{{ $menu['url'] ?? '#' }}">
                                @isset($menu['icon'])
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="{{ $menu['icon'] }}"></i>
                                        </span>
                                    </span>
                                @endisset
                                <span class="menu-title">{{ $menu['name'] ?? '--' }}</span>
                            </a>
                        </div>
                    @elseif($menu['type'] == 'menu-title')
                        <div class="menu-item">
                            <div class="menu-content pt-8 pb-2">
                                <span
                                    class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $menu['name'] ?? '--' }}</span>
                            </div>
                        </div>
                    @elseif($menu['type'] == 'menu-parent')
                        @can($menu['permission'] . '-' . $menu['module'])
                            <div data-kt-menu-trigger="click"
                                class="menu-item menu-accordion mb-1 @isset($menu['active_list']) @if (in_array(request()->url(), $menu['active_list'])) show @endif @endisset">
                                <span class="menu-link">
                                   
                                    @isset($menu['icon'])
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="{{ $menu['icon'] }}"></i>
                                            </span>
                                        </span>
                                    @endisset
                                    <span class="menu-title">{{ $menu['name'] ?? '--' }}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                @if (count($menu['child']))
                                    <div
                                        class="menu-sub menu-sub-accordion @isset($menu['active_list']) @if (in_array(request()->url(), $menu['active_list'])) show @endif @endisset">
                                        @foreach ($menu['child'] as $child)
                                            @can($child['permission'] . '-' . $child['module'])
                                                @if ($child['type'] == 'menu-item')
                                                    <div class="menu-item">
                                                        <a class="menu-link {{ $child['url'] == request()->url() ? 'active' : '' }}"
                                                            href="{{ $child['url'] ?? '#' }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">{{ $child['name'] ?? '--' }}</span>
                                                        </a>
                                                    </div>
                                                @elseif($child['type'] == 'child-parent')
                                                    <div data-kt-menu-trigger="click"
                                                        class="menu-item menu-accordion @isset($child['active_list']) @if (in_array(request()->url(), $child['active_list'])) show @endif @endisset">
                                                        <span class="menu-link">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">{{ $child['name'] ?? '--' }}</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        @if (count($child['child']))
                                                            <div
                                                                class="menu-sub menu-sub-accordion @isset($child['active_list']) @if (in_array(request()->url(), $child['active_list'])) show @endif @endisset">
                                                                @foreach ($child['child'] as $sub_child)
                                                                    @if ($sub_child['type'] == 'menu-item' &&
                                                                        auth()->user()->can($sub_child['permission'] . '-' . $sub_child['module']))
                                                                        <div class="menu-item">
                                                                            <a class="menu-link {{ $sub_child['url'] == request()->url() ? 'active' : '' }}"
                                                                                href="{{ $sub_child['url'] ?? '#' }}">
                                                                                <span class="menu-bullet">
                                                                                    <span class="bullet bullet-dot"></span>
                                                                                </span>
                                                                                <span
                                                                                    class="menu-title">{{ $sub_child['name'] }}</span>
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endcan
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endcan
                    @endif
                @endforeach

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
</div>
