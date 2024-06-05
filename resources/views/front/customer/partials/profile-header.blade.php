<div class="w-100 secondary-nav pt-1 position-fixed top-0">
    <div class="container-lg py-1 py-sm-0">
        <div class="row">
            <div class="col-6 col-sm-3 user_name pt-sm-2 pb-sm-1">
                <span><img width="40" class="img-fluid" src="{{ asset('images/profile_picture.svg') }}"
                        alt="user_img"></span>
                <span class="ms-sm-2 px-14 d-sm-none d-inline">{{ $student->first_name ?? '--' }}</span>
                <span class="ms-sm-2 px-14 d-sm-inline d-none"
                    style="text-transform: capitalize">{{ $student->name ?? '--' }}</span>

            </div>
            @if (!Route::is('customer.buySubscription'))
                <div class="col-6 col-sm-9">
                    <ul class="nav top-navs justify-content-end" id="myTab" role="tablist">
                        <li class="nav-item border-custom-bottom pt-md-3 pb-md-3 pt-1 p-2 {{ isset($activeTab) ? ($activeTab == 'basicinfo-tab' ? 'active' : '') : '' }}"
                            data-title="Basic Info" data-intro="Click here to see basic info of student">
                            <a class="nav-link p-0 text-med {{ isset($activeTab) ? ($activeTab == 'basicinfo-tab' ? 'active' : '') : '' }}"
                                role="tab"
                                href="{{ route('customer.user.profile', [app()->getLocale(), 'child' => $student]) }}">
                                <span class="icon icon-profile"></span>
                                <span class="px-2">Basic Information</span>
                            </a>
                        </li>
                        <li class="nav-item border-custom-bottom pt-md-3 pb-md-3 pt-1 p-2 {{ isset($activeTab) ? ($activeTab == 'subscription-tab' ? 'active' : '') : '' }}"
                            role="presentation" data-title="Subscription Settings"
                            data-intro="Click here to view and edit subscriptions">
                            <a class="nav-link p-0 text-med  {{ isset($activeTab) ? ($activeTab == 'subscription-tab' ? 'active' : '') : '' }}"
                                href="{{ route('customer.subscriptionDetails', [app()->getLocale(), 'child' => $student]) }}">
                                <span class="icon
                                icon-card"></span>
                                <span class="px-2">Subscription Details</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item border-custom-bottom pt-md-3 pb-md-3 pt-1 ps-2  {{ isset($activeTab) ? $activeTab == 'vacation-tab' ? 'active' : '':'' }}" role="presentation"
                        data-title="Set Vacation" data-intro="Click here to add vacation request">
                        <a class="nav-link p-0 text-med  {{ isset($activeTab) ? $activeTab == 'vacation-tab' ? 'active' : '':'' }}" id="vacation-tab" data-bs-toggle="tab"
                           data-bs-target="#vacation"  role="tab" aria-controls="vacation"
                           aria-selected="false">
                            <span class="icon icon-airplane"></span>
                            <span class="px-2">Vacation Mode</span>
                        </a>
                    </li> --}}
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
