<?php

namespace App\Http\Controllers\Teacher;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\AssignResouceToStudentRequest;
use App\Http\Requests\Teacher\GetStudentResourceRequest;
use App\Models\Fileable;
use App\Models\Student;
use App\Models\User;
use App\Services\JsonResponseService;
use App\View\Components\StudentAssignedResources;
use App\View\Components\TeacherAssignedResourceComponent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class ResourceController extends Controller
{
    public function SearchResource(Request $request)
    {
        try {
            if ($request->ajax()) {
                $Model = User::whereId(auth()->user()->id)->with(['libraries.files' => function ($query) use ($request) {
                    return   $query->where('title', 'like', '%' . $request->search . '%');
                }])->whereHas('libraries.files', function ($query) use ($request) {
                    return   $query->where('title', 'like', '%' . $request->search . '%');
                })->first();
                if (is_null($Model)) {
                    return JsonResponseService::JsonSuccess("Success", '<div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom mb-3">
                <h4 class="px-18 text-sb">' .
                        __('No Files') .
                        '</h4>
            </div>');
                }
                $view = new TeacherAssignedResourceComponent($Model,True);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }

    public function GetStudentResource(GetStudentResourceRequest $request)
    {
        try {
            if ($request->ajax()) {

                $Model = User::whereId(auth()->user()->id)->with(['Students' => function ($q) use ($request) {
                    $q->where('id', $request->studentid);
                }, 'Students.files'])->first();
                $view = new StudentAssignedResources($Model);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }


    public function AssignResourceToStudent(AssignResouceToStudentRequest $request)
    {
        try {
            if ($request->ajax()) {
                DB::transaction(function () use ($request) {
                    $already_user_files = Fileable::where('fileable_id', $request->student_id)->pluck('library_file_id')->toArray();
                    $data = [];
                    foreach ($request->libray_files as $key => $value) {
                        if (!in_array($value, $already_user_files)) {
                            $data[] = [
                                'library_file_id' => $value,
                                'fileable_id' => $request->student_id,
                                'fileable_type' => 'App\Models\Student',
                            ];
                        }
                    }

                    foreach (array_chunk($data, 5) as $chunk) {
                        $result = Fileable::insert($chunk);  // har us chunk ko insert kro db mai 
                    };
                });
                return JsonResponseService::JsonSuccess("Success", []);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            DB::rollback();
            return JsonResponseService::getJsonException($e);
        }
    }


    public function RemoveResourceToStudent(Request $request)
    {
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
                $Fileable = Fileable::find($request->fileableid);
                $student_id = $Fileable->fileable_id;
                $Fileable->delete();
                // $Model = User::whereId(auth()->user()->id)->with(['Students' => function ($q) use ($student_id) {
                //     $q->where('id', $student_id);
                // }, 'Students.files'])->first();
                // $view = new StudentAssignedResources($Model);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                // $view = $view->resolveView()->with($view->data())->render();

                // if(!empty($view)){
                DB::commit();
                return JsonResponseService::JsonSuccess("Success", []);
                // }

            }
            DB::rollback();
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            DB::rollback();
            return JsonResponseService::getJsonException($e);
        }
    }
}
