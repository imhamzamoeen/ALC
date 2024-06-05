<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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

        a {
            text-decoration: none;
            Color: #0A5CD6;
            font-size: 16px;
        }

        .heading1 {
            font-family: 'poppins-bold', sans-serif !important;
            font-weight: 700;
            font-size: 16px;
        }

        .text {
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

        .gradient-button-4 {
            background-image: linear-gradient(to right, #00d2ff 0%, #3a7bd5 51%, #00d2ff 100%)
        }




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
        .button.active {
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

        .webkit {
            max-width: 700px;
            background-color: #ffffff;
        }

        .outer {
            margin: 0 auto;
            width: 100%;
            max-width: 700px;
            border-spacing: 0;
            font-family: sans-serif;
            /*color: #4a4a4a;*/
            background-color: #ffffff;
        }


        .three-columns {

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

        .padding {
            padding: 15px;
        }



        .three-columns .content {
            font-size: 15px;
            line-height: 20px;
        }


        @media screen and (max-width: 600px) {}

        @media screen and (max-width: 400px) {}
    </style>
</head>

<body>
    <div class="wrapper" align="center">
        <div class="webkit">
            <table class="outer" align="center">

                @if ($header)
                    @include('emails.partials.mail-header')
                @endif
                <tr>
                    <td style="box-sizing: border-box;width:100%;margin-bottom:10px;">
                        <img src="{{ asset('/images/welcome-email.png') }}" alt="welcome-email" style="width: 100%">
                        {{-- <img src="{{asset('/images/trial-schedule.png')}}" alt="notification-email style="width: 100%"> --}}
                    </td>
                </tr>
                @foreach ($paragraphs as $para)
                    @include('emails.partials.paragraph', ['details' => $para])
                @endforeach
                @if ($regards)
                    @include('emails.partials.mail-regards', ['query' => isset($query) ? $query : true])
                @endif
                @if ($footer)
                    @include('emails.partials.mail-footer', ['url' => $url ?? null])
                @endif

            </table>
        </div>
    </div>
</body>

</html>
