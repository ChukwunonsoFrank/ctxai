<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredepositRequest;
use App\Http\Requests\UpdatedepositRequest;
use App\Models\deposit;
use App\Models\Coins;
use Illuminate\Http\Request;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;


class DepositController extends Controller
{

    public function deposit(Request $request)
    {
        $data = $request->all();

        if ($request->isMethod('POST')) {
            $datecreated =  date("d-m-Y");
            $depositdetails = [
                'userid' => Session::get('user')->id,
                'gateway' => $data['wallet'],
                'amount' => $data['amount'],
                'deposit_status' => 0,
            ];

            $deposited = deposits::create($depositdetails);

            if ($deposited) {
                //mail user 
                //email subscription user
                $mailData = [
                    'title' => 'Deposit Request',
                    'body' => '<p>Your Deposit of $' . $data['amount'] . 'has been recieved and will be confirmed shortly</p>
                    <p><strong>Note</strong></p>
                    <ul>
                        <li>Make sure you have sent the said amount to the wallet provided in the dashboard</li>
                        <li>Wait to confirm your deposit has been confirmed in the block chain</li>
                    </ul>
                    <a href="#" style="background-color: teal; color: white;padding-top: 5px ;
                    padding-bottom: 5px ;
                    padding-left: 10px ;
                    padding-right: 10px ; text-decoration: none; margin: auto;"> Login </a>',
                    'username' => Session::get('user')->username
                ];
                Mail::to(Session::get('user')->email)->send(new DepositMail($mailData));

                //email admin
                $mailData = [
                    'title' => 'New Deposit Request',
                    'body' => '<p>A New User just Deposited  $' . $data['amount'] . ' </p>
                    
                    <a href="#" style="background-color: teal; color: white;padding-top: 5px ;
                    padding-bottom: 5px ;
                    padding-left: 10px ;
                    padding-right: 10px ; text-decoration: none; margin: auto;"> Login </a>',
                    'username' => "Admin"
                ];
                Mail::to('Justintristan230@gmail.com')->send(new DepositMail($mailData));
                return view('user.deposit')->with('deposit_success', 'Deposit has been made successfully');
            }
            //check if current password entered is correct

        }


        return view('user.subscribe')->with(compact('investmentplans', 'wallets'));
    }

    public function deposits()
    {
        $deposits = deposit::where('user_id', Session::get('user')->id)->orderBy('id', 'desc')->get()->toArray();
        return view('user.deposit')->with(compact('deposits'));
    }

    public function getwallet(Request $request)
    {

        $data = $request->all();

        if ($wallet = Coins::where('coin_name', $data['wallet'])->first()->toArray()) {
            return $wallet;
            // return Response::json($wallet);
        }
    }
}
