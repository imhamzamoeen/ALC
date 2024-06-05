<?php

namespace App\Http\Controllers\Admin;

use App\Classes\AlQuranConfig;
use App\Classes\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\NotifyCustomerOnManualRegistration;
use App\Repository\CourseRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\RefundRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsersController extends Controller
{
    protected $userRepository;

    protected $module_title;
    protected $module_slug;
    protected $module_model;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->module_title = 'Users';
        $this->module_slug = 'users';
        $this->module_model = new User();

        $this->userRepository = $userRepository;
    }

    private function SetRepo()
    {
        /* this function is created so that use type tc and customer support can see only their supported user typed people */
        $this->userRepository->scopeRoleUser();
    }



    public function index(Request $request)
    {
        $this->SetRepo();
        $where = getFilters($request);
        $users = $this->userRepository->simplePaginate($where);
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'list';
        return view('admin.users.list', compact('users', 'module_title', 'module_slug', 'module_action'));
    }
    public function view()
    {

        return view('admin.users.view');
    }
    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name'      => 'required|string|max:64',
            'email'     => 'required|email|string|unique:users,email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'phone'     => 'required|string|max:20',
            'password'  => 'required|min:6|max:20|string|confirmed',
            'status'    => 'required|string',
            'user_type' => 'required|string'
        ]);

        if ($request->should_verify == '1') {
            $request->request->add(['email_verified_at' =>  Carbon::now()]); //add request
            // $request->email_verified_at  = Carbon::now();
        }

        $input = $request->except('_token', 'password_confirmation', 'should_verify', 'notify_user');
        $input['password'] = Hash::make($input['password']);
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create($input);
            if ($user) {
                $user->assignRole($input['user_type']);
                if ($request->notify_user == '1') {
                    $user->notify(new NotifyCustomerOnManualRegistration($user, $request->password));
                }
                if (!$request->has('should_verify')) {           //if request does not have should verify it means it is verified email address
                    event(new Registered($user));
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Oops! Some error occurred!');
        }
        return redirect()->route('admin' . '.users.list')->with('success', 'User has been added successfully.');
    }

    public function edit($id)
    {
        $this->SetRepo();

        $user = $this->userRepository->findOrFail($id);
        //dd($user);
        return view('admin.users.edit', compact('user', 'id'));
    }

    public function update(Request $request)
    {

        $this->SetRepo();   // because user type tc and customer support are only allowed to change teacher and customers respectivley

        $request->validate([
            'name'      => 'required|string|max:50',
            'phone'     => 'required|string|max:20',
            'status'    => 'required|string',
            'user_type' => 'required|string'
        ]);
        if (!empty($request->password)) {
            $request->validate([
                'password'  => 'min:6|max:20|string|confirmed',
            ]);
        }
        //dd($request->all());
        $input = $request->except('_token', 'user_id', 'password', 'email', 'password_confirmation', 'should_verify', 'notify_user');
        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        }

        try {
            DB::beginTransaction();
            $this->userRepository->update(['id' => $request->user_id], $input);
            $user = $this->userRepository->findById($request->user_id);
            if ($user) {
                $user->roles()->detach();
                $user->assignRole($input['user_type']);
                if ($request->notify_user == '1') {
                    $user->notify(new NotifyCustomerOnManualRegistration($user, !empty($request->password) ? $request->password : '', true));
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return back()->with('error', 'Oops! Some error occurred!');
        }
        return redirect()->route('admin' . '.users.list')->with('success', 'User has been added successfully.');
    }

    public function destroy($id)
    {
        if (!empty($id)) {
            $this->SetRepo();

            $action = $this->userRepository->deleteBy(['id' => $id]);

            if ($action) {
                return redirect()->back()->with('success', 'User has been deleted.');
            } else {
                return redirect()->back()->with('warning', 'Sorry! This record is locked.');
            }
        }
        return redirect()->back();
    }

    public function bulkAction(Request $request)
    {

        $this->SetRepo();

        $action = $request->action;
        $ids = $request->ids;
        switch ($action) {
            case 'delete':
                if (count($ids)) {
                    $response = $this->userRepository->deleteBy([['id', 'IN', $ids], ['is_locked', '=', 0]]);
                    if ($response) {
                        return redirect()->back()->with('success', 'Selected ' . $this->module_title . ' has been deleted.');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong!');
                    }
                }
                break;
            default: {
                    return redirect()->back();
                }
        }
        return redirect()->back();
    }

    public function details(CourseRepositoryInterface $courseRepository, User $user)
    {
        $this->SetRepo();

        //dd($user->library);
        $courses = null;
        if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher)) {
            $user = $user->load('courses');
            $courses = $courseRepository->activeCourses();
        }
        $user->load('profiles')->load('refund');
       
        return view('admin.users.profile.index', compact('user', 'courses'));
    }

    public function refundPayment(RefundRepository $repository,Request $request)
    {
        try {
           
           $refund = $repository->refund($request);       
           if($refund == "success"){
            return redirect()->back()->with("success","Refund payment !");
           } else{
            return back()->with('error', ' Refund amount is greater than charge amount');
           }   
           
        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong.' . $e );
        }
    }

    //get Student Price
    public function getStudentPrice(Request $request)
    {
        try {            
            $price = Subscription::where('student_id','=',$request->student_id)->select('price')->first();        
            return response()->json(['success'=>true,'price'=>$price->price]);
        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong.' . $e );
        }
    }
}
