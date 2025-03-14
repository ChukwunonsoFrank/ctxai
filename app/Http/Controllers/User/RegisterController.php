<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\DemoMail;
use App\Mail\RegistrationMail;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    //

    /**
     * Display register page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $ref = null)
    {
        return view('home.signup')->with(compact('ref'))->with('link', 'register');
    }

    public function appshow(Request $request, $ref = null)
    {
        return view('home.appindex')->with(compact('ref'))->with('link', 'register');
    }

    /**
     * Handle account registration request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $datecreated =  date("d-m-Y");
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $userrefcode = substr(str_shuffle($permitted_chars), 0, 5);

        if ($request->validated()) {
            $validated = $request->validated();
            $validated['status'] = 1;
            $validated['balance'] = 0;
            $validated['withdraw_balance'] = 0;
            $validated['demo_balance'] = 10000;
            $validated['refcode'] = $userrefcode;
            $validated['refearned'] = 0;
        }

        //checking Ref user
        //get refferer code from signup form and give in users table to see if any user had that particular referal code
        $referExists = User::where('refcode', $data['referer'])->exists();

        //if a user has the code the assign that to value to the inserted for the current user registering
        if ($referExists) {
            $validated['referral_code'] = $data['referer'];
            //get the details of the referrer and parse it to $refuser
            $refuser = User::where('refcode', $data['referer'])->first()->toArray();
        } else {
            //if no user has that refcode from the form the assign null to referral code to be inserted for new user
            $validated['referral_code'] = "null";
        }

        $recaptcha = $request->input('g-recaptcha-response');

        if (is_null($recaptcha)) {
            $request->session()->flash('message', "  Please confirm you are not a robot ");
            return redirect()->back();
        }

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $params = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha,
            'remoteip' => IpUtils::anonymize($request->ip())
        ];

        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha
        ]);

        $result = $response->json();

        if ($response->successful() && $result['success'] == true) {
            $user = User::create($validated);
            $lastid = User::all()->last()->id;

            $Profiledetails = [
                'users_id' => $lastid,
                'created' => $datecreated
            ];

            //insert into profile table with just user id and created
            $invested = Profile::create($Profiledetails);

            if ($user && $invested) {
                //email registered user
                $mailData = [
                    'title' => 'Welcome To Nxcai',
                    'username' => $data['username'],
                    'body' => '
                <p>Your registration was successful and you can now login and  start trading to earn profits</p>
                <p><strong>Follow these simple steps to start earning on Nxcai</strong></p>
                <ul>
                    <li>Try out our ai trading robot using the demo account</li>
                    <li>Deposit into your Live account and start trading real assets</li>
                    <li>Withdraw earnings after the end of robot cycle</li>
                </ul>',
                ];
                Mail::to($data['email'])->send(new RegistrationMail($mailData));

                //email Admin
                $mailData = [
                    'title' => 'New User Registration',
                    'email' => $data['email'],
                    'body' => '<p>' . $data['email'] . ' just signed up to Nxcai</p>
                <p><strong>Login to admin to follow up with user</strong></p>
                ',
                    'username' => 'Admin'
                ];
                Mail::to(env('ADMIN_EMAIL'))->send(new RegistrationMail($mailData));

                //mailing refered user
                if ($referExists) {
                    $mailData = [
                        'title' => 'You Refered Someone',
                        'body' => '<p>' . $data['email'] . ' just signed up to Nxcai with your referral link</p>
                        
                        <p><strong>You will get a referal commision of 5% of their deposits , which means any time they make a deposit you get a 5% commision</strong></p>
                        ',
                        'username' => $refuser['name']
                    ];
                    Mail::to($refuser['email'])->send(new RegistrationMail($mailData));
                }
            }
            auth()->login($user);

            $user = Auth::User();
            Session::put('user', $user);

            //account selector session 
            //demo and live
            Session::put('account_type', 'demo');
            Session::put('account_balance', $user->demo_balance);
            return redirect('/user/dashboard')->with('signup_success', "Account successfully registered.");
        } else {
            $request->session()->flash('message', "  Please confirm you are not a robot ");
            return redirect()->back();
        }
    }
}
