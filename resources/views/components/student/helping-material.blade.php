<div>
    <div>
        @if (!is_null($folders))
        @forelse($folders as $key => $folder)
        @if ($loop->first)
        <h4 class="px-18 text-sb">
            {{ beautify_slug($key) ?? 'Folder' }}
        </h4>
        @endif
        @foreach ($folder as $k => $file)
        <div class="d-flex justify-content-between py-4 px-2 border-bottom">
            <div class="d-flex align-items-center">
            
                            {{--  $file_type=get_icon_of_resource_file($file->file_type);  --}}
                            
                         
                {{-- <img src="{{$file_type}}" style="width:50px;height:50px" alt="file" class="me-3"> --}}
                <object type="image/svg+xml" data="{!! get_icon_of_resource_file($file->file_type) !!}" width="45" height="45">
                    Your browser does not support SVG.
                  </object>
                <div>
                    <h5 class="mb-1 px-14 text-sb">{{ $file->title . '.' . $file->file_type ?? '--' }}</h5>
                    <p class="mb-0 px-12 text-med">
                        {{ $file->created_at->format('d M,Y') . ' at ' . $file->created_at->format('h:i') }}
                    </p>
                </div>
            </div>
            <div>
                <a target="_blank" href="{{ asset('storage/' . $file->file) }}" class="btn me-sm-2 p-1 p-sm-2"><i
                        class="fa fa-eye" aria-hidden="true"></i></a>
                <a target="_blank" href="{{ asset('storage/' . $file->file) }}" download="{{ $file->file }}"
                    class="btn p-1"><i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
        </div>
        @endforeach
        @empty
        <h5 class="px-14 fw-bold pb-2 mb-0 text-center">{{ __('No available files yet!') }}</h5>
        @endforelse
        @else
            <h5 class="px-14 fw-bold pb-2 mb-0 text-center">{{ __('No available files yet!') }}</h5>
        @endif
        {{-- <div class="d-flex justify-content-between py-4 px-2 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{asset('/images/pdf.svg')}}" alt="file" class="me-3">
                <div>
                    <h5 class="mb-1 px-14 text-sb">Tajweed book.pdf</h5>
                    <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                </div>
            </div>
            <div>
                <button class="btn me-sm-2 p-1 p-sm-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button class="btn p-1"><i class="fa fa-download" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between py-4 px-2 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{asset('/images/word.svg')}}" alt="file" class="me-3">
                <div>
                    <h5 class="mb-1 px-14 text-sb">tajweed book.docx</h5>
                    <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                </div>
            </div>
            <div>
                <button class="btn me-sm-2 p-1 p-sm-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button class="btn p-1"><i class="fa fa-download" aria-hidden="true"></i></button>
            </div>
        </div>
        <h4 class="px-18 text-sb my-4">
            Notes by Sheikh Waqas
        </h4>
        <div class="d-flex justify-content-between py-4 px-2 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{asset('/images/pdf.svg')}}" alt="file" class="me-3">
                <div>
                    <h5 class="mb-1 px-14 text-sb">Tajweed book.pdf</h5>
                    <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                </div>
            </div>
            <div>
                <button class="btn me-sm-2 p-1 p-sm-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button class="btn p-1"><i class="fa fa-download" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between py-4 px-2 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{asset('/images/word.svg')}}" alt="file" class="me-3">
                <div>
                    <h5 class="mb-1 px-14 text-sb">tajweed book.docx</h5>
                    <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                </div>
            </div>
            <div>
                <button class="btn me-sm-2 p-1 p-sm-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button class="btn p-1"><i class="fa fa-download" aria-hidden="true"></i></button>
            </div>
        </div> --}}
    </div>
</div>
