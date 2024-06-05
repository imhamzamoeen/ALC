<tr>
    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
        <p></p>
        <h2>Dear {{ ucfirst($details['user']) }}
        </h2>
       
    </td>
</tr>
<tr>
    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
        

        <p>
            The {{ ucfirst($details['Requester']) }} <strong> {{ ucfirst($details['Requester_Name']) }} </strong>
            has requested to reschedule
            <strong>

                {{ ucfirst($details['Other_Type'].' '.$details['Other_Name']).'`s '.$details['Course_Name'] }}
            </strong>
            class from <strong> {{
                $details['Old_Class']->format('D, d M - h:i
                A') }} </strong> to <strong>{{ $details['New_Class']->format('D, d M - h:i
                A') }}

            </strong>
            {{-- <br>
            Email: <a class="text" style=" color: #0A5CD6;   font-weight: bold;"
                href="mailto:{{ env('SALES_SUPPORT_EMAIL') }}">{{ env('SALES_SUPPORT_EMAIL') }}</a> --}}
        </p>

    </td>
</tr>