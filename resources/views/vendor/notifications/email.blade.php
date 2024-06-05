<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
    xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AlQuranClasses | Online Quran Classes From The Best Quran Tutors</title>
    <style type="text/css">

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

        body {
            Margin: 0;
            padding: 0;
            background-color: #d8d8d8;

        }
        table {
            border-spacing: 0;
        }
        td {
            padding: 0;
        }
        img {
            border: 0;

        }

        a{
            text-decoration: none;
            Color:#0A5CD6;
            font-size: 16px;
        }

        .heading1 {
            font-family: 'poppins-bold', sans-serif !important;
            font-weight: 700;
            font-size: 16px;
        }

        .text{
            font-size: 16px;
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            line-height: 1.6rem;
        }

        .link {
            font-size: 16px;
            color: #0A5CD6;
        }

        .gradient-button {
            font-weight: bold;
            font-family: Gadget, sans-serif;
            font-size: 16px;
            padding: 15px 32px;
            text-align: center;
            text-transform: uppercase;
            margin: 4px 2px;
            background-size: 200% auto;
            color: #FFFFFF;

            border-radius: 4px;


            cursor: pointer;
            display: inline-block;
            border-radius: 4px;
        }

        .gradient-button-4 {background-image: linear-gradient(to right, #00d2ff 0%, #3a7bd5 51%, #00d2ff 100%)}




        .button1 {
            border-radius: 4px;
            background-color: #0A5CD6;
            align-content: center;
            border: none;
            color: white;
            padding: 10px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-family: "Poppins SemiBold";
            margin: 4px 2px;
            cursor: pointer;
        }
        .button:hover,
        .button:focus,
        .button:active,
        .button.active
        {
            background-color: #0D47A1;
            color: #FFFFFF;
            border-color: #0D47A1;
        }
        .wrapper {

            width: 100%;
            table-layout: fixed;

            /*	background-color: #f7f7f7;*/
            padding-top: 40px;
            padding-bottom: 40px;


        }

        .webkit{
            max-width: 700px;
            background-color: #ffffff;
        }

        .outer{
            margin: 0 auto;
            width: 100%;
            max-width: 700px;
            border-spacing: 0;
            font-family: sans-serif;
            /*color: #4a4a4a;*/
            background-color: #ffffff;
        }


        .three-columns{

            text-align: center;
            font-size: 0;
            padding-top: 40px;
            padding-bottom: 30px;
        }


        .three-columns .column {
            width: 100px;
            max-width: 200px;
            display: inline-block;
            vertical-align: top;
        }

        .padding{
            padding: 15px;
        }



        .three-columns .content {
            font-size: 15px;
            line-height: 20px;
        }


        @media screen and (max-width: 600px) {
        }
        @media screen and (max-width: 400px) {
        }
    </style>
</head>
<body>
<div class="wrapper" align="center">
    <div class="webkit">
        <table class="outer" align="center" >

            @include('emails.partials.mail-header')
            @if (! empty($greeting))
                <tr>
                    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
                        <h3>{{ $greeting }}</h3>
                    </td>
                </tr>
            @else
                @if ($level === 'error')
                    <tr>
                        <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
                            <h3>@lang('Whoops!')</h3>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
                            <h3>@lang('Hello!')</h3>
                        </td>
                    </tr>
                @endif
            @endif

            @foreach ($introLines as $line)
                <tr>
                    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
                        <p>{{ $line }}</p>
                    </td>
                </tr>
            @endforeach

            @isset($actionText)
                <?php
                switch ($level) {
                    case 'success':
                    case 'error':
                        $color = $level;
                        break;
                    default:
                        $color = 'primary';
                }
                ?>

                    <tr>
                        <td style="padding: 0 30px; box-sizing: border-box; text-align: center !important;">
                            <span style="text-align: center !important; padding: 0 30px; box-sizing: border-box;">
                                <p style="text-align: center !important;">
                                    <a href="{!! $actionUrl !!}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" class="x_button" style="font-family:Poppins,Roboto,sans-serif; background-color:#0A5CD6; text-decoration:none; border-radius:4px; color:white; display:inline-block; font-size:16px; text-align:center; margin:0 8px; padding:0 5px; border:10px solid #0A5CD6;">
                                    {!! $actionText !!}
                                    </a>
                                </p>
                            </span>
                        </td>
                    </tr>
            @endisset

            @foreach ($outroLines as $line)
                <tr>
                    <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
                        <p>{{ $line }}</p>
                    </td>
                </tr>
            @endforeach

            @include('emails.partials.mail-regards', ['query' => isset($query) ? $query : true])


            <tr>
                <td style="padding: 0 30px; box-sizing: border-box; text-align: left;">
                    <br><hr>
                </td>
            </tr>
            <tr>
                <td style=" text-align: center !important; ">
                    <p class="heading1" style="font-size: 18px; margin-bottom: 5px; text-align: center!important;"> Connect with us</p>
                    <a style="margin-right: 10px; margin-left: 13px;" href="https://www.facebook.com/I.Luv.Holy.Quran">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 504 504" style="enable-background:new 0 0 504 504; width: 20px;" xml:space="preserve">
							<g>
                                <g>
                                    <path d="M377.6,0H126C56.8,0,0,56.8,0,126.4V378c0,69.2,56.8,126,126,126h251.6c69.6,0,126.4-56.8,126.4-126.4V126.4    C504,56.8,447.2,0,377.6,0z M319.6,252H272v156h-60V252h-32v-64h28v-27.2c0-25.6,12.8-66,66.8-66H324V148h-34.8    c-5.6,0-13.2,3.6-13.2,16v24h49.2L319.6,252z"/>
                                </g>
                            </g>
						</svg>
                    </a>
                    <a style="margin-right: 10px;" href="https://twitter.com/alquranclasses">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 504.4 504.4" style="enable-background:new 0 0 504.4 504.4; width: 20px;" xml:space="preserve">
							<g>
                                <g>
                                    <path d="M377.6,0.2H126.4C56.8,0.2,0,57,0,126.6v251.6c0,69.2,56.8,126,126.4,126H378c69.6,0,126.4-56.8,126.4-126.4V126.6    C504,57,447.2,0.2,377.6,0.2z M377.2,189c0,2.8,0,5.6,0,8.4c0,84-64.8,180.8-183.6,180.8c-36.4,0-70.4-10.4-98.8-28.4    c5.2,0.4,10,0.8,15.2,0.8c30.4,0,58-10,80-27.2c-28.4-0.4-52-18.8-60.4-44c4,0.8,8,1.2,12,1.2c6,0,12-0.8,17.2-2.4    c-28.8-6-50.8-31.6-50.8-62.4V215c8,4.8,18.4,7.6,28.8,8c-17.2-11.2-28.8-30.8-28.8-52.8c0-11.6,3.2-22.4,8.8-32    c32,38.4,79.2,63.6,132.8,66.4c-1.2-4.8-1.6-9.6-1.6-14.4c0-35.2,28.8-63.6,64.4-63.6c18.4,0,35.2,7.6,47.2,20    c14.8-2.8,28.4-8,40.8-15.6c-4.8,14.8-15.2,27.2-28.4,35.2c13.2-1.6,25.6-4.8,37.2-10C400.4,169,389.6,180.2,377.2,189z"/>
                                </g>
                            </g>
						</svg>
                    </a>
                    <a style="margin-right: 10px;" href="https://www.linkedin.com/company/alquranclasses">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 504.4 504.4" style="enable-background:new 0 0 504.4 504.4; width: 20px;" xml:space="preserve">
							<g>
                                <g>
                                    <path d="M377.6,0.2H126.4C56.8,0.2,0,57,0,126.6v251.6c0,69.2,56.8,126,126.4,126H378c69.6,0,126.4-56.8,126.4-126.4V126.6    C504,57,447.2,0.2,377.6,0.2z M168,408.2H96v-208h72V408.2z M131.6,168.2c-20.4,0-36.8-16.4-36.8-36.8c0-20.4,16.4-36.8,36.8-36.8    c20.4,0,36.8,16.4,36.8,36.8C168,151.8,151.6,168.2,131.6,168.2z M408.4,408.2H408h-60V307.4c0-24.4-3.2-55.6-36.4-55.6    c-34,0-39.6,26.4-39.6,54v102.4h-60v-208h56v28h1.6c8.8-16,29.2-28.4,61.2-28.4c66,0,77.6,38,77.6,94.4V408.2z"/>
                                </g>
                            </g>
						</svg>
                    </a>
                    <!--	<a href="#">
                                      <img src="img/youtube1.png" alt="" width="30"/>
                                  </a> -->
                </td>
            </tr>
            <tr>
                <td style="padding:0 30px;">
                    <table width="100%">
                        <tr>
                            <td align="center" style=" text-align: center !important; padding:0 30px;">
                                <p class="text" style="font-size: 11px; color: dimgrey; text-align: center !important;">
                                    You’re receiving this email because you recently signed up with {{ env('APP_NAME') }}. If this wasn’t you, please disregard this email or <br/>

                                    <a class="text" style="color: #0A5CD6; font-size: 12px;  font-weight: bold;" href="{{ env('APP_URL') }}" >Let us know</a>
                                </p>
                                <p class="text" style="font-size: 11px; padding-bottom: 50px; color: dimgrey; text-align: center !important;">
                                    310 Brookside road, Richmond Hill, L4C0K8, Ontario, Canada
                                </p>
                            </td>
                        </tr>
                        @isset($actionText)
                            <tr>
                                <td class="text" style="font-size: 11px; padding-bottom: 50px; color: dimgrey; text-align: left;" >
                                    <br><hr>
                                    If you're having trouble clicking the "{!! $actionText !!}" button, copy and paste the URL below into your web browser:
                                    <a href="{{ $actionUrl }}" target="_blank" class="text" style="color: #0A5CD6; font-size: 12px;  font-weight: bold;">{!! $actionUrl !!}</a>
                                </td>
                            </tr>
                        @endisset
                        <tr>
                            <td height="20" style="background-color:#0A5CD6; "></td>
                        </tr>
                    </table>
                </td>
            </tr>


        </table>
    </div>
</div>
</body>
</html>
