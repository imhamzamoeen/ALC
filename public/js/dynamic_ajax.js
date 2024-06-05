function Ajax_Call_Dynamic(
    url,
    method,
    formdata,
    callBackFuncSuccess,
    callBackFuncError,
    LoaderClass=null,
    LoaderOption="True"
) {
    $.ajax({
        url: url,
        method: method,
        contentType: false,
        processData: false,
        data: formdata,
        dataType: "json",
        beforeSend: function () {
            if(LoaderOption=="True"  &&  LoaderClass!=null) 
            $(LoaderClass).html(
                '<div class="overlay-loader d-flex align-items-center justify-content-center flex-column " id="loader" style="background-color: transparent;"><div class="spinner-border color-primary text-light" role="status"></div></div>'
            );
        },
        success: function (response) {
            // console.log("success");

            window[callBackFuncSuccess](response);
        },
        error: function (response) {
            // console.log("error");

            window[callBackFuncError](response);
        },
        complete: function () {
            // console.log("complete");
        },
    })
        .then(function () {})
        .catch(function (e) {
            // Toast.fire({
            //     icon: "info",
            //     title: e.responseJSON.message,
            // });
            if(LoaderOption=="True"  &&  LoaderClass!=null) 
            $(LoaderClass).html('');
        });
}

function Ajax_Call_Dynamic_html(
    url,
    method,
    formdata,
    callBackFuncSuccess,
    callBackFuncError,
    LoaderClass=null,
    LoaderOption="True"
) {
    $.ajax({
        url: url,
        method: method,
        contentType: false,
        processData: false,
        data: formdata,
        dataType: "html",
        beforeSend: function () {
            if(LoaderOption=="True"  &&  LoaderClass!=null) 
            $(LoaderClass).html(
                '<div class="overlay-loader d-flex align-items-center justify-content-center flex-column " id="loader" style="background-color: transparent;"><div class="spinner-border color-primary text-light" role="status"></div></div>'
            );
        },
        success: function (response) {
            // console.log("success");

            window[callBackFuncSuccess](response);
        },
        error: function (response) {
            // console.log("error");

            window[callBackFuncError](response);
        },
        complete: function () {
            // console.log("complete");
        },
    })
        .then(function () {})
        .catch(function (e) {
           
            // Toast.fire({
            //     icon: "info",
            //     title: e.responseJSON.message,
            // });
            if(LoaderOption=="True"  &&  LoaderClass!=null) 
            $(LoaderClass).html('');
        });
}
