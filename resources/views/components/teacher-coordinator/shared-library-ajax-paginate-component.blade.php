<div class="col-md-4 folder-col">
    <div class="d-flex p-4 border rounded new-folder-btn">
        <img width="40" src="{{ asset('/images/add-folder.png') }}" class="me-3" alt="add-folder">
        <span class="text-primary d-flex align-items-center">{{ __('Create New Folder') }}</span>
    </div>
</div>

@foreach ($Model as $folder)
    <div class="col-md-4 folder-col">
        <div class="p-4 border rounded folder position-relative">
            <div class="d-flex folder-name">
                <img width="40" src="{{ asset('/images/empty-folder.png') }}" class="me-3" alt="add-folder">
                <a class="nav nav-link nav-item px-0 px-14 text-dark" id="upload-tab" data-bs-toggle="tab"
                    data-id="{{ $folder->id }}" data-bs-target="#upload" role="tab" aria-controls="upload"
                    aria-selected="true"><span class="d-flex align-items-center">{{ $folder->title }}</span></a>
            </div>
            <button class="btn edit-btn"><i class="fa fa-pencil"></i></button>
            <button class="btn submit-btn"><i class="fa fa-check-circle-o" style="font-size:30px;"></i></button>
            <div class="spinner-border color-primary text-light loading" role="status"></div>
        </div>
    </div>
@endforeach


<div class="paginates-section">
    <div>
        {{ $Model->links() }}

    </div>
</div>

<style>
    .pagination .page-link {
        z-index: 1 !important;
    }
</style>

<script>
    $(document).ready(function() {

        $(document).off(
            '.library_events'); //removing events to prevent them from reassigning when user revisits this tab
        $(document).off('.folder_events'); //removing events of each folder tab
        $(document).on('click.library_events', nameFolder);

        $(document).on('keypress.library_events', submitOnEnter);

        $(document).on('click.library_events', '.naming-folder', function(event) {
            event.stopPropagation();
        });
        $(document).on('click.library_events', '.submit-btn', nameFolder);
        $(document).on('click.library_events', '.folder-name', getFolderFiles);

        //submits name on enter keypress
        function submitOnEnter(e) {
            if (e.which == 13) {
                nameFolder();
            } else {
                $('.tooltiptext').removeClass("show");
            }
        }
    });

    var FolderSelected;
    // handles edit click event
    $('.edit-btn').on('click', function(e) {
        e.preventDefault();
        const _this = $(this);
        editFolder(_this);

    });

    // when user clicks on previously added folder
    $('.folder-name .nav').on('click', function() {
        $(this).removeClass('active');
    })
    var folderName = '';

    //runs on name submit during new addition and also while renaming
    function nameFolder() {
        $('.naming-folder .submit-btn').hide();
        $('.naming-folder .loading').show();
        folderName = $('.naming-folder .folder-name-input').val();
        if (!(folderName == undefined || folderName === 'undefined')) {
            if (folderName === '' || invalidName(folderName)) {
                const message = 'Invalid Folder Name';
                showTooltip(message);
                // return false;
            } else {
                if ($('.naming-folder').hasClass('editing'))
                    EditFolderToCoordinator(folder_id, folderName)
                else
                    AddFolderToCoordinator(folderName)

                // return true;
            }
        }
        //  else return true
        // return true;
    }

    //runs when user clicks edit button button 
    function editFolder(_this) {
        folderName = $(_this).parent().find('.nav span').html();
        // alert(folderName);
        folder_id = $(_this).parent().find('.nav').data('id');
        $(_this).parent().find('a.nav').remove();
        setTimeout(() => {
            $('.folder:not(.naming-folder)').addClass('avoid-clicks');
        }, 100);

        //replacing folder name with input field.
        $(_this).parent().find('.folder-name').append(
            '<input type="text" id="folder-name" name="folder-name" required autofocus value="' +
            folderName +
            '" id="folder-name" class="border-0 folder-name-input w-100 text-sb" placeholder="Folder name"><span class="tooltiptext text-med">Invalid Folder Name</span>'
        )

        const end = folderName.length;
        const el = document.getElementById('folder-name');

        //brings input cursor to end of input text.
        el.setSelectionRange(end, end);
        el.focus();

        $(_this).parent().addClass('naming-folder editing');
        $(_this).hide();
        $(_this).siblings('.submit-btn').show();
    }

    //on new folder button click creates new folder div in dom.
    $('.new-folder-btn').click(function(event) {
        event.stopPropagation();
        // const add_folder = nameFolder();
        // if (add_folder) {
        $('<div class="col-md-4 folder-col"><div class="p-4 border rounded folder naming-folder position-relative"><div class="d-flex folder-name"><img width = "40" src="{{ asset('/images/empty-folder.png') }}" class = "me-3" alt = "add-new-folder" ><input type="text" id="folder-name" name="folder-name" required autofocus class="border-0 folder-name-input w-100 text-sb" placeholder="New Folder"><span class="tooltiptext text-med"></span></div><button class="btn edit-btn" style="display: none"><i class="fa fa-pencil"></i></button><button class="btn submit-btn"><i class="fa fa-check-circle-o" style="font-size:30px;"></i></button><div class="spinner-border color-primary text-light loading" role="status"></div></div></div>')
            .insertAfter($(this).parent());
        $('#folder-name').focus();
        // } else {
        //     $('#folder-name').focus();
        // }
        $('.folder:not(.naming-folder), .new-folder-btn').addClass('avoid-clicks');

    });

    //runs automatically after foalder is clicked to get files.
    function getFolderFiles() {
        if ($(this).parent().hasClass('editing'))
            return
        else {
            folder_id = $(this).find('a').data('id');
            Folder_Name = $(this).find('a > span').html();

            FolderSelected = folder_id;
            var formdata = new FormData();
            formdata.append('folder_id', folder_id);
            Ajax_Call_Dynamic(
                '{{ route('teacher-coordinator.GetFolderFiles', [app()->getLocale()]) }}', "post",
                formdata, "GetFolderFileSuccess",
                'FailedResponse', '.ajax_pagination');
        }
    }

    //runs automatically on success of above function
    function GetFolderFileSuccess(response) {
        $('.main_heading').html(Folder_Name);
        $('.ajax_pagination').html(response.response);
    }

    //runs api for adding folder
    function AddFolderToCoordinator(folder_name) {
        var formdata = new FormData();
        formdata.append('folder_name', folder_name);
        Ajax_Call_Dynamic('{{ route('teacher-coordinator.CreateFolder', [app()->getLocale()]) }}', "post",
            formdata,
            "AddFolderSucceess",
            'FailedResponse', );
    }

    //runs api for editing folder
    function EditFolderToCoordinator(id, folder_name) {
        var formdata = new FormData();
        formdata.append('title', folder_name);
        formdata.append('id', id);

        Ajax_Call_Dynamic('{{ route('teacher-coordinator.UpdateFolderName', [app()->getLocale()]) }}', "post",
            formdata, "EditFolderSucceess",
            'FailedResponse', );
    }

    //after api returns success remove input field and replace text and show hide buttons respectively.
    function onSuccess(id = folder_id) {
        // $('.naming-folder .submit-btn').remove();
        $('div.folder-name input#folder-name').remove();
        $('.naming-folder .folder-name').append(
            '<a class="nav nav-link nav-item px-0 text-dark" id="upload-tab" data-bs-toggle="tab" data-id="' +
            id +
            '" data-bs-target="#upload"  role="tab" aria-controls="upload" aria-selected="true"><span class="d-flex align-items-center">' +
            folderName + '</span></a>');
        $('.naming-folder .loading').hide();
        $('.folder, .new-folder-btn').removeClass('avoid-clicks');
        $('.tooltiptext').removeClass("show");
        folderName = '';
        folder_id = '';
        $('.edit-btn').off();
        $('.edit-btn').on('click', function(e) {
            e.preventDefault();
            const _this = $(this);
            editFolder(_this);

        });
    }

    //show error tooltips
    function showTooltip(message) {
        $('.naming-folder').addClass("horizontal-shake");
        setTimeout(() => {
            $('.naming-folder').removeClass("horizontal-shake");
        }, 1000);
        $('.naming-folder .tooltiptext').addClass("show");
        $('.naming-folder .tooltiptext').html(message);
        $('.folder-name-input').focus();
        $('.naming-folder .loading').hide();
        $('.naming-folder .submit-btn').show();
    }

    //runs automatically after folder is added successfully
    function AddFolderSucceess(response) {
        onSuccess(response.response.id);
        $('.naming-folder').removeClass('naming-folder')
        Toast.fire({
            icon: 'success',
            title: 'Folder Added Successfully',
            timer: 1500
        })
    }

    //runs automatically after folder is edited  successfully
    function EditFolderSucceess(response) {
        onSuccess();
        Toast.fire({
            icon: 'success',
            title: 'Folder Renamed Successfully',
            timer: 1500
        })
        $('.naming-folder').removeClass('naming-folder editing')
    }

    //runs automatically after failded response
    function FailedResponse(response) {
        const errors = response.responseJSON.errors;
        const message = Object.values(errors)[0]
        showTooltip(message);
    }
</script>
