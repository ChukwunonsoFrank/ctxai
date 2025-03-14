<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as Session;

class LogoutController extends Controller
{
    //
    //
    
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('user/login');
    }

    public function appperform()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('user/applogin');
    }
}
