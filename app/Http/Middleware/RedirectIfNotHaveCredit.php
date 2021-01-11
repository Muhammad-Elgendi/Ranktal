<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotHaveCredit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$monthly_attr, $daily_attr = null){
        if (Auth::check()) { // first check if there is a logged in user

            $user = Auth::user(); // get user usage

            // if exceed plan limits
            if(isset($daily_attr)){
                if($user->available_credit($monthly_attr) <= 0 || $user->available_credit($daily_attr) <= 0){
                    // restrict user access
                    return redirect('/dashboard/plans')->withErrors([__('exceed-msg')]);
                }
            }else{
                if( $user->available_credit($monthly_attr) <= 0 ){
                    // restrict user access
                    return redirect('/dashboard/plans')->withErrors([ __('exceed-msg')]);
                }
            }            

            // if subscribtion finished
            if($user->subscribed_until->addDays(3) <= Carbon::now()){
                // restrict user access
                return redirect('/dashboard/plans')->withErrors([ __('subscription-end')]);
            }
        }
        return $next($request);
    }
}
