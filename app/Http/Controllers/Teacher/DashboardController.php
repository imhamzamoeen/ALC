<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Classes\AlertMessages;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\AjaxHtml\Teacher\GetComponentRequest;
use App\Http\Requests\Teacher\GetStatsOfMonthRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\View\Components\TimeLineComponent;
use App\View\Components\ScheduleComponent;
use App\Services\JsonResponseService;
use App\Traits\StateHelperClass;
use App\View\Components\AttendanceComponent;
use App\View\Components\ClassStatsComponent;
use App\View\Components\TeacherStudentComponent;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class DashboardController extends Controller
{
    use StateHelperClass;


    public function index()
    {

        return view('front.teacher.dashboard');
    }



    public function getComponent(GetComponentRequest $request, $locale)
    {
        try {
            switch ($request->page) {
                case 'timeline': {
                        $view = new TimeLineComponent(User::select('id', 'user_type')->whereId(auth()->id())->with(['notifications'])->first());   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'schedule': {
                        $view = new ScheduleComponent(User::withCount('Reschedule_Requests')->with('courses')->find(auth()->id()));
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'students': {

                        $view = new TeacherStudentComponent(auth()->user()->load(['courses', 'Students.files', 'libraries.files']));
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'class_stats': {
                        $data = WeeklyClass::where('teacher_id', auth()->user()->id)->whereBetween('class_time', [
                            Carbon::now()->startOfYear(),
                            Carbon::now()->endOfYear(),
                        ])->get()->sortBy('teacher_status')->groupBy(function ($val) {
                            return Carbon::parse($val->class_time)->format('F');
                        });

                        foreach ($data as $key => $eachmonth) {
                            $count = ['count' => $eachmonth->count()];
                            $types = $eachmonth->groupBy('teacher_status');
                            $data[$key] = $types;
                            $data[$key]['count'] = $count;
                        }
                        $view = new ClassStatsComponent($data);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                default: {
                        return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
                    }
            }
            return JsonResponseService::JsonSuccess("Success", $view);
        } catch (\Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }

    // public function GetTeacherStatsOfMonth(GetStatsOfMonthRequest $request)
    // {
    //     try {
    //         if ($request->ajax()) {

    //             $OneMonthStats = WeeklyClass::where('teacher_id', $request->teacherid)->whereMonth(
    //                 'created_at',
    //                 now()->subMonth(abs($request->submonths))->format('m')
    //             )->get()->groupBy('teacher_status');



    //             if ($OneMonthStats->isNotEmpty()) {
    //                 $OneMonthStats['month_full'] =  Carbon::now()->subMonth(abs($request->submonths))->format('F');
    //                 $OneMonthStats['month_short'] = Carbon::now()->subMonth(abs($request->submonths))->format('M');
    //                 return JsonResponseService::JsonSuccess("Success", $OneMonthStats);
    //             }
    //         }
    //         return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
    //     } catch (Exception $e) {

    //         return JsonResponseService::getJsonException($e);
    //     }
    // }
}
