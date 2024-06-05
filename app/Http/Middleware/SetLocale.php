<?php

namespace App\Http\Middleware;

use App\Classes\AlQuranConfig;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetLocale
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
        $locale = \session('locale', AlQuranConfig::DefaultLocale);
       // dd($locale);
        if (! array_key_exists($locale, AlQuranConfig::Locales)) {
            return redirect()->route('home', app()->getLocale());
        }else{
            app()->setLocale($locale);
            return $next($request);
        }

    }
}
