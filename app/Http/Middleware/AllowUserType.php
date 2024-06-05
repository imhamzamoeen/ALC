<?php

namespace App\Http\Middleware;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Barryvdh\Debugbar\Twig\Extension\Dump;
use Closure;

use Illuminate\Http\Request;

class AllowUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $user_type1 = 'admin', $user_type2 = 'admin', $user_type3 = 'admin')
    {
      
        if (auth()->user()->hasanyRole([UserTypesEnum::Admin,UserTypesEnum::TC,UserTypesEnum::CustomerSupport])) {
            /* if the user has has these user type then check for permissions else let him go */
            $uri = $request->getRequestUri();     // url kia h domain k bad
            $module = $request->segment(2);   // which page like dashboard or what 


            $action = !empty($request->segment(3)) ? $request->segment(3) : 'view';

            $permission = generate_permission_slug($module, $action);
            // it will be like view-dashboard {{ permission - module }}
            // dd($permission);
            if($request->user()->can($permission)){
            return $next($request);
            }else{
                 abort(403);
             }
            // return $next($request);

            // return $next($request);

        } elseif ($user_type1==$request->user()->user_type) {
            /* we are sending  a parameter to middleware incase of teacher its usertype=teacher so if customer is logged in he cant go teachers pages etc */
            return $next($request);
        } else {
            abort(403);
        }
    }
}
