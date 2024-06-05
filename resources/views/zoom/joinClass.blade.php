<!DOCTYPE html>

<head>
    <title>Join Class</title>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    {{-- <meta http-equiv="origin-trial"
        content="ApbyCprSSGVaT3D3B6PtIv+n/9OBJNNvn90FOjL7bJcSHnPiF3EWtIu0cucMH4cSEaJfG+5/wMev1YBGHQNkHw0AAABLeyJvcmlnaW4iOiJodHRwczovLzAuMC4wLjA6MzAwMCIsImZlYXR1cmUiOiJXZWJDb2RlY3MiLCJleHBpcnkiOjE2MjYyMjA3OTl9"> --}}
    <!-- The link below is for the mic and camera icons in this trial -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/zoom.css') }}" />
</head>
<style>
    html,
    body {
        height: unset;
        display: unset;
        display: unset;
        margin: unset;
        background-color: #e5e3e3;
    }

    #app-root {
        width: calc(100vw - 25px);
        height: 100vh;
        margin: 0 auto;
    }

    #app-root #js-preview-join-button {
        margin-top: 1em;
    }

    #app-root #js-preview-video {
        width: 80vw;
        height: 40vw;
        max-width: 985px;
        max-height: 425px;
    }

    #js-video-view {
        width: 100%;
        height: 100%;
        margin-top: 10px;
    }

    #js-share-screen-button.meeting-control-button__off>svg {
        filter: invert(100)
    }

    .mic-feedback__very-low {
        background: linear-gradient(0deg, white 5%, black 5%);
    }

    .mic-feedback__low {
        background: linear-gradient(0deg, white 35%, black 35%);
    }

    .mic-feedback__medium {
        background: linear-gradient(0deg, white 50%, black 50%);
    }

    .mic-feedback__high {
        background: linear-gradient(0deg, white 65%, black 65%);
    }

    .mic-feedback__very-high {
        background: linear-gradient(0deg, white 80%, black 80%);
    }

    .mic-feedback__max {
        background: linear-gradient(0deg, white 100%, black 100%);
    }

    #video-container {
        display: flex;
        flex-direction: row;
    }

    #video-element {
        width: 50%;
        height: 40vw;
        max-height: 90vh;
        border-radius: 15px;
        background-color: black;
        display: none;
    }

    #video-off {
        width: 50%;
        height: 40vw;
        max-height: 90vh;
        border-radius: 15px;
        background-color: black;
        color: white;
        justify-content: center;
        align-items: center;
        display: none;
    }

    .active-screen {
        display: flex !important;
    }

    #video-canvas,
    #screen-canvas {
        width: 50%;
        height: 40vw;
        max-height: 90vh;
        display: none;
    }

    #video-canvas.show-full-canvas,
    #screen-canvas.show-full-canvas {
        width: 100% !important;
        height: 60vw;
        display: block !important;
    }

    #video-canvas.show-half-canvas,
    #screen-canvas.show-half-canvas {
        display: block !important;
    }

    #video-canvas.show-small-canvas {
        width: 25% !important;
        display: block !important;
        position: absolute;
        height: 15vw;
        bottom: 10vh;
        right: 0vh;
    }

    #screen-canvas.show-full-canvas {
        width: 100% !important;
        display: block !important;
    }

    #js-video-view {
        position: relative;
    }

    #self-name,
    #participant-name {
        font-family: Poppins, sans-serif;
        font-size: 26px;
        font-weight: 600;
        color: white;
        position: absolute;
    }

    #self-name {
        top: 50%;
        left: 25%;
        transform: translate(-50%, -50%);
    }

    #participant-name {
        top: 50%;
        left: 75%;
        transform: translate(-50%, -50%);
    }

    #participant-name.left {
        left: 25% !important;
    }

    #controls-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    #js-video-view .meeting-control-layer {
        bottom: 20px;
    }

    #app-root .meeting-control-button__off {
        background-color: green;
    }

    .meeting-control-button {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .class-ended-alert {
        background-color: #dbd6d6;
    }

    .class-ended-alert .swal2-title {
        color: black;
    }

    #js-end-view {
        flex-direction: column;
    }

    #js-end-view button {
        background-color: #0A5CD6 !important;
        margin: .3125em;
        padding: .625em 1.1em;
        transition: box-shadow .1s;
        box-shadow: 0 0 0 3px transparent;
        font-weight: 500;
        border: 0;
        border-radius: .25em;
        background: initial;
        color: #fff;
        font-size: 1em;
        cursor: pointer;
    }

    .join-button.disabled {
        background-color: gray;
    }

    @media screen and (max-width: 575px) and (orientation:portrait) {
        #app-root {
            height: 100vw !important;
            width: unset !important;
            transform: rotate(90deg);
        }

        #video-container {
            width: 100vh;
        }

        #video-canvas,
        #screen-canvas {
            height: 45vh !important;
        }

        #video-element {
            display: none !important;
        }

        #app-root #js-preview-view,
        #js-end-view,
        #js-loading-view,
        #js-waiting-view {
            margin-left: 45vh;
        }

        #app-root #js-preview-video {
            width: 60vh !important;
            height: 25vh !important;
        }

        #js-preview-view .meeting-control-layer {
            bottom: 90px;
        }

        #js-video-view .meeting-control-layer {
            bottom: 10px;
            left: 65%;
        }

        #js-waiting-view h1 {
            width: 200px;
            margin-left: 5%;

        }

        #js-end-view {
            align-items: start;
        }

        #js-loading-view h1 {
            width: 465px;
            margin-left: 0;
        }

        #js-end-view h1 {
            width: 600px;
            margin-left: 5%;

        }

        #js-end-view button {
            margin-left: 13vh;
        }

        #js-webcam-button,
        #js-share-screen-button,
        #js-preview-webcam-button {
            display: none;
        }

        #self-name,
        #participant-name {
            font-size: 22px;
        }

        #js-video-view .meeting-control-layer {
            left: 82%;
        }

        #self-name {
            left: 40%;
        }

        #participant-name {
            left: 150%;
            display: block;
            width: 175px;
        }

        #self-name.hidden,
        #participant-name.hidden {
            display: none;
        }
    }

    @media screen and (max-height:450px) and (orientation: landscape) {

        #js-webcam-button,
        #js-share-screen-button,
        #js-preview-webcam-button {
            display: none;
        }

        #app-root #js-preview-video {
            width: 70vw;
            height: 28vw;
        }

        #js-video-view .meeting-control-layer {
            bottom: 0px;
        }

        #self-name,
        #participant-name {
            font-size: 22px;
        }

        #self-name.hidden,
        #participant-name.hidden {
            display: none;
        }
    }
</style>

<body>
    <div id="app-root" class="container app-root">
        {{-- Please Wait --}}
        <div id="js-waiting-view" class="container loading-view">
            <h1>Please wait !</h1>
            <i class="fas fa-spinner loading-spinner"></i>
        </div>
        <!-- Preview view -->
        <div id="js-preview-view" class="container preview__root hidden">
            <span>
                <h1>Join Class</h1>
            </span>
            <div class="container video-app">
                <!-- You can use any height or width you wish for the preview -->
                <video id="js-preview-video" class="preview-video" playsinline="" muted="" data-video="0"></video>
                <div class="container meeting-control-layer">
                    <!-- "fas" and "fa" are icon prefixes for the font-awesome library -->
                    <button id="js-preview-mic-button" class="meeting-control-button">
                        <i id="js-preview-mic-icon" class="fas fa-microphone-slash"></i>
                    </button>
                    <button id="js-preview-webcam-button" class="meeting-control-button">
                        <i id="js-preview-webcam-icon" class="fas fa-video-slash webcam__off"></i>
                    </button>
                </div>
            </div>
            <button id="js-preview-join-button" data-topic="{{ $WeeklyClass->session_key }}"
                data-username="{{ $model->reg_no }}"
                data-time="{{ \Carbon\Carbon::parse($WeeklyClass->class_time)->format('Y-m-d H:i:s') }}"
                data-password="secret" data-key="{{ $WeeklyClass->session_key }}" class="join-button">
                Join
            </button>
            {{-- <button id="js-preview-join-button" data-topic="{{ $WeeklyClass->session_key }}"
                data-username="{{ $model->reg_no }}" data-time="2022-09-13 12:00:00" data-password="secret"
                data-key="{{ $WeeklyClass->session_key }}" class="join-button">
                Join
            </button> --}}
        </div>
        <!-- Loading view -->
        <div id="js-loading-view" class="container loading-view hidden">
            <h1>Joining Class, Please wait !</h1>
            <i class="fas fa-spinner loading-spinner"></i>
        </div>
        <!-- In-session view -->
        {{-- <div id="video-container"> --}}
        <div id="js-video-view" class="video-app hidden">
            <div id="video-container">
                <canvas id="video-canvas" class="video-canvas" width="1280" height="640"></canvas>
                <canvas id="screen-canvas" class="video-canvas" width="1280" height="640"></canvas>
                <video id="video-element"></video>
                <div id="video-off">Your Video is turned off</div>
            </div>
            <span id="self-name">{{ $model->reg_no }}</span>
            <span id="participant-name">No Participant</span>
            <div id="controls-container">
                <div class="container meeting-control-layer">
                    <!-- "fas" and "fa" are icon prefixes for the font-awesome library -->
                    <button id="js-mic-button" class="meeting-control-button">
                        <i id="js-mic-icon" class="fas fa-microphone-slash"></i>
                    </button>
                    <button id="js-webcam-button" class="meeting-control-button">
                        <i id="js-webcam-icon" class="fas fa-video-slash webcam__off"></i>
                    </button>
                    <button id="js-share-screen-button" class="meeting-control-button">
                        <svg width="35px" height="35px" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="2 -2 25 28" style="margin-bottom:7px">
                            <g id="🔍-System-Icons" stroke="black" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="ic_fluent_share_screen_28_regular" fill="#212121" fill-rule="nonzero">
                                    <path
                                        d="M23.75,4.99939 C24.9926,4.99939 26,6.00675 26,7.24939 L26,20.75 C26,21.9926 24.9926,23 23.75,23 L4.25,23 C3.00736,23 2,21.9927 2,20.75 L2,7.24939 C2,6.00675 3.00736,4.99939 4.25,4.99939 L23.75,4.99939 Z M23.75,6.49939 L4.25,6.49939 C3.83579,6.49939 3.5,6.83518 3.5,7.24939 L3.5,20.75 C3.5,21.1642 3.83579,21.5 4.25,21.5 L23.75,21.5 C24.1642,21.5 24.5,21.1642 24.5,20.75 L24.5,7.24939 C24.5,6.83518 24.1642,6.49939 23.75,6.49939 Z M13.9975,8.62102995 C14.1965,8.62102995 14.3874,8.69998 14.5281,8.8407 L17.7826,12.0952 C18.0755,12.3881 18.0755,12.863 17.7826,13.1559 C17.4897,13.4488 17.0148,13.4488 16.7219,13.1559 L14.7477,11.1817 L14.7477,18.6284 C14.7477,19.0426 14.412,19.3784 13.9977,19.3784 C13.5835,19.3784 13.2477,19.0426 13.2477,18.6284 L13.2477,11.1835 L11.2784,13.1555 C10.9858,13.4486 10.5109,13.4489 10.2178,13.1562 C9.92469,12.8636 9.92436,12.3887 10.217,12.0956 L13.467,8.84107 C13.6077,8.70025 13.7985,8.62102995 13.9975,8.62102995 Z"
                                        id="🎨-Color"></path>
                                </g>
                            </g>
                        </svg>
                    </button>
                    <div class="vertical-divider"></div>
                    <button id="js-leave-button" class="meeting-control-button meeting-control-button__leave-session">
                        <i id="js-leave-session-icon" class="fas fa-phone"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- </div> --}}

        <!-- Ending view -->
        <div id="js-end-view" class="container ending-view hidden">
            <h1>You have left the Class!</h1>
            <button onclick="goBackToHomepage()">Go back to Homepage</button>

        </div>
    </div>
</body>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/zoom/index.js') }}" type="module" defer></script>
<script src="{{ asset('js/sweetAlert2.min.js') }}"></script>
<script>
    window.Swal = Swal;

    function goBackToHomepage() {
        location.replace("https://" + location.hostname);
    }
</script>

</html>
