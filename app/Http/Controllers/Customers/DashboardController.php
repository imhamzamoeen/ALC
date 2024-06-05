<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index(){
       $user = auth()->user();
     
       /*REDIRECTION FOR MVP-1*/
        // return redirect()->route('admin'.'.console', app()->getLocale());
        session()->forget('customer_pin');
        $profiles = $user->profiles;


       if(!$profiles->count() && is_null($user->customer_pin)){
           return redirect()->route($user->user_type.'.console', ['locale' => app()->getLocale()]);
       }

        return view('front.'.$user->user_type.'.dashboard', compact('user', 'profiles'));
    }
    public function home(){
        return view('front.customer.student.home');
    }
    public function vacations(){
        return view('front.customer.student.vacations');
    }

    public function vacationRequest(){
        return view('front.customer.components.vacation_request');
    }

    public function completeRegistration(){
        return view('auth.complete-registration');
    }

    public function submitDetails(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'phone' => ['required', 'string'],
        ]);

        $user = auth()->user();

        $user->update($data);

        return redirect()->route('customer.dashboard', app()->getLocale());
    }
}
