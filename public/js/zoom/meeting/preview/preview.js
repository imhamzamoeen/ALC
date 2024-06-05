import state from "/js/zoom/meeting/session/simple-state.js";
import joinSession from "/js/zoom/meeting/session-joiner.js";
import {
    switchLoadingToSessionView,
    switchPreviewToLoadingView,
} from "/js/zoom/meeting/simple-view-switcher.js";
import { PREVIEW_VIDEO_ELEMENT } from "/js/zoom/meeting/preview/preview-video-props.js";
import { isMobileDevice } from "/js/zoom/meeting/session/video/video-render-props.js";
import { isClassEnded } from "/js/zoom/helper-functions.js";
let isMuted = true;

const initPreviewButtons = () => {
    const zmClient = VideoSDK.createClient();
    const audioTrack = VideoSDK.createLocalAudioTrack();
    const videoTrack = VideoSDK.createLocalVideoTrack();

    const initPreviewAudioButtonClick = () => {
        const VOLUME_ANIMATION_INTERVAL_MS = 100;
        let volumeAnimation = null;
        let prevVolumeAnimationStyle = "";

        const micButton = document.getElementById("js-preview-mic-button");
        const micIcon = document.getElementById("js-preview-mic-icon");

        let isPreviewAudioConnected = false;

        let isButtonAlreadyClicked = false;

        const toggleMicButtonStyle = () => {
            micIcon.classList.toggle("fa-microphone");
            micIcon.classList.toggle("fa-microphone-slash");
            micButton.classList.toggle("meeting-control-button__off");

            if (prevVolumeAnimationStyle) {
                micIcon.classList.toggle(prevVolumeAnimationStyle);
                prevVolumeAnimationStyle = "";
            }
        };

        const animateMicVolume = () => {
            const newVolume = audioTrack.getCurrentVolume();
            console.log("volume:", newVolume);
            let newVolumeAnimationStyle = "";

            if (newVolume === 0) {
                newVolumeAnimationStyle = "";
            } else if (newVolume <= 0.1) {
                newVolumeAnimationStyle = "mic-feedback__very-low";
            } else if (newVolume <= 0.2) {
                newVolumeAnimationStyle = "mic-feedback__low";
            } else if (newVolume <= 0.3) {
                newVolumeAnimationStyle = "mic-feedback__very-high";
            } else if (newVolume <= 0.4) {
                newVolumeAnimationStyle = "mic-feedback__max";
            }
            // else if (newVolume <= 0.5) {
            //     newVolumeAnimationStyle = "mic-feedback__very-high";
            // } else {
            //     newVolumeAnimationStyle = "mic-feedback__max";
            // }

            if (prevVolumeAnimationStyle !== "") {
                micIcon.classList.toggle(prevVolumeAnimationStyle);
            }

            if (newVolumeAnimationStyle !== "") {
                micIcon.classList.toggle(newVolumeAnimationStyle);
            }
            prevVolumeAnimationStyle = newVolumeAnimationStyle;
        };

        const startVolumeAnimation = () => {
            if (!volumeAnimation) {
                volumeAnimation = setInterval(
                    animateMicVolume,
                    VOLUME_ANIMATION_INTERVAL_MS
                );
            }
        };

        const endVolumeAnimation = () => {
            if (volumeAnimation) {
                clearInterval(volumeAnimation);
                volumeAnimation = null;
            }
        };

        const toggleMuteUnmute = () => {
            if (isMuted) {
                audioTrack.mute();
                endVolumeAnimation();
            } else {
                audioTrack.unmute();
                startVolumeAnimation();
            }
        };

        const onClick = async (event) => {
            event.preventDefault();
            if (!isButtonAlreadyClicked) {
                // Blocks logic from executing again if already in progress
                isButtonAlreadyClicked = true;

                try {
                    if (!isPreviewAudioConnected) {
                        await audioTrack.start();
                        isPreviewAudioConnected = true;
                    }
                    isMuted = !isMuted;
                    toggleMuteUnmute();
                    toggleMicButtonStyle();
                } catch (e) {
                    console.error("Error toggling mute", e);
                }
                state.isMicOn = !isMuted;
                isButtonAlreadyClicked = false;
            } else {
                console.log("=== WARNING: already toggling mic ===");
            }
        };

        micButton.addEventListener("click", onClick);
    };

    const initVideoPreviewButtonClick = () => {
        const webcamButton = document.getElementById(
            "js-preview-webcam-button"
        );
        const webcamIcon = document.getElementById("js-preview-webcam-icon");

        let isWebcamOn = false;
        let isButtonAlreadyClicked = false;

        const toggleWebcamButtonStyle = () => {
            webcamButton.classList.toggle("meeting-control-button__off");
            webcamIcon.classList.toggle("fa-video");
            webcamIcon.classList.toggle("fa-video-slash");
        };
        const togglePreviewVideo = async () =>
            isWebcamOn
                ? videoTrack.start(PREVIEW_VIDEO_ELEMENT)
                : videoTrack.stop();

        const onClick = async (event) => {
            event.preventDefault();
            if (!isButtonAlreadyClicked) {
                // Blocks logic from executing again if already in progress
                isButtonAlreadyClicked = true;

                try {
                    isWebcamOn = !isWebcamOn;
                    await togglePreviewVideo();
                    toggleWebcamButtonStyle();
                } catch (e) {
                    isWebcamOn = !isWebcamOn;
                    console.error("Error toggling video preview", e);
                }
                state.isWebcamOn = isWebcamOn;

                isButtonAlreadyClicked = false;
            } else {
                console.log("=== WARNING: already toggling webcam ===");
            }
        };

        webcamButton.addEventListener("click", onClick);
    };

    const initJoinButtonClick = () => {
        const joinButton = document.getElementById("js-preview-join-button");
        const config = {
            username: joinButton.dataset.username,
            password: joinButton.dataset.password,
            sessionKey: joinButton.dataset.key,
            topic: joinButton.dataset.topic,
        };
        let isButtonAlreadyClicked = false;
        const onClick = async (event) => {
            if (!isClassEnded()) {
                event.preventDefault();
                if (isMobileDevice) {
                    try {
                        var elem = document.documentElement;
                        if (elem.requestFullscreen) {
                            elem.requestFullscreen();
                        } else if (elem.webkitRequestFullscreen) {
                            /* Safari */
                            elem.webkitRequestFullscreen();
                        } else if (elem.msRequestFullscreen) {
                            /* IE11 */
                            elem.msRequestFullscreen();
                        }
                    } catch (error) {
                        console.log(error);
                    }
                }

                if (!isButtonAlreadyClicked) {
                    // Blocks logic from executing again if already in progress
                    isButtonAlreadyClicked = true;
                    try {
                        if (!isMuted) {
                            audioTrack.stop();
                        }
                        switchPreviewToLoadingView();
                        await joinSession(zmClient, config);
                        switchLoadingToSessionView();
                    } catch (e) {
                        console.error("Error joining session", e);
                    }

                    isButtonAlreadyClicked = false;
                } else {
                    console.log("=== WARNING: already toggling webcam ===");
                }
            }
        };

        joinButton.addEventListener("click", onClick);
    };

    initPreviewAudioButtonClick();
    initVideoPreviewButtonClick();
    initJoinButtonClick();
};

export default initPreviewButtons;
