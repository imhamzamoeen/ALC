export function isClassEnded() {
    console.log("helper function running");
    let joinButton = document.getElementById("js-preview-join-button");
    let classTime = joinButton.getAttribute("data-time") + " UTC";
    let UTCTime = new Date(classTime);
    let endTime = new Date(UTCTime.setMinutes(UTCTime.getMinutes() + 30));
    let currentTime = new Date();
    if (currentTime.getTime() > endTime.getTime()) {
        console.log("class is ended");
        joinButton.classList.add("disabled");
        swal.fire({
            title: "Class has ended",
            text: "You can go back to the homepage",
            icon: "info",
            showCancelButton: false,
            confirmButtonColor: "#0A5CD6",
            confirmButtonText: "Go back to homepage!",
            customClass: "class-ended-alert",
        }).then((result) => {
            if (result.isConfirmed) {
                location.replace("https://" + location.hostname);
            }
        });
        return true;
    }
    return false;
}
