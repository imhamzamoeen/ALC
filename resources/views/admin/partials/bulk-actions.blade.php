<form class="d-flex" id="bulk-action" role="form" method="post"
    action="{{ route(auth()->user()->user_type . '.' . $module_slug . '.' . (isset($action) ? $action : 'bulkAction')) }}">
    @csrf
    <div class="fw-bolder me-5">
        <select name="action" data-control="select2" data-hide-search="true" data-placeholder="Bulk actions"
            class="form-select form-select-grey form-select-sm">
            <option></option>
            <option value="delete">Delete</option>
            {{-- <option value="export" disabled>Export</option> --}}
        </select>
    </div>
    <a href="javascript:void(0)" id="bulk-action-btn"
        class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">
        Apply
    </a>
</form>
