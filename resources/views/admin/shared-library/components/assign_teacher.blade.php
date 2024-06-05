<div class="d-flex align-items-center w-100">
    <form id="assign-teacher-{{$row->id}}" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.shared-library.assignTeachers', $row->id) }}">
        @csrf
        <select class="form-select form-select-solid select2-selection--clearable select3-multiple @error('type') is-invalid @enderror" data-kt-select2="true" name="teachers[][shareable_id]"  data-placeholder="Select teachers to assign" multiple="multiple">
            <option></option>
            @foreach(\App\Models\User::role(\App\Classes\Enums\UserTypesEnum::Teacher)->get() as $jkey => $teacher)
                <option value="{{ $teacher->id }}" {!! in_array($teacher->id, array_column($row->users->toArray() ?? array(), 'id') ?? array()) ? 'selected' : '' !!}
                >{{ $teacher->reg_no.') '. $teacher->name }}</option>
            @endforeach
        </select>
    </form>
    <button type="submit" form="assign-teacher-{{$row->id}}" class="btn btn-icon btn-light-primary me-3 ms-3">
        <span class="indicator-label">
            <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="black"></path>
                </svg>
            </span>
        </span>
    </button>
</div>

