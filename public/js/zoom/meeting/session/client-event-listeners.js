import state from "/js/zoom/meeting/session/simple-state.js";
import {
    toggleParticipantVideo,
    toggleParticipantScreen,
} from "/js/zoom/meeting/session/video/video-toggler.js";

const PARTICIPANT_CHANGE_TYPE = {
    ADD: "add",
    REMOVE: "remove",
};

const PEER_VIDEO_STATE_CHANGE_ACTION_TYPE = {
    Start: "Start",
    Stop: "Stop",
};

export const handleParticipantChange = async (
    payloadEntry,
    addRemoveType,
    mediaStream
) => {
    console.log("handleParticipantChange: ", payloadEntry);
    const { userId, displayName } = payloadEntry;

    // For this trial, only a single participant is handled to keep things simple
    // and succinct. This can be extended into a participant array/set here
    if (userId === undefined) {
        return;
    }

    switch (addRemoveType) {
        case PARTICIPANT_CHANGE_TYPE.ADD:
            if (userId !== state.selfId && !state.hasParticipant) {
                const fullName = displayName.split("-");
                const userType = fullName[1];
                console.log(userType);
                if (userType === "TCH" || userType === "STD") {
                    state.participantId = userId;
                    const participantName = `${displayName}`;
                    document.getElementById("participant-name").innerHTML =
                        participantName;
                    console.log("new participant state: ", state);
                    try {
                        if ((await mediaStream.getActiveShareUserId()) !== 0) {
                            console.log(
                                "mediaStream.getActiveShareUserId: ",
                                await mediaStream.getActiveShareUserId()
                            );
                            toggleParticipantScreen(mediaStream, true);
                        } else if (
                            (await mediaStream.getActiveVideoId()) !=
                            state.selfId
                        ) {
                            console.log(
                                "mediaStream.getActiveVideoId: ",
                                await mediaStream.getActiveVideoId()
                            );
                            toggleParticipantVideo(mediaStream, true);
                        }
                    } catch (error) {
                        console.log(error);
                    }
                }
            } else {
                console.log("Detected new participant. Ignoring: ", userId);
                console.log("State has participant: ", state.hasParticipant);
                console.log("Participant ID: ", state.participantId);
            }
            break;
        case PARTICIPANT_CHANGE_TYPE.REMOVE:
            if (userId !== state.selfId) {
                state.resetParticipantId();
                document.getElementById("participant-name").innerHTML =
                    "No Participant";
            } else {
                console.log(
                    "Detected unknown participant leaving. Ignoring: ",
                    userId
                );
                console.log("Participant ID: ", state.participantId);
            }
            break;
        default:
            console.log("Unexpected ADD_REMOVE_TYPE");
            break;
    }
};

const onUserAddedListener = (zoomClient, mediaStream) => {
    zoomClient.on("user-added", (payload) => {
        console.log(`User added`, payload);

        payload?.forEach((payloadEntry) =>
            handleParticipantChange(
                payloadEntry,
                PARTICIPANT_CHANGE_TYPE.ADD,
                mediaStream
            )
        );
    });
};

const onUserRemovedListener = (zoomClient) => {
    zoomClient.on("user-removed", (payload) => {
        console.log(`User removed`, payload);

        payload?.forEach((payloadEntry) =>
            handleParticipantChange(
                payloadEntry,
                PARTICIPANT_CHANGE_TYPE.REMOVE
            )
        );
    });
};

const onPeerVideoStateChangedListener = (zoomClient, mediaStream) => {
    zoomClient.on("peer-video-state-change", async (payload) => {
        console.log("onPeerVideoStateChange", payload);

        const { action, userId } = payload;
        console.log("Payload: ", payload);
        if (userId !== state.participantId) {
            // state.participantId = userId;
            console.log(
                "Detected unrecognized participant ID. Ignoring: ",
                userId
            );
            return;
        }

        if (action === PEER_VIDEO_STATE_CHANGE_ACTION_TYPE.Start) {
            toggleParticipantVideo(mediaStream, true);
        } else if (action === "Stop") {
            toggleParticipantVideo(mediaStream, false);
        }
    });
};

const onPeerActiveShareChange = (zoomClient, mediaStream) => {
    console.log("active share change function initialized");
    zoomClient.on("active-share-change", (payload) => {
        console.log("onPeerActiveShareChange", payload);
        const userId = payload.userId;
        const userState = payload.state;
        console.log("payload: ", payload);
        console.log("state: ", state);
        if (state.participantId === -1) {
            state.participantId = userId;
        } else if (userId !== state.participantId) {
            console.log(
                "Detected unrecognized participant ID. Ignoring: ",
                userId
            );
            return;
        }

        if (userState === "Active") {
            toggleParticipantScreen(mediaStream, true);
        } else {
            toggleParticipantScreen(mediaStream, false);
        }
    });
};

const sharePassivelyStopped = (zoomClient) => {
    zoomClient.on("passively-stop-share", (payload) => {
        console.log("share passively stopped: ", payload);
        if (payload.reason === "StopScreenCapture") {
            document.getElementById("js-share-screen-button").click();
        }
    });
};

const onMediaSDKChange = async (zoomClient, mediaStream) => {
    zoomClient.on("media-sdk-change", async (payload) => {
        console.log("media sdk changed");
        const { action, type, result } = payload;
        if (type === "audio" && result === "success") {
            if (action === "encode") {
                state.audioEncode = true;
            } else if (action === "decode") {
                state.audioDecode = true;
            }
            if (state.audioDecode && state.audioEncode) {
                await mediaStream.startAudio({ autoStartAudioInSafari: true });
                state.audioStarted = true;
                setTimeout(async () => {
                    if (!(await mediaStream.isAudioMuted())) {
                        await mediaStream.muteAudio();
                    }
                    if (state.isMicOn) {
                        // setTimeout(() => {
                        document.getElementById("js-mic-button").click();
                        // }, 3500);
                    }
                }, 1000);

                // state.audioStarted = true;
                // state.audioReady = true;
            }
        }
    });
};

// const onShareAudioChange = async (zoomClient, mediaStream) => {
//     zoomClient.on("share-audio-change", async (payload) => {
//         console.log("share audio change running: ", payload);
//         if (payload.state === "on") {
//             try {
//                 await mediaStream.muteShareAudio();
//             } catch (error) {
//                 console.log(error);
//             }
//             if (!state.isMuted) {
//                 console.log("status is not muted");
//                 await mediaStream.unmuteAudio();
//             }
//         }
//     });
// };

export const initClientEventListeners = (zoomClient, mediaStream) => {
    onMediaSDKChange(zoomClient, mediaStream);
    onUserAddedListener(zoomClient, mediaStream);
    onUserRemovedListener(zoomClient, mediaStream);
    onPeerActiveShareChange(zoomClient, mediaStream);
    onPeerVideoStateChangedListener(zoomClient, mediaStream);
    if (!state.isMobileDevice) {
        // onShareAudioChange(zoomClient, mediaStream);
        sharePassivelyStopped(zoomClient, mediaStream);
    }
};
