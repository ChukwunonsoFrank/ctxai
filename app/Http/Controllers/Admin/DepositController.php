<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\deposit;
use App\Models\investments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\DepositapprovalMail;

class DepositController extends Controller
{
    //
    //
    public function deposit(Request $request){
        
        $data = $request->all();

        if($request->isMethod('POST')){
            //arranging data
            $refUser = '';

            $currentuser = User::where('id',$data['user_id'])->first()->toArray();

            $referExists = User::where('refcode',$currentuser['referral_code'])->exists();
            if($referExists){
                $refuser = User::where('refcode',$currentuser['referral_code'])->first()->toArray();
            }
            //if approved is clicked
            if($data['action'] == "approve"){
                //step 1 update deposit status to 1
                $depositUpdated = deposit::where('id',$data['depositid'])->update(['deposit_status'=> '1']);


                //update user balance
                $currentuser_balance = floatval($currentuser['balance']) + floatval($data['depositamount']);
                $userUpdated = User::where('id',$data['user_id'])->update(['balance'=> strval($currentuser_balance)]);

                 //email subscription user
                 $mailData = [
                    'subject' => 'Deposit Confirmed',
                    'body' => '<p>Your Deposit of $'.$data['depositamount'].' has been Approved</p>
                    <p><strong>You can now login to your dashboard to start trading on your live account</strong></p>
                    ',
                    'username'=> $currentuser['username']
                ];
                Mail::to($currentuser['email'])->send(new DepositapprovalMail($mailData));

                //update and insert ref earnings
                if($referExists){
                    $refearnedamount = 0.05 * floatval($data['depositamount']);
                    $newrefuserbalance = floatval($refuser['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id',$refuser['id'])->update(['balance'=> strval($newrefuserbalance)]);

                    // Add deposit entry to justify ledger
                    $depositdetails = [
                        'user_id'=> $refuser['id'],
                        'gateway'=> 'ReferralBonus',
                        'amount'=> $refearnedamount,
                        'deposit_status'=> '1',
                    ];
                    $refBalanceUpdated = deposit::create($depositdetails);

                    if($refBalanceUpdated){
                        //email Referee
                        $mailData = [
                            'subject' => 'Referal Bonus',
                            'body' => '<p>You just earned $'.$refearnedamount.' from '.$currentuser['username'].'\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username'=> $refuser['username']
                        ];
                        Mail::to($refuser['email'])->send(new DepositapprovalMail($mailData));
                    }
                }
                return redirect()->back()->with('deposit_message', 'Your have successfully approved the deposit');

            }elseif($data['action'] == "decline"){
                //step 1 update deposit status to 1
                $depositUpdated = deposit::where('id',$data['depositid'])->update(['deposit_status'=> '3']);

                // //step 2 update investment status to 1
                // $investmentsUpdated = investments::where('id',$data['investmentid'])->update(['plan_status'=> 3]);

                return redirect()->back()->with('deposit_message', 'Your have successfully declined the deposit');
            }
        }
          
        $deposits = deposit::join('users', 'deposits.user_id', '=', 'users.id')
            ->select('users.*', 'deposits.*')->orderBy('deposits.id','desc')
            ->get();
        return view('admin.deposit')->with(compact('deposits'));
    }
}
