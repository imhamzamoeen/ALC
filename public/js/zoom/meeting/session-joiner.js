import sessionConfig from "/js/zoom//config.js";
import { generateSessionToken } from "/js/zoom/tool.js";
import {
    initClientEventListeners,
    handleParticipantChange,
} from "/js/zoom/meeting/session/client-event-listeners.js";
import initButtonClickHandlers from "/js/zoom/meeting/session/button-click-handlers.js";
import state from "/js/zoom/meeting/session/simple-state.js";
import {
    VIDEO_CANVAS,
    VIDEO_OFF,
    isMobileDevice,
} from "/js/zoom/meeting/session/video/video-render-props.js";
import {
    toggleParticipantScreen,
    toggleParticipantVideo,
} from "./session/video/video-toggler.js";

// const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
/**
 * Creates a zoom video client, and uses it to join/start a video session. It:
 *      1) Creates a zoom client
 *      2) Initializes the zoom client
 *      3) Tries to join a session, grabbing its Stream once successful
 *      4) Initializes the zosom client's important "on" event listeners
 *          - Very important, as failing to do so ASAP can miss important updates
 *      5) Joins the audio stream on mute
 */
const joinSession = async (zmClient, config) => {
    // const videoSDKLibDir = '/js/zoom/lib';
    const zmClientInitParams = {
        language: "en-US",
        // dependentAssets: `${window.location.origin}${videoSDKLibDir}`
    };

    const sessionToken = generateSessionToken(
        sessionConfig.sdkKey,
        sessionConfig.sdkSecret,
        config.topic,
        config.password,
        config.sessionKey,
        config.username
    );
    let userType = "";
    // const sessionToken = await fetch(
    //     "https://alquranclasses.test/generateToken"
    // ).then((response) => response.json());
    // console.log(sessionToken);
    let mediaStream;
    // console.log(zmClientInitParams);
    const initAndJoinSession = async () => {
        await zmClient.init(
            zmClientInitParams.language,
            zmClientInitParams.dependentAssets
        );

        try {
            await zmClient.join(
                config.topic,
                sessionToken,
                config.username,
                config.password
            );
            mediaStream = zmClient.getMediaStream();
            state.selfId = zmClient.getSessionInfo().userId;
            console.log(zmClient.getSessionInfo());
            console.log("username: " + config.username);
            userType = zmClient.getSessionInfo().userName.split("-")[1];
            console.log("usertype : ", userType);
            if (userType === "TCO" || userType === "CSP") {
                document.getElementById("js-share-screen-button").remove();
                document.getElementById("js-webcam-button").remove();
            }
            let sessionHost = zmClient.getSessionHost();
            const fullName = sessionHost.displayName.split("-");
            if (!zmClient.isHost()) {
                console.log("is participant");
                state.participantId = sessionHost.userId;

                const participantName = sessionHost.displayName;
                document.getElementById("participant-name").innerHTML =
                    participantName;
            } else {
                console.log("is host");
                mediaStream.lockShare(false);
                const getUsers = await zmClient.getAllUser();
                getUsers.forEach((user) => {
                    console.log(user);
                    const userType = fullName[1];
                    console.log(userType);
                    if (
                        (userType === "TCH" || userType === "STD") &&
                        !user.isHost
                    ) {
                        handleParticipantChange(user, "add", mediaStream);
                    }
                });
            }
            console.log("get sessoin id:", zmClient.getSessionInfo().sessionId);
            console.log(state);
        } catch (e) {
            console.log(e);
        }
    };

    const join = async () => {
        state.isMobileDevice = isMobileDevice;
        console.log("======= Initializing video session =======");
        await initAndJoinSession();
        /**
         * Note: it is STRONGLY recommended to initialize the client listeners as soon as
         * the session is initialized. Once the user joins the session, updates are sent to
         * the event listeners that help update the session's participant state.
         *
         * If you choose not to do so, you'll have to manually deal with race conditions.
         * You should be able to call "zmClient.getAllUser()" after the app has reached
         * steady state, meaning a sufficiently-long time
         */
        console.log("======= Initializing client event handlers =======");
        await initClientEventListeners(zmClient, mediaStream);
        // console.log("======= Starting audio muted =======");

        console.log("======= Initializing button click handlers =======");
        await initButtonClickHandlers(zmClient, mediaStream);
        console.log("======= Session joined =======");

        // document.getElementById("js-mic-button").click();
        if (state.isWebcamOn) {
            document.getElementById("js-webcam-button").click();
        }
        if (typeof SharedArrayBuffer === "function") {
            VIDEO_CANVAS.classList.add("show-full-canvas");
        } else {
            VIDEO_CANVAS.classList.add("show-half-canvas");
            VIDEO_OFF.classList.add("active-screen");
        }
        try {
            if ((await mediaStream.getActiveShareUserId()) !== 0) {
                toggleParticipantScreen(mediaStream, true);
            } else if ((await mediaStream.getActiveVideoId()) != state.selfId) {
                toggleParticipantVideo(mediaStream, true);
            }
        } catch (error) {
            console.log(error);
        }
    };

    await join();
    return Promise.resolve(zmClient);
};

export default joinSession;
