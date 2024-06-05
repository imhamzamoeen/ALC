@extends('admin.layouts.admin_master')

@section('content')
    <div class="card bg-transparent">
        <div class="border-0 card-header justify-content-center py-15 mt-15">
            <div class="card-title flex-column align-items-center">
                <img width="350px" src="{{ asset('images/empty-requests.svg') }}" />
                <h1 class="fa-2x mb-15 text-center text-gray-700">Welcome to the Dashboard</h1>

            </div>
        </div>
    </div>
@endsection
