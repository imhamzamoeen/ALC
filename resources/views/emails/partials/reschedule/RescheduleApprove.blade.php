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
            

        @if ($details['Requester'] == 'Teacher-Coordinator')
        The

        <strong>{{ $details['Requester'] . ' ' . $details['Requester_Name'] }}
        </strong>
        has rescheduled
        <strong>
            {{ $details['Other_Type'].' '.$details['Other_Name'] . '`s ' . $details['Course_Name'] }}
        </strong>
        @else

        The

        <strong>{{ $details['Other_Type'].' '.$details['Other_Name'] }}
        </strong>
        has Approved the rescheduled request of
        <strong>
            {{ $details['Requester'].' '.$details['Requester_Name'] . '`s ' . $details['Course_Name'] }}
        </strong>
        @endif
        Class for
        <strong> {{
            $details['Old_Class']->format('D, d M - h:i
            A') }} </strong> to <strong>{{ $details['New_Class']->format('D, d M - h:i
            A') }} </strong>

        </p>

    </td>
</tr>