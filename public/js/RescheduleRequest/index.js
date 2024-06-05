/* the below function is used to disapprove a request of reschedule class */
$(".btn-decline-reschedule-class").click(function (e) {
    // setTimeout(() => {
        e.preventDefault();
        let counter = 4;
        const decline_btn = $(this);
        const actionRow = $(this).parent().parent();
        const rescheule_request_actions = $(this).parent().parent().parent();
        const timer = rescheule_request_actions.find(".request-timer");
        const seconds = rescheule_request_actions.find(".seconds");
        const undo = rescheule_request_actions.find(".undo-btn");
        const rejected = rescheule_request_actions.find(".request-rejected");
        const accepted = rescheule_request_actions.find(".request-accepted");
        const interval = setInterval(() => {
            if (counter > 0) {
                seconds.html(counter);
                counter--;
            } else {
                clearInterval(interval);
                sendRequest();
            }
        }, 1000);
        timer.show();
        actionRow.hide();
        rejected.show();
        undo.on("click", (e) => {
            clearInterval(interval);
            actionRow.show();
            timer.hide();
            rejected.hide();
            accepted.hide();
            seconds.html(5);
        });
        function sendRequest() {
            var reschedule_class_id = decline_btn.data("reschedulerequestid");
            var weekly_class_id = decline_btn.data("weeklyclassid");
            var notification_id = decline_btn.data("notificationid");
            var url =
                window.location.origin +
                "/" +
                window.location.pathname.split("/")[1]; // it gets domain name with locale
            url += "/DeclineRescheduleRequest";
    
            var formdata = new FormData();
            formdata.append("reschedule_class_id", reschedule_class_id);
            formdata.append("weekly_class_id", weekly_class_id);
            formdata.append("notification_id", notification_id);
    
            if (typeof decline_btn.data("teacherid") !== "undefined") {
                // it means request is being put by teacher
                formdata.append("teacher_id", decline_btn.data("teacherid"));
            } else if (typeof decline_btn.data("studentid") !== "undefined") {
                //student is doing that
                formdata.append("student_id", decline_btn.data("studentid"));
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
        }
    // }, 100);
});

/* the below function is used to approve a request of reschedule class */
$(".btn-accept-reschedule-class").click(function (e) {
    // setTimeout(() => {
        e.preventDefault();
        let counter = 4;
        const accept_btn = $(this);
        const actionRow = $(this).parent().parent();
        const rescheule_request_actions = $(this).parent().parent().parent();
        const timer = rescheule_request_actions.find(".request-timer");
        const seconds = rescheule_request_actions.find(".seconds");
        const undo = rescheule_request_actions.find(".undo-btn");
        const accepted = rescheule_request_actions.find(".request-accepted");
        const rejected = rescheule_request_actions.find(".request-rejcted");
        timer.show();
        const interval = setInterval(() => {
            if (counter > 0) {
                seconds.html(counter);
                counter--;
            } else {
                clearInterval(interval);
                sendRequest();
            }
        }, 1000);
        actionRow.hide();
        accepted.show();
        undo.on("click", (e) => {
            clearInterval(interval);
            actionRow.show();
            timer.hide();
            rejected.hide();
            accepted.hide();
            seconds.html(5);
        });
        function sendRequest() {
            var reschedule_class_id = accept_btn.data("reschedulerequestid");
            var weekly_class_id = accept_btn.data("weeklyclassid");
            var notification_id = accept_btn.data("notificationid");
            var url =
                window.location.origin +
                "/" +
                window.location.pathname.split("/")[1]; // it gets domain name with locale
            url += "/ApproveRescheduleRequest";
            var formdata = new FormData();
            formdata.append("reschedule_class_id", reschedule_class_id);
            formdata.append("weekly_class_id", weekly_class_id);
            formdata.append("notification_id", notification_id);
    
            if (typeof accept_btn.data("teacherid") !== "undefined") {
                // it means request is being put by teacher
                formdata.append("teacher_id", accept_btn.data("teacherid"));
            } else if (typeof accept_btn.data("studentid") !== "undefined") {
                //student is doing that
                formdata.append("student_id", accept_btn.data("studentid"));
            }
            Ajax_Call_Dynamic(
                url,
                "POST",
                formdata,
                "ApproveRequestSuccess",
                "FailedToasterResponse",
                "rescheule_request_actions",
                "False"
            );
        }
    // }, 100);

});

function ApproveRequestSuccess(response) {
    let div = $("#" + response.response + " div:first-child");
    $("#" + response.response + " div:not(:first-child)").remove();
    let html = div.html();
    html = html.split("waiting");
    html = html[0].replace(' has requested', '\'s request');
    console.log('html', html);
    let html_2 = `<div class="pb-2">${html} approved by you</div><div class="text-muted">Just now</div>`;
    div.html(html_2);
}

function DisapproveRequestSuccess(response) {
    let div = $("#" + response.response + " div:first-child");
    $("#" + response.response + " div:not(:first-child)").remove();
    let html = div.html();
    html = html.split("waiting");
    html = html[0].replace(' has requested', '\'s request');
    let html_2 = `<div class="pb-2">${html} rejected by you</div><div class="text-muted">Just now</div>`;
    div.html(html_2);
}
