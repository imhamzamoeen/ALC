@extends('auth.layouts.auth_master')

@section('content')


    <div class="d-flex w-100 h-700px h-lg-500px h-xl-900px justify-content-center align-items-center bg-white login_form">
        
        <form  class="w-md-600px form flex-lg-grow-0 px-5 top_space" method="POST" action="{{ route('password.email') }}">
            @csrf
            <h3 class="mb-10 font-weight-bolder text-dark">{{ __('Forgot Password') }}</h3>
            <p>  {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
            <div class="form-group mb-4">
                <label class="font-size-h6 font-weight-bolder text-dark">{{ __('Email') }}:</label>
                <input type="email" name="email" class="form-control h-auto py-3 px-4 border-2 font-size-h6 @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}" placeholder="Enter email">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            @if (session('status'))
                <div class="alert alert-primary mt-3">
                    {{ session('status') }}
                </div>
            @endif
                <button type="submit" class="btn btn-primary w-100 py-3" style="background-color: #0A5CD6;">
                    {{ __('Send Link') }}
                </button>
            <p class="mt-5 text-center"><b>Remember the password ? </b><a href="{{ route('login') }}" style="text-decoration:none; color:#0A5CD6;">Login</a></p>
        </form>

    </div>

{{--    <div class="login-content flex-column-fluid d-flex flex-column p-10 rightside">--}}

{{--        <div class="d-flex flex-row-fluid flex-center rightdiv">--}}

{{--            <div class="login-form login-form-signup" id="kt_login_singin_form">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="mb-4 text-sm text-gray-600">--}}
{{--                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}--}}
{{--                        </div>--}}
{{--                        <div class="mt-4 flex items-center justify-between">--}}
{{--                            <form method="POST" action="{{ route('password.email') }}">--}}
{{--                                @csrf--}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">Email address</label>--}}
{{--                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}" placeholder="Enter email">--}}
{{--                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
{{--                                </div>--}}

{{--                                <div class="flex items-center justify-end mt-4">--}}
{{--                                    <button type="submit" class="btn btn-primary">--}}
{{--                                        {{ __('Email Password Reset Link') }}--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex pt-3 submitButton alreadyAccount">--}}
{{--                            <p><b>Remember the password ? </b><a href="{{ route('login') }}" style="text-decoration:none; color:#0A5CD6;">Login</a></p><br/><br/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                @if (session('status'))--}}
{{--                    <div class="alert alert-primary mt-3">--}}
{{--                        {{ session('status') }}--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}

@endsection
