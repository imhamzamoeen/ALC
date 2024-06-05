@php $folders = \App\Models\SharedLibrary::all(); @endphp
@if($folders)
<div class="card pt-4 mb-6 mb-xl-9">
     <div class="card-header border-0">
          <div class="card-title">
              <h2>Shared Library Assignment</h2>
          </div>
     </div>
    <div class="card-body">
        <form method="post" action="{{ route('admin.users.'.$user->user_type.'.assignLibrary', $user->id) }}">
            @csrf
            <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-bold fs-6 mb-2">Select folders to assign</label>
                <select class="form-control select2-selection--clearable select3-multiple @error('folder') is-invalid @enderror" data-kt-select2="true" name="folder[][shared_library_id]"  data-placeholder="Select folder to assign" multiple="multiple">
                    <option></option>
                    @foreach($folders as $folder)
                        <option value="{{ $folder->id }}"
                                @if(in_array($folder->id, array_column($user->shareableLibraries->toArray() ?? array(), 'shared_library_id') ?? array()))
                                selected
                                @endif
                        >{{ $folder->title }}</option>
                    @endforeach
                </select>
                @error('folder')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            @if(!count($user->shareableLibraries))
                <button type="submit" id="submit-availability" class="btn float-end btn-primary">
                    Assign
                </button>
            @else
                <button type="submit" id="submit-availability" class="btn btn-danger float-end" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Updating teacher's coordinator will effect dependencies.Please make sure of the changes before proceeding" aria-hidden="true">
                    <i class="fas fa-shield-alt"></i> Update
                </button>
            @endif
        </form>
    </div>
</div>

@endif
