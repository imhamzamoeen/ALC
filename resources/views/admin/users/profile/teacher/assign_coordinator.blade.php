@php $coordinators = \App\Models\User::role(\App\Classes\Enums\UserTypesEnum::TeacherCoordinator)->get() @endphp
@if($coordinators)
<div class="card pt-4 mb-6 mb-xl-9">
     <div class="card-header border-0">
          <div class="card-title">
              <h2>Teacher Coordinator Assignment</h2>
          </div>
     </div>
    <div class="card-body">
        <form method="post" action="{{ route('admin.users.'.$user->user_type.'.assignCoordinator', $user->id) }}">
            @csrf
            <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-bold fs-6 mb-2">Select Coordinator</label>
                <select class="form-control select2-selection--clearable select3-multiple @error('coordinator') is-invalid @enderror" data-kt-select2="true" name="coordinator"  data-placeholder="Select coordinator to assign">
                    <option></option>
                    @foreach($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}" @if(old('$coordinator') == $coordinator->id || $user->coordinated_by == $coordinator->id) selected @endif>{{ $coordinator->name }}</option>
                    @endforeach
                </select>
                @error('coordinator')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            @if(!$user->coordinated_by)
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
