<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Localize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestLocale = $request->segment(1);
        if (!in_array($requestLocale,config("app.locales"))) {
            if (Auth::check()) { // first check if there is a logged in user

                $userLanguage = Auth::user()->language; // get user language

                if (!empty($userLanguage)) {
                    app()->setLocale($userLanguage);
                }
            } else
                app()->setLocale($request->getPreferredLanguage(config('app.locales')));
        }

        return $next($request);
    }
}