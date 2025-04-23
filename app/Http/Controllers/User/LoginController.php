<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function show()
    {
        return view('home.login')->with('link','login');
    }

    public function appshow()
    {
        if(!Cookie::has('device')){
            $cookie =  Cookie::queue(Cookie::forever('device', 'app'));
        }
        
        return view('home.appindex')->with('link','login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        $recaptcha = $request->input('g-recaptcha-response');

        if (is_null($recaptcha)) {
            $request->session()->flash('login_error', "Please confirm you are not a robot.");
            return redirect()->back();
        }

        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha
        ]);

        $result = $response->json();

        if ($response->successful() && $result['success'] == true) {
            if(!Auth::validate($credentials)){
                return redirect()->to('user/login')->withErrors(['msg' => 'Email or Password Incorrect']);
            }
    
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
    
            Auth::login($user);
    
            $user = Auth::User();
            Session::put('user', $user);
    
            //account selector session 
            //demo and live
            Session::put('account_type', 'demo');
            Session::put('account_balance', $user->demo_balance);
            Session::put('not_account_balance', $user->balance);
                    
            return $this->authenticated($request, $user);
        } else {
            $request->session()->flash('login_error', "Please confirm you are not a robot.");
            return redirect()->back();
        }      
    }

    public function applogin(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)){
            return redirect()->to('user/applogin')->withErrors(['msg' => 'Email or Password Incorrect']);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        $user = Auth::User();
        Session::put('user', $user);

        //account selector session 
        //demo and live
        Session::put('account_type', 'demo');
        Session::put('account_balance', $user->demo_balance);
        Session::put('not_account_balance', $user->balance);
        Session::put('device', 'app');
        
        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('user/dashboard')->with('login_success','Login was successful');
    }
}
