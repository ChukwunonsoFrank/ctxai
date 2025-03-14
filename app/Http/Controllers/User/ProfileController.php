<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    
    public function profile(Request $request){
        $data = $request->all();
        

        
        if($request->isMethod('POST')){
            $user = DB::table('users')
        ->select('users.*')
        ->where('users.id',Auth::User()->id)
        ->get()->toArray();
        $user = head($user);
           if($data['action'] == "profile"){
            //if profile do this
           }elseif($data['action'] == "password"){
                if(Hash::check($data['current_password'],$user->password)){
                    if($data['new_password'] == $data['confirm_password']){
                        User::where('id',Auth::User()->id)->update(['password'=> bcrypt($data['new_password'])]);
                        return redirect()->back()->with('success_message', 'password updated successfully');
                    }else{
                         return redirect()->back()->with('error_message', 'Password do not match');
                    }
                }else{
                    return redirect()->back()->with('error_message', 'Your current password is incorrect!');
                }
           }
        }

        
       
        return view('user.profile')->with(compact('profile'));
    }

    public function checkUserPassword(Request $request){
        $data = $request->all();

        $user = DB::table('users')
        ->select('users.*')
        ->where('users.id',Auth::User()->id)
        ->get()->toArray();
        $user = head($user);
        
        if(Hash::check($data['current_password'],$user->password)){
            return "true";
        }else{
            return "false";
        }
    }
}
