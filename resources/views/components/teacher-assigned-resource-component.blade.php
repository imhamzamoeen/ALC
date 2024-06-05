<!-- for the first time the $firsttime is null and print all the folder with the files even if null but when we use search the firsttime becomes true and it only print folder name if it has files and later if the files of a folder is empty and its first then show no file -->
@isset($Model->libraries)
@forelse ($Model->libraries as $folder)
@if(is_null($first_time))
<h4 class="px-18 text-sb mb-4">
    {{ $folder->title }}
</h4>
@elseif($folder->files->isNotEmpty())
<h4 class="px-18 text-sb mb-4">
    {{ $folder->title }}
</h4>
@endif
@forelse ($folder->files as $file)
<div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom mb-3">
    <div class="d-flex align-items-center">
        {{-- <img src="{!!
                get_icon_of_resource_file($file->file_type) !!}" alt="file" class="me-2" height="45px" width="45px"> --}}
                   <object type="image/svg+xml" data="{!! get_icon_of_resource_file($file->file_type) !!}" width="45" height="45">
                    Your browser does not support SVG.
                  </object>
        <div>
            <h5 class="mb-1 px-14 text-sb">{{ $file->title.'.'.$file->file_type }}</h5>
            <p class="mb-0 px-12 text-med">{{ $file->created_at->diffForHumans() }}</p>
        </div>
    </div>
    <div>
        <label class="switch">
            <input type="checkbox" name="ResrouceCheckbox[]" value="{{ $file->id }}" id="">
            <span class="slider round"></span>
        </label>
    </div>
</div>
@empty
@if(is_null($first_time))
<div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom mb-3">
    <h4 class="px-18 text-sb">
        {{ __('No Files') }}
    </h4>
</div>
@endif
{{-- <div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom mb-3">
    <h4 class="px-18 text-sb">
        {{ __('No Files') }}
    </h4>
</div> --}}
@endforelse
@empty

<h4 class="px-18 text-sb mb-4">
    {{ __('No Folder') }}
</h4>
@endforelse


@endisset