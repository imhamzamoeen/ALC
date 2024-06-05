export const VIDEO_QUALITY_90P = 0;
export const VIDEO_QUALITY_180P = 1;
export const VIDEO_QUALITY_360P = 2;
export const VIDEO_QUALITY_720P = 3; // not supported * yet *

export const USER_NAME = document.getElementById("self-name");
export const PARTICIPANT_NAME = document.getElementById("participant-name");

export const VIDEO_CANVAS = document.getElementById("video-canvas");
export const VIDEO_ELEMENT = document.getElementById("video-element");
export const VIDEO_OFF = document.getElementById("video-off");
export const SCREEN_CANVAS = document.getElementById("screen-canvas");

export const VIDEO_CANVAS_DIMS = {
    Width: 1280,
    Height: 640,
};

function isMobile() {
    console.log("is mobile");
    let w = window.innerWidth;
    let h = window.innerHeight;
    if ((w < 450 && h < 900) || (w < 900 && h < 450)) return true;
    else return false;
}

export const isMobileDevice = isMobile();
