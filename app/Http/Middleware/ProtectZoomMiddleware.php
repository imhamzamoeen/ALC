<?php

namespace App\Http\Middleware;

use App\Helpers\ZoomClassMiddlewareHelper;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use Closure;
use Illuminate\Http\Request;

class ProtectZoomMiddleware extends ZoomClassMiddlewareHelper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        $user = ($request->route()->parameter('user'));
        $current_user = user::find(auth()->id());

        self::CheckTime($request->route()->parameter('WeeklyClass')->class_time, $current_user->timezone);
        self::CheckRelation($current_user, $request->route()->parameter('WeeklyClass'));
        $model=self::GetModel($current_user,$user);

        $request->request->add(['user' => $model]);
   
        return $next($request);
    }
}
