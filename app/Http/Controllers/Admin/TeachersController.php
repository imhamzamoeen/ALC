<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\AvailabilityRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachersController extends Controller
{
    protected $userRepository;
    protected $availabilityRepository;
    public function __construct(UserRepositoryInterface $userRepository, AvailabilityRepositoryInterface $availabilityRepository)
    {
        $this->userRepository = $userRepository;
        $this->availabilityRepository = $availabilityRepository;
    }

    private function SetRepo()
    {
        /* this function is created so that use type tc and customer support can see only their supported user typed people */
        $this->userRepository->scopeRoleUser();
    }


    public function addAvailability(Request $request)
    {
        $this->SetRepo();
        $request->validate([
            'user_id'   => ['required'],
            'timezone'  => ['required', 'max:50', 'string', 'not_in:0'],
            'days.*'    => ['required'],
            'slots.*'   => ['required']
        ]);
        $data =  $request->all();

        try {
            DB::beginTransaction();
            $avaialability = $this->availabilityRepository->createOrUpdate($request->only('user_id', 'timezone'), $request->only('user_id'));
            User::find($request->user_id)->update([
                'timezone' => $request->timezone,
            ]);             // this updates the timezone in users table and the above query sets in availability model 


            /*Adding availability days*/
            $input = array();
            foreach ($data['days'] as $day) {
                $input[] = ['day_id' => $day];
            }
            $avaialability->days()->delete();
            $days = $avaialability->days()->createMany($input);

            foreach ($days as $day) {
                /*Adding timeslots against days*/
                $input = array();
                if (isset($data['slots'][$day->day_id])) {
                    foreach ($data['slots'][$day->day_id] as $slot) {
                        $input[] = ['slot_id' => $slot];
                    }

                    $day->slots()->delete();
                    $slots = $day->slots()->createMany($input);
                } else {
                    $day->delete();
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Operation Successfull');
        } catch (\Exception $e) {
            DB::rollback();
       

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    public function assignCourses(Request $request, User $user)
    {
            // return $request->all();
        // $this->SetRepo();

        $data = $request->validate([
            'courses' => ['required']
        ]);
        $arr=[];
        foreach($request->courses as $course){
            $arr[]=$course['course_id'];
        }
       
        try {
            DB::beginTransaction();


            $user->courses()->detach();
            // $user->courses()->delete();
        
            $user->courses()->attach($arr);

            DB::commit();
            return redirect()->back()->with('success', 'Courses assignment successfull');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            return redirect()->back()->with('error', 'Sorry! Something went wrong. Please try again');
        }
    }


    public function assignCoordinator(Request $request, User $user)
    {
        $data = $request->validate([
            'coordinator' => ['numeric']
        ]);

        try {
            DB::beginTransaction();

            $user->update(['coordinated_by' => $data['coordinator']]);

            DB::commit();
            return redirect()->back()->with('success', 'Coordinator assignment successfull');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sorry! Something went wrong. Please try again');
        }
    }

    public function assignLibrary(Request $request, User $user)
    {
        $data = $request->validate([
            'folder' => ['required']
        ]);
        //dd($data);
        try {
            DB::beginTransaction();

            $user->shareableLibraries()->delete();
            $user->shareableLibraries()->createMany($data['folder']);

            DB::commit();
            return redirect()->back()->with('success', 'Library assignment successfull');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sorry! Something went wrong. Please try again');
        }
    }
}
