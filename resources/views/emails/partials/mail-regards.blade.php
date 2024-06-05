<tr>
    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
        @if($query)
            <p class="text" style="text-align: left;">
                If you have any questions please contact us at:
                <br>
                Email: <a class="text" style=" color: #0A5CD6;   font-weight: bold;" href="mailto:{{ env('SALES_SUPPORT_EMAIL') }}">{{ env('SALES_SUPPORT_EMAIL') }}</a>
            </p>
        @endif
        <p class="text" style="text-align: left">
            Regards,
            <br>
            <a class="text" style=" color: #0A5CD6;   font-weight: bold;" href="https://www.alquranclasses.com/"  >{{ env('APP_NAME') }}</a>

        </p>
    </td>
</tr>
