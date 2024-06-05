<?php
namespace App\Traits;

use App\Classes\AlertMessages;
use App\Http\Requests\GetStatsOfStudentRequest;
use App\Http\Requests\GetStatsOfTeacherForMonthRequest;
use App\Http\Requests\Teacher\GetStatsOfMonthRequest;
use App\Models\WeeklyClass;
use App\Services\JsonResponseService;
use Carbon\Carbon;
use Exception;

trait StateHelperClass
{
    public function GetStatsOfTeacherForMonth(GetStatsOfTeacherForMonthRequest $request)
    {
        try {
            if ($request->ajax()) {

                $OneMonthStats = WeeklyClass::where('teacher_id', $request->teacherid)->whereMonth(
                    'class_time',
                    now()->subMonth(abs($request->submonths))->format('m')
                )->get()->groupBy('teacher_status');



                if ($OneMonthStats->isNotEmpty()) {
                    $OneMonthStats['month_full'] =  Carbon::now()->subMonth(abs($request->submonths))->format('F');
                    $OneMonthStats['month_short'] = Carbon::now()->subMonth(abs($request->submonths))->format('M');
                    return JsonResponseService::JsonSuccess("Success", $OneMonthStats);
                }
            }
            return JsonResponseService::JsonFailed("No Stats For Asked Month Found", []);
        } catch (Exception $e) {

            return JsonResponseService::getJsonException($e);
        }
    }

    public function GetTeacherStatsOfMonth(GetStatsOfMonthRequest $request)
    {
        try {
            if ($request->ajax()) {

                $OneMonthStats = WeeklyClass::where('teacher_id', $request->teacherid)->whereMonth(
                    'class_time',
                    now()->subMonth(abs($request->submonths))->format('m')
                )->get()->groupBy('teacher_status');



                if ($OneMonthStats->isNotEmpty()) {
                    $OneMonthStats['month_full'] =  Carbon::now()->subMonth(abs($request->submonths))->format('F');
                    $OneMonthStats['month_short'] = Carbon::now()->subMonth(abs($request->submonths))->format('M');
                    return JsonResponseService::JsonSuccess("Success", $OneMonthStats);
                }
            }
            return JsonResponseService::JsonFailed(AlertMessages::STATS_NOT_FOUND, []);
        } catch (Exception $e) {

            return JsonResponseService::getJsonException($e);
        }
    }

    public function GetStudentStatsOfMonth(GetStatsOfStudentRequest $request)
    {
        try {
            if ($request->ajax()) {
              
                 $OneMonthStats = WeeklyClass::Query()->select('student_status')->where('student_id', $request->studentid)->when($request->submonths >= 1, function ($q) use ($request) {
                            return $q->whereMonth('class_time', now()->addMonth(abs($request->submonths))->format('m'));
                        })->when($request->submonths < 0, function ($q) use ($request) {
                            return $q->whereMonth('class_time', now()->subMonth(abs($request->submonths))->format('m'));
                        })->when($request->submonths == 0, function ($q) {
                            return $q->whereMonth('class_time', now()->format('m'));
                        })->get()->groupBy('student_status');



                if ($OneMonthStats->isNotEmpty()) {
                    $OneMonthStats['month_full'] =  Carbon::now()->subMonth(abs($request->submonths))->format('F');
                    $OneMonthStats['month_short'] = Carbon::now()->subMonth(abs($request->submonths))->format('M');
                    return JsonResponseService::JsonSuccess("Success", $OneMonthStats);
                }
            }
            return JsonResponseService::JsonFailed(AlertMessages::STATS_NOT_FOUND, []);
        } catch (Exception $e) {

            return JsonResponseService::getJsonException($e);
        }
    }
}
