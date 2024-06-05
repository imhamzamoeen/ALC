<?php

namespace App\Http\Middleware;

use App\Classes\Enums\UserTypesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AllowOnlyCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $pin = session('customer_pin');

        if (!empty($user->social_type) && empty($user->phone)) {
            return redirect()->route('customer.completeRegistration', app()->getLocale());
        }

        if(!$user->pin_check){
            return $next($request);

        }

     

        if (empty($user->customer_pin)) {
            return $next($request);
        } else {
            if (!empty($pin)) {
                return $next($request);
            } elseif ($user->profiles->count() == 0) {
                return $next($request);

                //incase customer sets up a pin and dont add students then he cannot go to console page so for that this else if works.. 
            } else {
                
                abort('403');
            }
        }
    }
}
