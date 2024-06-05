<?php

namespace App\Http\Controllers\Student;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\WeeklyClass;
use App\View\Components\Customer\CustomizeSubscription;
use App\View\Components\Student\ClassSchedule;
use App\View\Components\Student\HelpingMaterial;
use App\View\Components\Student\RecordedClasses;
use App\View\Components\Student\RequestReschedule;
use App\View\Components\Student\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function dashboard($locale, Student $student)
    {

        /*$view = new CustomizeSubscription('abc', $student);
        dd($view->resolveView()->with($view->data())->render());*/
        return view('front.customer.student.dashboard', compact('student'));
    }

    public function getComponent(Request $request, $locale, Student $student)
    {
        try {
            $page = $request->page;

            switch ($page) {
                case 'timeline': {
                        $view = new Timeline($student);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'class_schedule': {
                        $view = new ClassSchedule(Student::withCount('Reschedule_Requests')->find($student->id));
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'helping_material': {
                        $view = new HelpingMaterial($student);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'recorded_classes': {
                        $view = new RecordedClasses($student);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                default: {
                        return response()->json(['fillableData' => '', 'status'  => 'error', 'message' => AlertMessages::ERROR_500], 500);
                    }
            }


            return response()->json(['fillableData' => $view, 'status'  => 'success', 'message' => ''], 200);
        } catch (\Exception $e) {
            //dd($e);
            return response()->json(['fillableData' => '', 'status'  => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function rescheduleRequest(Request $request, $locale, Student $student)
    {
        $class = WeeklyClass::findOrFail($request->class);

        $view = new RequestReschedule($student, $class);
        $view = $view->resolveView()->with($view->data())->render();

        return response()->json(['fillableData' => $view, 'status'  => 'success', 'message' => ''], 200);
    }

    public function saveRescheduleRequest(Request $request, Student $student)
    {
        $request->validate([
            'slots' => ['required']
        ]);
        try {
            DB::beginTransaction();

            /*todo: save the resechedule request as per the table data*/

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Class reschedule requested successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => AlertMessages::ERROR_500], 200);
        }
    }
}
