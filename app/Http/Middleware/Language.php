<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App;
use Auth;

class Language
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
        // $settings =  settings();
        // if (Auth::guard('web')->check()) {
        //     Session::put('applocale',$settings['language']);
        // }else{
        //     if(session()->has('language')){
        //         Session::put('applocale',session('language'));
        //     }else{
        //         Session::put('applocale','en');
        //     }
        // }
        // if (Session::has('applocale') ) { App::setLocale(Session::get('applocale')); }
        return $next($request);
    }
}
