<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherCoordinator\AddAvailabilityRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherCoordinatorController extends Controller
{


    public function addAvailability(AddAvailabilityRequest $request)
    {
        try {
            DB::beginTransaction();
            $User = User::query()->find($request->user_id);

            $availability_update = $User->availability()->updateOrCreate([
                'user_id' => $request->user_id,
            ], [
                'status' => 'active',
                'user_type' => 'teacher-coordinator',
                'timezone' => $request->timezone,
            ]);

            $User->clone()->update([
                'timezone' => $request->timezone
            ]);


            DB::commit();
            return redirect()->back()->with('success', 'Operation Successfull');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
