<div class="container-xl library">
    <h4 class="px-24 text-sb mb-4">{{ __('Library') }}</h4>
    <div class="row folder-row text-sb px-14">
        <div class="col-md-4">
            <div class="d-flex p-4 border rounded new-folder-btn">
                <img width="40" src="{{ asset('/images/add-folder.png') }}" class="me-3" alt="add-folder">
                <span class="text-primary d-flex align-items-center">{{ __('Create New Folder') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-between p-4 border rounded folder">
                <div class="d-flex folder-name">
                    <img width="40" src="{{ asset('/images/empty-folder.png') }}" class="me-3" alt="add-folder">
                    <a class="nav nav-link nav-item px-0 px-14 text-dark" id="upload-tab" data-bs-toggle="tab"
                        data-bs-target="#upload" role="tab" aria-controls="upload" aria-selected="true"><span
                            class="d-flex align-items-center">{{ __('Tajweed') }}</span></a>
                </div>
                <button class="btn edit-btn"><i class="fa fa-pencil"></i></button>

            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-between p-4 border rounded folder">
                <div class="d-flex folder-name">
                    <img width="40" src="{{ asset('/images/empty-folder.png') }}" class="me-3" alt="add-folder">
                    <a class="nav nav-link nav-item px-0 px-14 text-dark" id="upload-tab" data-bs-toggle="tab"
                        data-bs-target="#upload" role="tab" aria-controls="upload" aria-selected="true"><span
                            class="d-flex align-items-center">{{ __('Recitation') }}</span></a>
                </div>
                <button class="btn edit-btn"><i class="fa fa-pencil"></i></button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-between p-4 border rounded folder">
                <div class="d-flex folder-name">
                    <img width="40" src="{{ asset('/images/empty-folder.png') }}" class="me-3" alt="add-folder">
                    <a class="nav nav-link nav-item px-0 px-14 text-dark" id="upload-tab" data-bs-toggle="tab"
                        data-bs-target="#upload" role="tab" aria-controls="upload" aria-selected="true"><span
                            class="d-flex align-items-center">{{ __('Hifz') }}</span></a>
                </div>
                <button class="btn edit-btn"><i class="fa fa-pencil"></i></button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-between p-4 border rounded folder">
                <div class="d-flex folder-name">
                    <img width="40" src="{{ asset('/images/empty-folder.png') }}" class="me-3" alt="add-folder">
                    <a class="nav nav-link nav-item px-0 px-14 text-dark" id="upload-tab" data-bs-toggle="tab"
                        data-bs-target="#upload" role="tab" aria-controls="upload" aria-selected="true"><span
                            class="d-flex align-items-center">{{ __('Arabic and Linguistics') }}</span></a>
                </div>
                <button class="btn edit-btn"><i class="fa fa-pencil"></i></button>
            </div>
        </div>
    </div>
    <div class="paginates-section">
        <div>
            <nav>
                <ul class="pagination flex-wrap">
                    <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                        <span class="page-link" aria-hidden="true"><i class="fas fa-angle-double-left"
                                aria-hidden="true"></i></span>
                    </li>
                    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                    <li class="page-item"><button class="page-link">2</button></li>
                    <li class="page-item"><button class="page-link">3</button></li>
                    <li class="page-item"><button class="page-link">4</button></li>
                    <li class="page-item"><button class="page-link">5</button></li>
                    <li class="page-item">
                        <button dusk="nextPage" class="page-link" wire:click="nextPage('page')"
                            wire:loading.attr="disabled" rel="next" aria-label="Next »"><i
                                class="fas fa-angle-double-right" aria-hidden="true"></i></button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
{{-- @push('after-style') --}}
<style>
    .library .col-md-4 {
        margin-top: 20px;
    }

    .library .new-folder-btn,
    .library .folder {
        cursor: pointer;
    }

    .library .folder-name-input:focus-visible {
        outline: 0;
    }

    .library .naming-folder {
        border-color: #AC1335 !important;
    }

    .library .folder-row .nav {
        font-size: var(--px-14) !important;
    }

    .library .edit-btn {
        display: none
    }

    .library .folder:not(.naming-folder):hover {
        background-color: var(--bs-light);
    }

    .library .folder:hover .edit-btn {
        display: inline;
        font-size: 16px;
    }

    .library .folder span:not(.tooltiptext) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 150px;
        display: inline-block !important;
    }

    .library .folder-name {
        position: relative;
        display: inline-block;
    }

    .library .folder .nav:hover span {
        color: var(--primary-color);
    }

    .library .folder .nav {
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
        .library .folder .edit-btn {
            display: inline;
            font-size: 16px;
        }
    }

    @media screen and (min-width:768px) {
        .library .col-md-4 {
            width: 31%;
            max-width: 300px;
        }

        .library .col-md-4 {
            margin-right: 0;
        }
    }

    @media screen and (min-width:768px) and (max-width:1300px) {
        .library .col-md-4:not(:nth-child(3n)) {
            margin-right: 2%;
        }
    }

    @media screen and (min-width:1400px) {
        .library .col-md-4:not(:nth-child(4n)) {
            margin-right: 2%;
        }
    }
</style>
@endpush
@push('after-script')
<script>
    $(document).ready(function() {
        $('.new-folder-btn').on('click', function(event) {
            event.stopPropagation();
            const add_folder = addFolder();
            if (add_folder) {
                $('<div class="col-md-4"><div class="d-flex justify-content-between p-4 border rounded folder naming-folder"><div class="d-flex folder-name"><img width = "40" src="{{ asset('/images/empty-folder.png') }}" class = "me-3" alt = "add-new-folder" ><input type="text" id="folder-name" name="folder-name" required autofocus class="border-0 folder-name-input text-sb w-100" placeholder="New Folder"><span class="tooltiptext text-med">Invalid Folder Name</span></div></div></div>')
                    .insertAfter($(this).parent());
                $('#folder-name').focus();
            } else {
                $('#folder-name').focus();
            }
            $('.folder:not(.naming-folder)').addClass('avoid-clicks');
        })
        $('.folder-name-input').focus();
        $(document).on('keypress', function(e) {
            if (e.which == 13) {
                addFolder();
            } else {
                $('.tooltiptext').removeClass("show");
            }
        });
        $(document).on('click', addFolder);
        $(document).on('click', '.edit-btn', editFolder);
        $(document).on('click', '.naming-folder', function(event) {
            event.stopPropagation();
        });
        $('.folder-name .nav').on('click', function() {
            $(this).removeClass('active');
        })

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

        function addFolder() {
            let folderName = '';
            folderName = $('.naming-folder .folder-name-input').val();
            if (folderName != undefined) {
                if (folderName === '' || invalidName(folderName)) {
                    $('.naming-folder').addClass("horizontal-shake");
                    $('.naming-folder .tooltiptext').addClass("show");
                    setTimeout(() => {
                        $('.naming-folder').removeClass("horizontal-shake");
                    }, 1000);
                    $('.folder-name-input').focus();
                    return false;
                } else {
                    $('.folder-name #folder-name').remove();
                    $('.naming-folder .folder-name').append(
                        '<a class="nav nav-link nav-item px-0 text-dark" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload"  role="tab" aria-controls="upload" aria-selected="true"><span class="d-flex align-items-center">' +
                        folderName + '</span></a>');
                    $('.naming-folder').append(
                        '<button class="btn edit-btn"><i class="fa fa-pencil"></i></button>');
                    $('.folder').removeClass('avoid-clicks');
                    $('.tooltiptext').removeClass("show");
                    if ($('.naming-folder').hasClass('editing')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Folder Renamed Successfully',
                            timer: 1500
                        })
                        $('.naming-folder').removeClass('naming-folder editing')
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: 'Folder Added Successfully',
                            timer: 1500
                        })
                        $('.naming-folder').removeClass('naming-folder')
                    }
                    return true;
                }
            } else return true
            return true;
        }

        function editFolder(event) {
            event.stopPropagation();
            const folderName = $(this).parent().find('.nav span').html();
            $(this).parent().find('a.nav').remove();
            setTimeout(() => {
                $('.folder:not(.naming-folder)').addClass('avoid-clicks');
            }, 100);
            $(this).parent().find('.folder-name').append(
                '<input type="text" id="folder-name" name="folder-name" required autofocus value="' +
                folderName +
                '" id="folder-name" class="border-0 folder-name-input text-sb w-100" placeholder="Folder name"><span class="tooltiptext text-med">Invalid Folder Name</span>'
            )
            const end = folderName.length;
            const el = document.getElementById('folder-name');
            el.setSelectionRange(end, end);
            el.focus();

            $(this).parent().addClass('naming-folder editing');
            $(this).remove();
        }
    })
</script>
@endpush
