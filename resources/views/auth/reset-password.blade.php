@extends('auth.layouts.auth_master')

@section('content')


    <div class="d-flex w-100 h-800px h-xl-900px justify-content-center align-items-center bg-white">

        <form class="w-md-600px form flex-lg-grow-0 px-5 top_space" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <h3 class="mb-10 font-weight-bolder text-dark">{{ __('Reset Password') }}</h3>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark" for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control h-auto py-3 px-4 border-2 font-size-h6" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email', $request->email) }}" readonly>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group password-field">
                <label class="font-size-h6 font-weight-bolder text-dark" for="password">New Password</label>
                <input type="password" name="password" class="form-control h-auto py-3 px-4 border-2 font-size-h6 @error('password') is-invalid @enderror" id="password" aria-describedby="NewPassword" placeholder="Enter New Password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark" for="confirm">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control h-auto py-3 px-4 border-2 font-size-h6 @error('password') is-invalid @enderror" id="confirm" aria-describedby="ConfirmNewPassword"  placeholder="Confirm New Password">

            </div>


                <button type="submit" class="btn btn-primary w-100 py-3" style="background-color: #0A5CD6;">
                    {{ __('Reset Password') }}
                </button>

        </form>
        @if (session('status'))
            <div class="alert alert-primary w-100 py-3 ">
                {{ session('status') }}
            </div>
        @endif
    </div>

{{--    <div class="login-content flex-column-fluid d-flex flex-column p-10 rightside">--}}

{{--        <div class="d-flex flex-row-fluid flex-center rightdiv">--}}

{{--            <div class="login-form login-form-signup" id="kt_login_singin_form">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="mt-4 flex items-center justify-between">--}}
{{--                            <form method="POST" action="{{ route('password.update') }}">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="token" value="{{ $request->route('token') }}">--}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">Email address</label>--}}
{{--                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email', $request->email) }}" readonly>--}}
{{--                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="password">New Password</label>--}}
{{--                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" aria-describedby="NewPassword" placeholder="Enter New Password">--}}
{{--                                    @error('password')--}}
{{--                                        <div class="invalid-feedback">--}}
{{--                                            {{ $message }}--}}
{{--                                        </div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="confirm">Confirm Password</label>--}}
{{--                                    <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="confirm" aria-describedby="ConfirmNewPassword"  placeholder="Confirm New Password">--}}
{{--                                </div>--}}

{{--                                <div class="flex items-center justify-end mt-4">--}}
{{--                                    <button type="submit" class="btn btn-primary">--}}
{{--                                        {{ __('Reset Password') }}--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
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

@push('after-scripts')
<script>
</script>
@endpush
