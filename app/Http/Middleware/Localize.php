<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Localize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $requestLocale = $request->segment(1);
        if (in_array($requestLocale,config("app.locales"))) {
            if (Auth::check()) { // first check if there is a logged in user

                $userLanguage = Auth::user()->language; // get user language

                if (!empty($userLanguage)) {
                    app()->setLocale($userLanguage);
                }
            }
            else if(!empty($requestLocale)){
                // set localization to the requested one
                app()->setLocale($requestLocale);                
            }
            else{
                /**
                * Get the browser local code and lang code.
                */
                app()->setLocale($request->getPreferredLanguage(config('app.locales')));
            }             
        }
        return $next($request);
    }
}