<div class="container-xl library">
    <h4 class="px-24 text-sb mb-4 main_heading">{{ __('Library') }}</h4>
    <div class="row text-sb px-14 ajax_pagination">


    </div>

</div>

{{-- @push('after-style') --}}
<style>
    .folder-col.col-md-4 {
        margin-top: 20px;
    }

    .folder-col .new-folder-btn,
    .folder-col .folder {
        cursor: pointer;
    }

    .folder-col .folder-name-input:focus-visible {
        outline: 0;
    }

    .folder-col .naming-folder {
        border-color: #AC1335 !important;
    }

    .folder-col .nav {
        font-size: var(--px-14) !important;
    }

    .folder-col .edit-btn:focus,
    .folder-col .submit-btn:focus {
        box-shadow: none !important;
        color: var(--primary-color);
    }

    .folder-col .edit-btn:hover,
    .folder-col .submit-btn:hover {
        color: var(--primary-color);
    }

    .folder-col .edit-btn,
    .folder-col .submit-btn,
    .folder-col .loading {
        display: none;
        position: absolute;
        right: 3%;
        top: 28px;
        padding: 0;

    }

    .naming-folder .submit-btn {
        display: block;
    }

    /* .folder-col .naming-folder .folder-name-input {
        width: 145px;
    } */

    .folder-col .folder:not(.naming-folder):hover {
        background-color: var(--bs-light);
    }

    .folder-col .folder:not(.naming-folder):hover .edit-btn {
        display: inline !important;
        font-size: 20px;
    }

    .folder-col .folder span:not(.tooltiptext) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 150px;
        display: inline-block !important;
    }

    .folder-col .folder-name {
        position: relative;
        display: inline-block;
        width: 80%;
    }

    .folder-col .folder .nav:hover span {
        color: var(--primary-color);
    }

    .folder-col .folder .nav {
        display: inline-block;
        height: 0;
    }

    /* Tooltip text */
    .tooltiptext {
        visibility: hidden;
        width: 235px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text - see examples below! */
        position: absolute;
        top: 45px;
        left: 10px;
        z-index: 1;
        opacity: 0;
        background-color: #dc3545a8;
        transition: opacity 1s;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltiptext.show {
        visibility: visible;
        opacity: 1;

    }

    .tooltiptext::after {
        content: " ";
        position: absolute;
        bottom: 100%;
        /* At the top of the tooltip */
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent #dc3545a8 transparent;
    }

    @media screen and (max-width:575px) {
        .folder-col .folder .edit-btn {
            display: inline;
            font-size: 16px;
        }
    }

    @media screen and (min-width:768px) {
        .folder-col.col-md-4 {
            width: 31%;
            max-width: 300px;
        }

        .folder-col.col-md-4 {
            margin-right: 0;
        }

    }

    /* @media screen and (min-width:768px) and (max-width:991px) {
        .folder-col .naming-folder .folder-name-input {
            width: 100%;
        }
    }

    @media screen and (min-width:992px) and (max-width:1200px) {
        .folder-col .naming-folder .folder-name-input {
            width: 120px;
        }
    } */

    @media screen and (min-width:768px) and (max-width:1300px) {
        .folder-col .col-md-4:not(:nth-child(3n)) {
            margin-right: 2%;
        }
    }

    @media screen and (min-width:1400px) {
        .folder-col .col-md-4:not(:nth-child(4n)) {
            margin-right: 2%;
        }
    }
</style>
{{-- @endpush --}}
{{-- @push('after-script') --}}
<script>
    var folder_id = '';
    var Folder_Name = '--'
    var page = 1;
    $('.folder-name-input').focus();


    $(document).ready(function() {
        $('.ajax_pagination').html(''); //purana content khatam krta tha
        getpaginatedata();
    });
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        page = $(this).attr('href').split('page=')[1];

        //             return ;
        // $('li').removeClass('active');
        // $(this).parent('li').addClass('active');

        // var myurl = $(this).attr('href');
        // var page=$(this).attr('href').split('page=')[1];

        getpaginatedata();
    });
    // $().on('click', function(event) {


    function SharedLibrarySuccess(response) {
        $('.ajax_pagination').html(response.response);
    }

    function getpaginatedata() {
        var url = '{{ route('teacher-coordinator.ajaxpaginatesharedlibrary', [app()->getLocale()]) }}' + '?page=' +
            page;
        Ajax_Call_Dynamic(url, "get", {}, "SharedLibrarySuccess",
            'FailedToasterResponse', '.ajax_pagination', ); // on page load get the folders in pagination view 
    }

    function invalidName(str) {
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        var onlySpaces = str.trim().length === 0;
        console.log('only spaces: ', onlySpaces);
        if (format.test(str) || onlySpaces) {
            return true;
        } else {
            return false;
        }
    }
</script>
{{-- @endpush --}}
