/* the below function is used to disapprove a request of reschedule class */
$(".btn-decline-reschedule-class").click(function (e) {
    e.preventDefault();
    var reschedule_class_id = $(this).data("reschedulerequestid");
    var weekly_class_id = $(this).data("weeklyclassid");
    var notification_id = $(this).data("notificationid");
    var url =
        window.location.origin + "/" + window.location.pathname.split("/")[1]; // it gets domain name with locale
    url += "/DeclineRescheduleRequest";

    var formdata = new FormData();
    formdata.append("reschedule_class_id", reschedule_class_id);
    formdata.append("weekly_class_id", weekly_class_id);
    formdata.append("notification_id", notification_id);

    if (typeof $(this).data("timer") !== "undefined") {
        // it means request is being put by teacher
        formdata.append("teacher_id", $(this).data("teacherid"));
    } else if (typeof $(this).data("studentid") !== "undefined") {
        //student is doing that
        formdata.append("student_id", $(this).data("studentid"));
    }

    Ajax_Call_Dynamic(
        url,
        "POST",
        formdata,
        "DisapproveRequestSuccess",
        "FailedToasterResponse",
        "rescheule_request_actions",
        "False"
    );
});

/* the below function is used to approve a request of reschedule class */
$(".btn-accept-reschedule-class").click(function (e) {
    e.preventDefault();
    var reschedule_class_id = $(this).data("reschedulerequestid");
    var weekly_class_id = $(this).data("weeklyclassid");
    var notification_id = $(this).data("notificationid");
    var url =
        window.location.origin + "/" + window.location.pathname.split("/")[1]; // it gets domain name with locale
    url += "/ApproveRescheduleRequest";
    console.log(url);
    var formdata = new FormData();
    formdata.append("reschedule_class_id", reschedule_class_id);
    formdata.append("weekly_class_id", weekly_class_id);
    formdata.append("notification_id", notification_id);

    if (typeof $(this).data("timer") !== "undefined") {
        // it means request is being put by teacher
        formdata.append("teacher_id", $(this).data("teacherid"));
    } else if (typeof $(this).data("studentid") !== "undefined") {
        //student is doing that
        formdata.append("student_id", $(this).data("studentid"));
    }
    console.log("accepts");
    Ajax_Call_Dynamic(
        url,
        "POST",
        formdata,
        "ApproveRequestSuccess",
        "FailedToasterResponse",
        "rescheule_request_actions",
        "False"
    );
});

function ApproveRequestSuccess(response) {}

function DisapproveRequestSuccess(response) {}
