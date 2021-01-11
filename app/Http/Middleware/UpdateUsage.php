<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Closure;

class UpdateUsage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   string $monthly_attr : monthly-usage-attribute-name of the tool
     * @param   string $daily_attr   : daily-usage-attribute-name of the tool
     * @return mixed
     */
    public function handle($request, Closure $next, $monthly_attr, $daily_attr = null)
    {
        if (Auth::check()) { // first check if there is a logged in user

            $user = Auth::user(); // get user usage

            $user->forceFill([
                'usage->'.$monthly_attr => $user->usage->$monthly_attr + 1
            ])->save();

            if(isset($daily_attr)){
                $user->forceFill([
                    'usage->'.$daily_attr => $user->usage->$daily_attr + 1
                ])->save();    
            }
        }
        return $next($request);
    }
}
