<tr>
    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
        @foreach($details as $row)
            @foreach($row as $key => $content)
                @switch($key)
                @case($key == 'line')
                    <p>{!! $content !!}</p>
                @break
                @case($key == 'bold')
                    <p class="heading1"><h1>{!! $content !!}</h1></p>
                @break
                @case($key == 'heading1')
                    <p><h1>{!! $content !!}</h1></p>
                @break
                @case($key == 'heading2')
                    <p><h2>{!! $content !!}</h2></p>
                @break
                @case($key == 'heading3')
                    <p><h3>{!! $content !!}</h3></p>
                @break
                @case($key == 'heading4')
                    <p><h4>{!! $content !!}</h4></p>
                @break
                @case($key == 'heading5')
                    <p><h5>{!! $content !!}</h5></p>
                @break
                @case($key == 'heading6')
                    <p><h6>{!! $content !!}</h6></p>
                @break
                @case($key == 'list')
                    @if(is_array($content))
                        <ul  class="text" style="margin-top: 8px;">
                            @foreach($content as $head => $line)
                                <li>
                                    @if(!is_numeric($head)) <span class="heading1">{{ $head }} :</span> @endif {!! $line !!}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @break
                @case($key == 'button')
                    @if(is_array($content) && count($content) > 1)
                        <span style="text-align: center; padding: 0 30px; box-sizing: border-box;">
                        <p style="margin: 10px 0;">
                            <a href="{!! @$content[1] !!}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" class="x_button" style="font-family:Poppins,Roboto,sans-serif; background-color:#0A5CD6; text-decoration:none; border-radius:4px; color:white; display:inline-block; font-size:16px;width:185px;text-align:center; margin:0 8px; padding:0 5px; border:10px solid #0A5CD6;">
                            {!! @$content[0] !!}
                            </a>
                        </p>
                        {{--<p class="text">Or use the link below</p>
                        <p>
                            <a  href="{!! @$content[1] !!}" target="_blank" rel="noopener noreferrer" class="link">Click here......</a>
                        </p>--}}
                        </span>
                    @endif
                @break
                @case($key == 'center-text')
                    <p style="text-align: center" >A single platform to stay connected with all your Retailers and manage all your Product Information</p>
                @break
                @case($key == 'center-bold')
                    <p class="heading1" style="text-align: center" >A single platform to stay connected with all your Retailers and manage all your Product Information</p>
                @break

            @endswitch
            @endforeach
        @endforeach

    </td>
</tr>
