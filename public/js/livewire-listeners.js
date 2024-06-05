/*CUSTOMER CONSOLE LISTNERS*/
window.addEventListener("studentAdded", (event) => {
    //alert('Name updated to: ' + event.detail.message);
});

window.addEventListener("setTimezone", (event) => {
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    $('select[name="timezone"]').val(timezone).change();
});

window.addEventListener("typeAlert", (event) => {
    var alert = event.detail;
    
    if (alert.type === "adding_student") {
        $("#trial-modal").modal("toggle");
        if (alert.status === "success") {
            $("#successModal").modal("toggle");
        }

        if (alert.result === "limit_exceeded") {
            $('button[data-id="add-student"]').hide();
            setInterval(function () {
                $("#trial-modal").modal("hide");
            }, 300);
        }
    } else if (alert.type === "assigning_teacher") {
        if (alert.status === "success") {
            $(alert.params.modal_id).modal("hide");
        }
    }
    else if (alert.type === "change-request") {
        if (alert.status === "success") {
            $(alert.params.modal_id).modal("hide");
        }
    }
    if (alert.alert) {
        Toast.fire({
            icon: event.detail.status,
            title: event.detail.message,
            timer: 1500,
        });
    }
});

Livewire.on("studentAdded", () => {
    $("#trial-modal").modal("toggle");
});

/*ASSIGN TEACHER*/

window.addEventListener("toggleModal", (event) => {
    var data = event.detail;
    console.log(data);
    $(data.id + "-form")[0].reset();
    if (data.type === "open") {
        $(data.id).modal("show");
    } else if (data.type === "close") {
        $(data.id).modal("hide");
    } else {
        $(data.id).modal("toggle");
    }
});

/*SALES SUPPORT TABS SWITCHING*/
$("#unscheduled-tab").on("click", function () {
    /*$('.full-page-loader').removeClass('d-none')*/
    $("#trials-list-body").html("");
    console.log("unscheduled");
    Livewire.emit("updateTrials", "trial_unscheduled");
    /* $('.full-page-loader').addClass('d-none')*/
});

$("#scheduled-tab").on("click", function () {
    $("#trials-list-body").html("");
    console.log("scheduled");
    Livewire.emit("updateTrials", "trial_scheduled");
});

$("#successful-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "trial_successful");
});

$("#unsuccessful-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "trial_unsuccessful");
});

$("#missed-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "trial_missed");
});

$("#rescheduled-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "trial_rescheduled");
});

$("#pending-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "pending_changes");
});

$("#progress-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "progress_changes");
});


$("#completed-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "completed_changes");
});

$("#summary-tab").on("click", function () {
    $("#trials-list-body").html("");
    Livewire.emit("updateTrials", "summary");
});


/*  Sales Support Ends */

$(".sidebar-tabs").on("click", function () {
    $("#myTab").find("a").removeClass("active");
});

$("#myTab li").on("click", function () {
    $("#unscheduled-home-tab").parent("li").addClass("active");
});

$("#unscheduled-home-tab").on("click", function () {
    $("#unscheduled-tab").click().addClass("active");
    $("#scheduled-tab").removeClass("active");
});
