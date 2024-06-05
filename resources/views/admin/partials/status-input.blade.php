<div class="card">
    <div class="card-body">
        <label class="required fw-bold fs-6 mb-5">Status</label>
        <div>
            @foreach(\App\Classes\Enums\StatusEnum::$Basic_statuses as $key => $status)
                <div class="d-inline-block @if(!$loop->first) ms-4 @endif">
                    <input class="form-check-input" name="status" type="radio" value="{{ $status }}" id="status-{{$key}}" @if(@$data->status == $status || $loop->first) checked="checked" @endif form="create-user-form">
                    <label class="form-check-label" for="status-{{$key}}">
                        <div class="fw-bolder text-gray-800">{{ beautify_slug($status) }}</div>
                    </label>
                </div>
            @endforeach
            @error('status')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>
