import { switchSessionToEndingView } from "/js/zoom/meeting/simple-view-switcher.js";
import {
    toggleSelfVideo,
    toggleParticipantVideo,
    toggleShareScreen,
    toggleParticipantScreen,
} from "/js/zoom/meeting/session/video/video-toggler.js";
import state from "/js/zoom/meeting/session/simple-state.js";
import { isMobileDevice } from "/js/zoom/meeting/session/video/video-render-props.js";
/**
 * Initializes the mic and webcam toggle buttons
 *
 * @param {VideoClient} zoomClient
 * @param {Stream} mediaStream
 */
const initButtonClickHandlers = async (zoomClient, mediaStream, userType) => {
    const initMicClick = () => {
        const micButton = document.getElementById("js-mic-button");
        const micIcon = document.getElementById("js-mic-icon");

        let isMuted = true;
        let isButtonAlreadyClicked = false;

        const toggleMicButtonStyle = () => {
            micIcon.classList.toggle("fa-microphone");
            micIcon.classList.toggle("fa-microphone-slash");
            micButton.classList.toggle("meeting-control-button__off");
        };

        const toggleMuteUnmute = async () => {
            return new Promise(async (resolve, reject) => {
                // if (!isMuted) {
                //     if (!state.audioStarted && state.audioReady) {
                //         console.log("starting audio");
                //         await mediaStream.startAudio();
                //         await mediaStream.unmuteAudio();
                //         state.audioStarted = true;
                //     } else if (state.audioReady) {
                //         console.log("un muting audio");
                //         await mediaStream.unmuteAudio();
                //     } else {
                //         reject("audio not ready yet");
                //     }
                // } else {
                //     if (state.audioStarted) {
                //         console.log("muting audio");
                //         await mediaStream.muteAudio();
                //     }
                // }
                try {
                    if (!isMuted) {
                        console.log("un muting audio");
                        await mediaStream.unmuteAudio();
                    } else {
                        console.log("muting audio");
                        await mediaStream.muteAudio();
                    }
                    console.log("toggle Mute Audio");
                    state.isMuted = isMuted;
                    resolve("mic toggled");
                } catch (error) {
                    reject("error toggling mic");
                }
            });
        };
        const isMutedSanityCheck = () => {
            const mediaStreamIsMuted = mediaStream.isAudioMuted();
            console.log("Sanity check: is muted? ", mediaStreamIsMuted);
            console.log(
                "Does this match button state? ",
                mediaStreamIsMuted === isMuted
            );
        };

        const onClick = async (event) => {
            event.preventDefault();
            if (!isButtonAlreadyClicked && state.audioStarted) {
                // Blocks logic from executing again if already in progress
                isButtonAlreadyClicked = true;

                try {
                    isMuted = !isMuted;
                    await toggleMuteUnmute();
                    toggleMicButtonStyle();
                    isMutedSanityCheck();
                } catch (e) {
                    console.log("Error toggling mute", e);
                }

                isButtonAlreadyClicked = false;
            } else {
                console.log(
                    "=== WARNING: already toggling mic or audio not started==="
                );
            }
        };

        micButton.addEventListener("click", onClick);
    };

    // Once webcam is started, the client will receive an event notifying that a video has started
    // At that point, video should be rendered. The reverse is true for stopping video
    const initWebcamClick = () => {
        const webcamButton = document.getElementById("js-webcam-button");
        const webcamIcon = document.getElementById("js-webcam-icon");
        let isWebcamOn = false;
        let isButtonAlreadyClicked = false;

        const toggleWebcamButtonStyle = () => {
            webcamButton.classList.toggle("meeting-control-button__off");
            webcamIcon.classList.toggle("fa-video");
            webcamIcon.classList.toggle("fa-video-slash");
        };

        const onClick = async (event) => {
            event.preventDefault();
            if (!isButtonAlreadyClicked) {
                // Blocks logic from executing again if already in progress
                isButtonAlreadyClicked = true;

                try {
                    isWebcamOn = !isWebcamOn;
                    await toggleSelfVideo(mediaStream, isWebcamOn);
                    toggleWebcamButtonStyle();
                } catch (e) {
                    isWebcamOn = !isWebcamOn;
                    console.log("Error toggling video", e);
                }

                isButtonAlreadyClicked = false;
            } else {
                console.log("=== WARNING: already toggling webcam ===");
            }
        };

        webcamButton.addEventListener("click", onClick);
    };

    const initShareScreenClick = () => {
        const shareScreenButton = document.getElementById(
            "js-share-screen-button"
        );
        let isShareScreenOn = false;
        let isButtonAlreadyClicked = false;

        const toggleShareButtonStyle = () => {
            shareScreenButton.classList.toggle("meeting-control-button__off");
        };

        const onClick = async (event) => {
            event.preventDefault();
            if (!isButtonAlreadyClicked) {
                // Blocks logic from executing again if already in progress
                isButtonAlreadyClicked = true;

                try {
                    isShareScreenOn = !isShareScreenOn;
                    console.log("share screen clicked: ", isShareScreenOn);
                    await toggleShareScreen(mediaStream, isShareScreenOn);
                    toggleShareButtonStyle();
                } catch (e) {
                    isShareScreenOn = !isShareScreenOn;
                    console.log("Error toggling screen share", e);
                }

                isButtonAlreadyClicked = false;
            } else {
                console.log("=== WARNING: already toggling share screen ===");
            }
        };

        shareScreenButton.addEventListener("click", onClick);
    };

    const initLeaveSessionClick = () => {
        const leaveButton = document.getElementById("js-leave-button");

        const onClick = async (event) => {
            event.preventDefault();

            if (isMobileDevice) {
                try {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        /* Safari */
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        /* IE11 */
                        document.msExitFullscreen();
                    }
                } catch (error) {
                    console.log(error);
                }
            }
            try {
                try {
                    console.log("is Mobile Device: ", state.isMobileDevice);

                    if (state.isMobileDevice) {
                        await Promise.all([
                            toggleParticipantScreen(mediaStream, false),
                            toggleParticipantVideo(mediaStream, false),
                        ]);
                    } else {
                        await Promise.all([
                            toggleSelfVideo(mediaStream, false),
                            toggleParticipantVideo(mediaStream, false),
                            toggleShareScreen(mediaStream, false),
                            toggleParticipantScreen(mediaStream, false),
                        ]);
                    }
                } catch (e) {
                    console.log("Error toggling video or screen", e);
                }
                await zoomClient.leave();
                switchSessionToEndingView();
            } catch (error) {
                console.log("Error leaving session", e);
            }
        };

        leaveButton.addEventListener("click", onClick);
    };

    // const initOnStopScreenShare = () => {
    //     mediaStream.getVideoTracks()[0].onended = function () {
    //         document.getElementById("js-share-screen-share").click();
    //     };
    // };
    initMicClick();
    initLeaveSessionClick();
    if ((userType !== "TCO" && userType !== "CSP") || !state.isMobileDevice) {
        initWebcamClick();
        initShareScreenClick();
        // initOnStopScreenShare();
    }
};

export default initButtonClickHandlers;
