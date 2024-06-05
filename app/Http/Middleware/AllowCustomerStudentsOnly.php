<?php

namespace App\Http\Middleware;

use App\Models\Student;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AllowCustomerStudentsOnly
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
        
         
        $id = $request->segment(4);
        if(is_numeric($id)){
            //$student = Student::find($id)->whereBelongsTo($request->user())->exists();
            $students = $request->user()->profiles->pluck('id')->toArray();
            if(in_array($id, $students)){
                return $next($request);
            }else{
                abort(403);
            }
        }else{
            return $next($request);
        }
    }
}
