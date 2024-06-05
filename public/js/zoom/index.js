import initPreviewButtons from "/js/zoom/meeting/preview/preview.js";
import { switchLoadingToPreview } from "/js/zoom/meeting/simple-view-switcher.js";
import { isClassEnded } from "/js/zoom/helper-functions.js";
const isSharedArrayBuffer = typeof SharedArrayBuffer === "function";
const isWebcodecEnabled = typeof MediaStreamTrackProcessor === "function";

window.addEventListener("DOMContentLoaded", async () => {
    // if(typeof SharedArrayBuffer === 'function') console.log('SharedArrayBuffer enabled');
    console.log("======= Initializing preview =======");
    await initPreviewButtons();
    switchLoadingToPreview();
    console.log("======= Done initializing preview =======");
    isClassEnded();
    if (isSharedArrayBuffer) {
        console.log("shared array buffer enabled");
    }
    if (isWebcodecEnabled) {
        console.log("webcodec enabled");
    }
});
