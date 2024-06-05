<div class="card card-flush mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <?php
        $current = '';
        $notifications = $user->notifications;
        ?>
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h2 class="mb-1">{{ $user->first_name }}'s Refund</h2>
            <div class="fs-6 fw-bold text-muted">{{ $user->profiles ? $user->profiles->count() : 0 }} Students</div>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body d-flex flex-column">
        <!--begin::Item-->
        <form action="{{ route(auth()->user()->user_type.'.users.refund') }}" method="post" class="px-14 text-med ">
            @csrf
            <div class="form-group">
                <select class="form-select refund-student" name="student" aria-label="Default select example" required>
                    <option  value="">Select Student Profile</option>
                    @foreach($user->refund as $key => $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-5 total_price_student" style="display: none">
                <label for="exampleInputEmail1">Price</label>
                <input type="number" name="TotalPrice" class="form-control total_price" placeholder="Enter amount"  disabled>
                <small id="emailHelp" class="form-text text-muted">Total amount of student package.</small>
            </div>
            <div class="form-group mt-5">
                <label for="exampleInputEmail1">Amount</label>
                <input type="number" name="amount" class="form-control" placeholder="Enter amount" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                <small id="emailHelp" class="form-text text-muted">Enter the total amount of the refund.</small>
                <input type="hidden" name="user_Id" class="form-control" value="{{$user->id}}" placeholder="Enter amount">
            </div>

            <button type="submit" class="btn btn-primary mt-2 ">Submit</button>
        </form>
    </div>
    <!--end::Card body-->
</div>