@if(!is_null($courses))
<div class="card pt-4 mb-6 mb-xl-9">
     <div class="card-header border-0">
          <div class="card-title">
              <h2>Course Assignment</h2>
          </div>
     </div>
    <div class="card-body">
        <form method="post" action="{{ route('admin.users.'.$user->user_type.'.assignCourses', $user->id) }}">
            @csrf
            <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-bold fs-6 mb-2">Select Course</label>
                <select class="form-control select2-selection--clearable select3-multiple @error('courses') is-invalid @enderror" data-kt-select2="true" name="courses[][course_id]"  data-placeholder="Select courses to assign" multiple="multiple">
                    <option></option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                                @if(in_array($course->id, array_column(old('courses') ?? array(), 'course_id') ?? array()) ||
                                    in_array($course->id, array_column($user->courses->toArray() ?? array(), 'id') ?? array()))
                                    selected
                                @endif>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('courses')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            @if(!count($user->courses))
                <button type="submit" id="submit-availability" class="btn float-end btn-primary">
                    Assign
                </button>
            @else
                <button type="submit" id="submit-availability" class="btn btn-danger float-end" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Updating teacher's courses will effect dependencies.Please make sure of the changes before proceeding" aria-hidden="true">
                    <i class="fas fa-shield-alt"></i> Update
                </button>
            @endif
        </form>
    </div>
</div>

@endif
