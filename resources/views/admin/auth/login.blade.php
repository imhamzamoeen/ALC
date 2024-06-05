@extends('admin.auth.admin_auth_master')


@section('content')
    <form class="form w-100" novalidate="novalidate" id="" method="POST" action="{{ route('login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">Sign In to AlQuran Admin</h1>
            <div class="fv-row mb-10 mt-15">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Email</label>
                </div>
                <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off"/>
            </div>


            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                    <a href="password-reset.html" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                </div>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off"/>
            </div>

            <div class="text-center">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember" >
                <button type="submit" id="" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">Continue</span>
                </button>
            </div>
        </div>
    </form>
@endsection
