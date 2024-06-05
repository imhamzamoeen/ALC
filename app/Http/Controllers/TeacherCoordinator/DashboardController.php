<?php

namespace App\Http\Controllers\TeacherCoordinator;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCoordinator\GetFilesOfFolderRequest;
use App\Models\LibraryFile;
use App\Models\SharedLibrary;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use App\Services\JsonResponseService;
use App\View\Components\TeacherCoordinator\EachFolderFilesComponent;
use App\View\Components\TeacherCoordinator\LibraryComponent;
use App\View\Components\TeacherCoordinator\ScheduleChangesComponent;
use App\View\Components\TeacherCoordinator\ScheduleComponent;
use App\View\Components\TeacherCoordinator\SharedLibraryAjaxPaginateComponent;
use App\View\Components\TeacherCoordinator\TeacherComponent;
use App\View\Components\TeacherCoordinator\UpdatesComponent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index()
    {
        return view('front.teacher-coordinator.dashboard');
    }

    public function getComponent(Request $request, $locale)
    {
        try {
            $page = $request->page;

            switch ($page) {
                case 'teacher': {

                        $Model = User::select('id', 'name', 'email', 'user_type',)->where('id', auth()->id())->with(['Teacher' => function ($query) {
                            $query->select('id', 'name', 'email', 'coordinated_by');
                        }])->first();
                        $view = new TeacherComponent($Model);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'schedule': {

                    $Model = User::select('id', 'name', 'email', 'user_type',)->where('id', auth()->id())->with(['teacher' => function ($query) {
                        $query->select('id', 'name', 'email', 'coordinated_by');
                    }, 'teacher.weekly_classes' => function ($query) {
                        $query->Has('Student');
                        $query->whereDate('class_time', '>', Carbon::now()->subMonth());
                    }, 'teacher.weekly_classes.Student' => function ($query) {
                        $query->select('id', 'name',  'teacher_id', 'user_id', 'course_id');
                    }])->first();
                        $view = new ScheduleComponent($Model);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'library': {

                        $view = new LibraryComponent();
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'schedule_changes': {
                        $Model = User::select('id', 'name',)->whereId(4)->with([
                            'Reschedule_Requests.Student' => function ($query) {
                                $query->select('id', 'name', 'course_id', 'user_id');
                            },
                            'Reschedule_Requests.Student.course' => function ($query) {
                                $query->select('id', 'title');
                            },
                            'Reschedule_Requests.Student.user' => function ($query) {
                                $query->select('id', 'name');
                            },
                            'Reschedule_Requests.Teacher' => function ($query) {
                                $query->select('id', 'name',);
                            },
                        ])->first();

                        $view = new ScheduleChangesComponent($Model);
                        $view = $view->resolveView()->with($view->data())->render();
                        break;
                    }
                case 'updates': {
                       
                        $view = new UpdatesComponent();
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
    public function chat()
    {
        return view('front.teacher-coordinator.chat');
    }
    public function ajaxpaginatesharedlibrary(Request $request)
    {
        try {
            if ($request->ajax()) {
                $Model = User::find(auth()->id())->MyFolders()->paginate(12);
                $view = new SharedLibraryAjaxPaginateComponent($Model);
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {   //  
            return JsonResponseService::getJsonException($e);
        }
    }

    public function GetFolderFiles(GetFilesOfFolderRequest $request)
    {
        try {
            if ($request->ajax()) {
                $Model = SharedLibrary::query()->whereId($request->folder_id)->with('files');  // we will use that query inside 

                // $Model =LibraryFile::query()->whereSharedLibraryId($request->folder_id);  // we will use that query inside 
                $view = new EachFolderFilesComponent($Model);
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {   //  
            return JsonResponseService::getJsonException($e);
        }
    }
}
