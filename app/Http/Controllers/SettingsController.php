<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // View user's settings
    public function view(){
        return view('settings');
    }

    // Edit user's settings
    public function edit(Request $request){

        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|string|max:255',      
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'company' => 'string|max:255|nullable'
        ]);

        $data = $request->all();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->language = $data['lang'];
        $user->company = $data['company'];
        $user->save();

        // check if user want to update their image
        if ($request->hasFile('image')) {
            return $this->updateImg($request);
        }   

        // check if user want to update their password
        if ($request->__isset('old_password') && $request->__isset('new_password') && $request->__isset('confirm_password')) {
            return $this->updatePassword($request);
        }
   
        return back()->with('success',__('success-profile'));
    }

    public function updateImg(Request $request) {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img/users');
            $image->move($destinationPath, $name);

            // save user's image in his record
            $user = Auth::user();
            $user->image = $name;
            $user->save();

            return back()->with('success',__('success-img'));
        }
    }

    public function updatePassword(Request $request){
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6|different:old_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        $data = $request->all();

        if(!Hash::check($data['old_password'], Auth::user()->password)){

            return back()->with('error',__('error-password'));

        }   
        else{         
           // Change Password
            $user = Auth::user();
            $user->password = bcrypt($data['new_password']);
            $user->save();

            return back()->with('success',__('success-password'));
        }
    }
}
