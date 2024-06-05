@extends('front.layouts.master', ['parent' => true])

@section('content')
    <div class="container bill-history clearfix">
        <h4 class="text-1 text-med pb-2">{{ __('Billing History for '.Auth::user()->name) }}!</h4>
        <table class="vertical-table table-borderless">
            <thead class="table-header">
                <tr>
                    <th scope="col" class="ps-2">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Billing Period') }}</th>
                    <th scope="col">{{ __('Amount') }}</th>
                    <th scope="col" >{{ __('Status') }}</th>
                    <th scope="col" class="pe-2">{{ __('Download') }}</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach($subscription as $key=>$value)
                <tr>
                    <td data-label="Date">
                        {!! date('M d Y', strtotime($value->start_at)) !!}
                    </td>
                    <td data-label="Billing_Period">Monthly</td>
                    <td data-label="Amount">${{number_format($value->price,2)}}</td>
                    <td data-label="Status">
                        @if($value->payment_status == "COMPLETED" || $value->payment_status == "succeeded")
                        <p class="mt-0 mb-0"> <span class="badge status-pill status-success">Paid</span></p>
                        @else
                        <p class="mt-0 mb-0"> <span class="badge status-pill status-success">Not Paid</span></p>
                        @endif
                    </td>
                    <td data-label="Download">
                        <form action="">
                            <button class="download-btn py-1 px-2" type="submit"><i class="fa fa-download"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
         
            </tbody>
        </table>
        <!-- <button class="btn btn-outline-primary float-end px-5 py-2 mt-sm-5 my-3" onclick="location.href = '/en/customer/profile';"><i class="fa fa-arrow-left me-1"></i> Back</button> -->
    </div>
@stop
@push('after-style')
    <style>
        .bill-history{
            margin-top: 90px;
        }
        .bill-history>h4 {
            font-size: 18px;
        }
        .bill-history .download-btn,
        .bill-history .download-btn:active,
        .bill-history .download-btn:focus {
            background-color: var(--primary-color);
            color: white;
            font-size: 15px;
            border: none;
            outline: none;
        }

        @media screen and (min-width: 768px) {
            .bill-history .vertical-table td:first-child {
                text-align: left;
                padding-left: 5px;
            }

            .bill-history .vertical-table th:last-child,
            .bill-history .vertical-table td:last-child {
                text-align: right !important;
                padding-right: 10px;
            }
        }

    </style>
@endpush
