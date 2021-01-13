<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    // Register new users with trial period (In days)
    public $trial_period = 7;
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'company' => 'string|max:255|nullable',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'subscribed_until' => Carbon::now()->addDays($this->trial_period)
        ]);
        
        $trial_limits = '{
            "optimizations_monthly": 30,
            "audits_monthly": 30,
            "crawl_monthly": 30,
            "campaigns_monthly": 3
        }';        
        $user->limits = json_decode($trial_limits, true);

        $init_usage = '{
            "optimizations_monthly": 0,
            "audits_monthly": 0,
            "crawl_monthly": 0,
            "campaigns_monthly": 0
        }';
        $user->usage =  json_decode($init_usage, true);

        $user->save();
        return $user;
    }

    // override the redirectTo property value
    public function redirectTo()
    {
        return app()->getLocale() . '/dashboard';
    }
}
