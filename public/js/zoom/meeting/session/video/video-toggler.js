import state from "/js/zoom/meeting/session/simple-state.js";
import {
    VIDEO_ELEMENT,
    VIDEO_CANVAS,
    VIDEO_OFF,
    SCREEN_CANVAS,
    VIDEO_CANVAS_DIMS,
    VIDEO_QUALITY_360P,
    PARTICIPANT_NAME,
    USER_NAME,
    isMobileDevice,
} from "/js/zoom/meeting/session/video/video-render-props.js";

let prevIsSelfVideoOn = false;
let prevIsParticipantVideoOn = false;
let prevIsParticipantScreenOn = false;
let prevIsSelfScreenOn = false;
let preparingSelfVideo = false;
let preparingParticipantVideo = false;
let preparingParticipantScreen = false;
let preparingSelfScreen = false;
const isSharedArrayBuffer = typeof SharedArrayBuffer === "function";
const isWebcodecEnabled = typeof MediaStreamTrackProcessor === "function";

function selfVideoView() {
    if (isSharedArrayBuffer) {
        if (prevIsParticipantScreenOn) {
            SCREEN_CANVAS.classList.remove("show-full-canvas");
            SCREEN_CANVAS.classList.add("show-full-canvas");
            VIDEO_CANVAS.classList.add("show-small-canvas");
        }
    } else {
        if (prevIsParticipantScreenOn) {
            VIDEO_OFF.classList.remove("show-half-canvas");
            VIDEO_ELEMENT.classList.add("active-screen");
        }
    }
    USER_NAME.classList.add("hidden");
}

function selfVideoViewEnd() {
    if (isSharedArrayBuffer) {
        if (prevIsParticipantScreenOn) {
            SCREEN_CANVAS.classList.remove("show-full-canvas");
            VIDEO_CANVAS.classList.remove("show-small-canvas");
            SCREEN_CANVAS.classList.add("show-full-canvas");
        }
    } else {
        if (prevIsParticipantScreenOn) {
            VIDEO_ELEMENT.classList.remove("active-screen");
            VIDEO_OFF.classList.add("active-screen");
        }
    }
    USER_NAME.classList.remove("hidden");
}

function participantVideoView() {
    if (isMobileDevice) {
        USER_NAME.classList.add("hidden");
    }
    PARTICIPANT_NAME.classList.add("hidden");
}

function participantVideoViewEnd() {
    if (isMobileDevice) {
        USER_NAME.classList.remove("hidden");
    }
    PARTICIPANT_NAME.classList.remove("hidden");
}

function particpantScreenView() {
    if (isSharedArrayBuffer) {
        if (prevIsSelfScreenOn) {
            SCREEN_CANVAS.classList.add("show-half-canvas");
            VIDEO_CANVAS.classList.remove("show-half-canvas");
        } else if (prevIsSelfVideoOn) {
            VIDEO_CANVAS.classList.remove("show-full-canvas");
            SCREEN_CANVAS.classList.add("show-full-canvas");
            VIDEO_CANVAS.classList.add("show-small-canvas");
        } else {
            VIDEO_CANVAS.classList.remove("show-full-canvas");
            SCREEN_CANVAS.classList.add("show-full-canvas");
        }
    } else {
        if (prevIsSelfScreenOn) {
            SCREEN_CANVAS.classList.add("show-half-canvas");
            VIDEO_CANVAS.classList.remove("show-half-canvas");
        } else if (prevIsSelfVideoOn) {
            VIDEO_CANVAS.classList.remove("show-half-canvas");
            SCREEN_CANVAS.classList.add("show-half-canvas");
        } else {
            VIDEO_CANVAS.classList.remove("show-half-canvas");
            SCREEN_CANVAS.classList.add("show-half-canvas");
        }
    }
    USER_NAME.classList.add("hidden");
    PARTICIPANT_NAME.classList.add("hidden");
}

function participantScreenViewEnd() {
    if (isSharedArrayBuffer) {
        if (prevIsSelfScreenOn) {
            SCREEN_CANVAS.classList.remove("show-half-canvas");
            VIDEO_CANVAS.classList.add("show-half-canvas");
        } else if (prevIsSelfVideoOn) {
            VIDEO_CANVAS.classList.remove("show-small-canvas");
            SCREEN_CANVAS.classList.remove("show-full-canvas");
            VIDEO_CANVAS.classList.add("show-full-canvas");
        } else {
            SCREEN_CANVAS.classList.remove("show-full-canvas");
            VIDEO_CANVAS.classList.add("show-full-canvas");
        }
    } else {
        if (prevIsSelfScreenOn) {
            SCREEN_CANVAS.classList.remove("show-half-canvas");
            VIDEO_CANVAS.classList.add("show-half-canvas");
        } else if (prevIsSelfVideoOn) {
            VIDEO_CANVAS.classList.add("show-half-canvas");
            SCREEN_CANVAS.classList.remove("show-half-canvas");
        }
    }
    if (prevIsSelfVideoOn) {
        USER_NAME.classList.add("hidden");
        PARTICIPANT_NAME.classList.remove("hidden");
    } else {
        USER_NAME.classList.remove("hidden");
        PARTICIPANT_NAME.classList.remove("hidden");
    }
}

function selfScreenView() {
    if (isSharedArrayBuffer || isWebcodecEnabled) {
        if (prevIsParticipantScreenOn) {
            SCREEN_CANVAS.classList.remove("show-full-canvas");
            SCREEN_CANVAS.classList.add("show-half-canvas");
            VIDEO_ELEMENT.classList.add("active-screen");
        } else {
            VIDEO_CANVAS.classList.remove("show-full-canvas");
            VIDEO_CANVAS.classList.add("show-half-canvas");
            VIDEO_ELEMENT.classList.add("active-screen");
        }
    } else {
        VIDEO_OFF.classList.remove("active-screen");
        VIDEO_ELEMENT.classList.add("active-screen");
    }
    USER_NAME.classList.add("hidden");
    PARTICIPANT_NAME.classList.add("left");
}

function selfScreenViewEnd() {
    if (isSharedArrayBuffer || isWebcodecEnabled) {
        if (prevIsParticipantScreenOn) {
            SCREEN_CANVAS.classList.remove("show-half-canvas");
            VIDEO_ELEMENT.classList.remove("active-screen");
            SCREEN_CANVAS.classList.add("show-full-canvas");
        } else {
            VIDEO_CANVAS.classList.remove("show-half-canvas");
            VIDEO_ELEMENT.classList.remove("active-screen");
            VIDEO_CANVAS.classList.add("show-full-canvas");
        }
    } else {
        VIDEO_ELEMENT.classList.remove("active-screen");
        VIDEO_OFF.classList.add("active-screen");
    }
    USER_NAME.classList.remove("hidden");
    PARTICIPANT_NAME.classList.remove("left");
}

export const toggleSelfVideo = async (mediaStream, isVideoOn) => {
    async function endSelfVideo(changeView) {
        console.log("end self video");
        try {
            console.log("stopping video");
            await mediaStream.stopVideo();
            await mediaStream.stopRenderVideo(VIDEO_CANVAS, state.selfId);
            await mediaStream.clearVideoCanvas(VIDEO_CANVAS);
            console.log("video stopped");
            // if (prevIsParticipantVideoOn && isSharedArrayBuffer) {
            //     await mediaStream.stopRenderVideo(
            //         VIDEO_CANVAS,
            //         state.participantId
            //     );
            //     await mediaStream.renderVideo(
            //         VIDEO_CANVAS,
            //         state.participantId,
            //         VIDEO_CANVAS_DIMS.Width,
            //         VIDEO_CANVAS_DIMS.Height,
            //         0,
            //         0,
            //         VIDEO_QUALITY_360P
            //     );
            // }
        } catch (error) {
            console.log(error);
        }
        if (changeView) {
            console.log("change self video view");
            selfVideoViewEnd();
        }
        prevIsSelfVideoOn = false;
        return Promise.resolve();
    }
    if (isVideoOn) {
        console.log("state: " + JSON.stringify(state));
        if (typeof isVideoOn !== "boolean" || prevIsSelfVideoOn === isVideoOn) {
            console.log("ending toggle self video screen: ", prevIsSelfVideoOn);
            return;
        }
        let options = {};

        preparingSelfVideo = true;
        // if desktop Chrome or Edge (Chromium) with SharedArrayBuffer not enabled
        if (!isSharedArrayBuffer) {
            console.log("start video without share array");
            selfVideoView();
            await mediaStream.startVideo({ videoElement: VIDEO_ELEMENT });
            prevIsSelfVideoOn = true;
            preparingSelfVideo = false;
            console.log("self video ready");
        } else {
            // all other browsers and desktop Chrome or Edge (Chromium) with SharedArrayBuffer enabled
            if (prevIsSelfScreenOn) {
                await toggleShareScreen(mediaStream, false);
                document.getElementById("js-share-screen-button").click();
            }
            console.log("start self video ");
            // if (prevIsParticipantVideoOn) {
            //     console.log(
            //         "is participant video on: ",
            //         prevIsParticipantVideoOn
            //     );
            //     options.Width = VIDEO_CANVAS_DIMS.Width / 2;
            //     options.Height = VIDEO_CANVAS_DIMS.Height;
            //     options.X = VIDEO_CANVAS_DIMS.Width / 2;
            //     options.Y = 0;
            //     try {
            //         await mediaStream.stopRenderVideo(
            //             VIDEO_CANVAS,
            //             state.participantId
            //         );
            //         await mediaStream.renderVideo(
            //             VIDEO_CANVAS,
            //             state.participantId,
            //             VIDEO_CANVAS_DIMS.Width / 2,
            //             VIDEO_CANVAS_DIMS.Height,
            //             0,
            //             0,
            //             options.videoQuality
            //         );
            //     } catch (error) {
            //         console.log(error);
            //     }
            // } else {
            options.Width = VIDEO_CANVAS_DIMS.Width / 2;
            options.Height = VIDEO_CANVAS_DIMS.Height;
            options.X = 0;
            options.Y = 0;
            // }
            options.videoQuality = VIDEO_QUALITY_360P;
            try {
                await mediaStream.startVideo();
                await mediaStream.renderVideo(
                    VIDEO_CANVAS,
                    state.selfId,
                    options.Width,
                    options.Height,
                    options.X,
                    options.Y,
                    options.videoQuality
                );
                selfVideoView();
                prevIsSelfVideoOn = true;
                preparingSelfVideo = false;
            } catch (error) {
                console.log(error);
                if (error.reason === "camera is closed") {
                    await toggleSelfVideo(mediaStream, true);
                }
            }
            console.log("self video ready");
        }
    } else {
        await endSelfVideo(!preparingSelfVideo);
    }
    console.log("prevIsSelfVideoOn", prevIsSelfVideoOn);
    return Promise.resolve();
};

export const toggleParticipantVideo = async (mediaStream, isVideoOn) => {
    async function endParticipantVideo(changeView) {
        console.log("end participant video");
        try {
            await mediaStream.stopRenderVideo(
                VIDEO_CANVAS,
                state.participantId
            );
            // if (prevIsSelfVideoOn && isSharedArrayBuffer) {
            //     await mediaStream.stopRenderVideo(VIDEO_CANVAS, state.selfId);
            //     await mediaStream.renderVideo(
            //         VIDEO_CANVAS,
            //         state.selfId,
            //         VIDEO_CANVAS_DIMS.Width,
            //         VIDEO_CANVAS_DIMS.Height,
            //         0,
            //         0,
            //         VIDEO_QUALITY_360P
            //     );
            // }
        } catch (error) {
            console.log(error);
        }
        if (changeView) {
            participantVideoViewEnd();
        }
        await mediaStream.clearVideoCanvas(VIDEO_CANVAS);
        prevIsParticipantVideoOn = false;
    }
    if (isVideoOn) {
        console.log("toggle participant");
        if (
            typeof isVideoOn !== "boolean" ||
            prevIsParticipantVideoOn === isVideoOn
        ) {
            console.log(
                "ending participant video function: ",
                prevIsParticipantVideoOn
            );
            return;
        }
        let options = {};
        try {
            preparingParticipantVideo = true;
            console.log("start participant video");
            // if (prevIsSelfVideoOn) {
            //     options.Width = VIDEO_CANVAS_DIMS.Width / 2;
            //     options.Height = VIDEO_CANVAS_DIMS.Height;
            //     options.X = 0;
            //     options.Y = 0;
            //     try {
            //         await mediaStream.stopRenderVideo(
            //             VIDEO_CANVAS,
            //             state.selfId
            //         );
            //         await mediaStream.renderVideo(
            //             VIDEO_CANVAS,
            //             state.selfId,
            //             VIDEO_CANVAS_DIMS.Width / 2,
            //             VIDEO_CANVAS_DIMS.Height,
            //             VIDEO_CANVAS_DIMS.Width / 2,
            //             0,
            //             options.videoQuality
            //         );
            //     } catch (error) {
            //         console.log(error);
            //     }
            // } else {
            options.Width = VIDEO_CANVAS_DIMS.Width / 2;
            options.Height = VIDEO_CANVAS_DIMS.Height;
            options.X = VIDEO_CANVAS_DIMS.Width / 2;
            options.Y = 0;
            // }
            options.videoQuality = VIDEO_QUALITY_360P;
            console.log("options: " + JSON.stringify(options));
            if (isMobileDevice) {
                await mediaStream.renderVideo(
                    VIDEO_CANVAS,
                    state.participantId,
                    options.Width * 2,
                    options.Height,
                    0,
                    0,
                    options.videoQuality
                );
            } else {
                await mediaStream.renderVideo(
                    VIDEO_CANVAS,
                    state.participantId,
                    options.Width,
                    options.Height,
                    options.X,
                    options.Y,
                    options.videoQuality
                );
            }

            participantVideoView();
            preparingParticipantVideo = false;
            console.log("participant video ready");
            prevIsParticipantVideoOn = true;
        } catch (error) {
            console.log(error);
            if (error.type === "OPERATION_TIMEOUT") {
                toggleParticipantVideo(mediaStream, true);
            } else {
                prevIsParticipantVideoOn = false;
            }
        }
    } else {
        endParticipantVideo(!preparingParticipantVideo);
    }
    console.log("prevIsParticipantVideoOn", prevIsParticipantVideoOn);
};

export const toggleParticipantScreen = async (mediaStream, isScreenOn) => {
    async function endParticipantScreen(changeView) {
        console.log("end participant screen");
        await mediaStream.stopShareView();
        if (changeView) {
            participantScreenViewEnd();
        }
        prevIsParticipantScreenOn = false;
    }
    if (isScreenOn) {
        console.log("toggle participant screen: ", isScreenOn);
        if (
            typeof isScreenOn !== "boolean" ||
            prevIsParticipantScreenOn === isScreenOn
        ) {
            console.log("ending toggle participant screen function");
            return;
        }

        try {
            // document.getElementById("js-webcam-button").click();
            preparingParticipantScreen = true;
            console.log("start participant screen");
            if (prevIsSelfScreenOn) {
                await toggleShareScreen(mediaStream, false);
                document.getElementById("js-share-screen-button").click();
            }
            if (prevIsSelfVideoOn) {
                console.log("self video is on");
                document.getElementById("js-webcam-button").click();
                await toggleSelfVideo(mediaStream, false);
            }
            try {
                await mediaStream.startShareView(
                    SCREEN_CANVAS,
                    state.participantId
                );
                particpantScreenView();
                prevIsParticipantScreenOn = true;
                preparingParticipantScreen = false;
                console.log("participant screen ready");
            } catch (error) {
                console.log(error);
            }
        } catch (error) {
            console.log(error);
            if (error.type === "OPERATION_TIMEOUT") {
                toggleParticipantScreen(mediaStream, true);
            } else {
                prevIsParticipantScreenOn = false;
            }
        }
    } else {
        endParticipantScreen(!preparingParticipantScreen);
    }
    console.log("prevIsParticipantScreenOn", prevIsParticipantScreenOn);
};

export const toggleShareScreen = async (mediaStream, isScreenOn) => {
    async function endSelfScreen(changeView) {
        console.log("stop screen share");
        await mediaStream.stopShareScreen();
        if (changeView) {
            selfScreenViewEnd();
        }
        prevIsSelfScreenOn = false;
        return Promise.resolve();
    }
    if (isScreenOn) {
        if (
            typeof isScreenOn !== "boolean" ||
            prevIsSelfScreenOn === isScreenOn
        ) {
            console.log(
                "ending toggle selfShareScreen function: ",
                prevIsSelfScreenOn
            );
            return;
        }
        console.log("toggle self screen: ", isScreenOn);
        preparingSelfScreen = true;
        if (!isSharedArrayBuffer || isWebcodecEnabled) {
            // if desktop Chrome and Edge (Chromium)
            console.log(
                "sharing screen without shared array buffer or with web codec"
            );
            try {
                await mediaStream.startShareScreen(VIDEO_ELEMENT);
                try {
                    console.log("is audio muted: ", mediaStream.isAudioMuted());
                } catch (error) {
                    console.log(error);
                }
                if (prevIsSelfVideoOn) {
                    console.log("self video is already on");
                    document.getElementById("js-webcam-button").click();
                    await toggleSelfVideo(mediaStream, false);
                }
                selfScreenView();
                prevIsSelfScreenOn = true;
                preparingSelfScreen = false;
                console.log("self Screen ready");
            } catch (error) {
                console.log(error);
                return Promise.reject(error);
            }
        } else {
            console.log("sharing screen on non-Chromium browser");
            // all other browsers
            await mediaStream.startShareScreen(VIDEO_CANVAS);
            selfScreenView();
            console.log("self screen ready");
        }
    } else {
        await endSelfScreen(!preparingSelfScreen);
    }
    console.log("prevIsSelfScreenOn", prevIsSelfScreenOn);
    return Promise.resolve();
};
