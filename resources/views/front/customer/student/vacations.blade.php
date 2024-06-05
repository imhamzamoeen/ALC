@extends('front.layouts.master')

@section('content')<div class="container vacations">
        <h4 class="px-18 text-med">Vacation Mode</h4>
        <p class="px-14 text-med">your request will be reviewed by Teacher Coordinator and you will be contacted within 12-48
            hours.</p>
        <table class="vertical-table table-borderless">
            <thead class="table-header">
                <tr>
                    <th scope="col" class="ps-2">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col" class="pe-2">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Name">
                        Sheikh Arslan
                    </td>
                    <td data-label="Status">
                        <p class="mt-0 mb-0"> <span class="badge status-pill status-primary">Pending</span></p>
                    </td>
                    <td data-label="Action">
                        <a class="text-dark px-14 text-med text-decoration-none"
                            href={{ url('/en/customer/student/vacation-request') }}>View Request</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
@stop
@push('after-style')
    <style>
        .vacations {
            margin-top: 90px
        }
        .vacations tbody td:last-child > a:hover{
            text-decoration: underline;
            font-weight: 600;
        }
    </style>
@endpush
