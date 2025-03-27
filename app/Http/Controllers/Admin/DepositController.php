<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\DepositapprovalMail;

class DepositController extends Controller
{
    public function deposit(Request $request)
    {
        $data = $request->all();
        $level = 0;
        $commissionPercentage = 0;
        $topUpline = "";
        $midUpline = "";
        $lastUpline = "";

        if ($request->isMethod('POST')) {
            $action = $data['action'];
            $userId = $data['user_id'];
            $depositAmount = $data['depositamount'];
            $depositId = $data['depositid'];

            if ($action !== "approve" && $action !== "decline") {
                return redirect()->back()->with('deposit_message', 'Invalid request action: ' . $action);
            }
    
            if (empty($userId) || $userId === "") {
                return redirect()->back()->with('deposit_message', 'Empty request userId');
            }
    
            if (empty($depositAmount) || $depositAmount === "") {
                return redirect()->back()->with('deposit_message', 'Empty request depositAmount');
            }
    
            if (empty($depositAmount) || $depositAmount === "") {
                return redirect()->back()->with('deposit_message', 'Empty request depositAmount');
            }
    
            if (empty($depositId) || $depositId === "") {
                return redirect()->back()->with('deposit_message', 'Empty request depositId');
            }

            $currentuser = User::where('id', intval($userId))->first();

            if ($currentuser === null) {
                return redirect()->back()->with('deposit_message', 'No user with the specified ID');
            }

            $currentuser = $currentuser->toArray();

            if (empty($currentuser)) {
                return redirect()->back()->with('deposit_message', 'No user with the specified ID');
            }

            if ($action === "approve") {
                $currentuser_balance = floatval($currentuser['balance']) + floatval($depositAmount);
                $depositUpdated = deposit::where('id', $depositId)->update(['deposit_status' => '1']);
                $userUpdated = User::where('id', $userId)->update(['balance' => strval($currentuser_balance)]);

                $mailData = [
                    'subject' => 'Deposit Confirmed',
                    'body' => '<p>Your Deposit of $' . $depositAmount . ' has been Approved</p>
                    <p><strong>You can now login to your dashboard to start trading on your live account</strong></p>
                    ',
                    'username' => $currentuser['username']
                ];

                Mail::to($currentuser['email'])->send(new DepositapprovalMail($mailData));

                /**
                 * REFERRAL LOGIC START
                 */

                $refearnedamount = 0;
                $newrefuserbalance = 0;

                $upline = User::where('refcode', $currentuser['referral_code'])->first();

                if ($upline !== null) {
                    $upline = $upline->toArray();
                    $topUpline = $upline;
                    $level += 1;
                    $commissionPercentage = 5;
                    $upline = User::where('refcode', $upline['referral_code'])->first();
                    if ($upline !== null) {
                        $midUpline = $topUpline;
                        $topUpline = $upline;
                        $level += 1;
                        $commissionPercentage = 2;
                        $upline = $upline->toArray();
                        $upline = User::where('refcode', $upline['referral_code'])->first();
                        if ($upline !== null) {
                            $lastUpline = $midUpline;
                            $midUpline = $topUpline;
                            $topUpline = $upline->toArray();
                            $level += 1;
                            $commissionPercentage = 1;
                        }
                    }
                }

                if ($level === 1) {
                    $refearnedamount = 0.05 * floatval($depositAmount);
                    $newrefuserbalance = floatval($topUpline['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id', $topUpline['id'])->update(['balance' => strval($newrefuserbalance)]);

                    deposit::create([
                        'user_id' => $topUpline['id'],
                        'gateway' => 'ReferralBonus',
                        'amount' => $refearnedamount,
                        'deposit_status' => '1',
                    ]);

                    if ($refBalanceUpdated) {
                        $mailData = [
                            'subject' => 'Referral Bonus',
                            'body' => '<p>You just earned $' . $refearnedamount . ' from ' . $currentuser['username'] . '\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username' => $topUpline['username']
                        ];

                        Mail::to($topUpline['email'])->send(new DepositapprovalMail($mailData));
                    }
                }

                if ($level === 2) {
                    $refearnedamount = 0.05 * floatval($depositAmount);
                    $newrefuserbalance = floatval($midUpline['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id', $midUpline['id'])->update(['balance' => strval($newrefuserbalance)]);

                    deposit::create([
                        'user_id' => $midUpline['id'],
                        'gateway' => 'ReferralBonus',
                        'amount' => $refearnedamount,
                        'deposit_status' => '1',
                    ]);

                    if ($refBalanceUpdated) {
                        $mailData = [
                            'subject' => 'Referral Bonus',
                            'body' => '<p>You just earned $' . $refearnedamount . ' from ' . $currentuser['username'] . '\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username' => $midUpline['username']
                        ];

                        Mail::to($midUpline['email'])->send(new DepositapprovalMail($mailData));
                    }

                    $refearnedamount = 0.02 * floatval($depositAmount);
                    $newrefuserbalance = floatval($topUpline['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id', $topUpline['id'])->update(['balance' => strval($newrefuserbalance)]);

                    deposit::create([
                        'user_id' => $topUpline['id'],
                        'gateway' => 'ReferralBonus',
                        'amount' => $refearnedamount,
                        'deposit_status' => '1',
                    ]);

                    if ($refBalanceUpdated) {
                        $mailData = [
                            'subject' => 'Referral Bonus',
                            'body' => '<p>You just earned $' . $refearnedamount . ' from ' . $currentuser['username'] . '\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username' => $topUpline['username']
                        ];

                        Mail::to($topUpline['email'])->send(new DepositapprovalMail($mailData));
                    }
                }

                if ($level === 3) {
                    // Top upline gets 1%
                    $refearnedamount = 0.01 * floatval($depositAmount);
                    $newrefuserbalance = floatval($topUpline['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id', $topUpline['id'])->update(['balance' => strval($newrefuserbalance)]);

                    deposit::create([
                        'user_id' => $topUpline['id'],
                        'gateway' => 'ReferralBonus',
                        'amount' => $refearnedamount,
                        'deposit_status' => '1',
                    ]);

                    if ($refBalanceUpdated) {
                        $mailData = [
                            'subject' => 'Referral Bonus',
                            'body' => '<p>You just earned $' . $refearnedamount . ' from ' . $currentuser['username'] . '\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username' => $topUpline['username']
                        ];

                        Mail::to($topUpline['email'])->send(new DepositapprovalMail($mailData));
                    }

                    // Mid upline gets 3%
                    $refearnedamount = 0.02 * floatval($depositAmount);
                    $newrefuserbalance = floatval($midUpline['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id', $midUpline['id'])->update(['balance' => strval($newrefuserbalance)]);

                    deposit::create([
                        'user_id' => $midUpline['id'],
                        'gateway' => 'ReferralBonus',
                        'amount' => $refearnedamount,
                        'deposit_status' => '1',
                    ]);

                    if ($refBalanceUpdated) {
                        $mailData = [
                            'subject' => 'Referral Bonus',
                            'body' => '<p>You just earned $' . $refearnedamount . ' from ' . $currentuser['username'] . '\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username' => $midUpline['username']
                        ];

                        Mail::to($midUpline['email'])->send(new DepositapprovalMail($mailData));
                    }

                    // Last upline gets 5%
                    $refearnedamount = 0.05 * floatval($depositAmount);
                    $newrefuserbalance = floatval($lastUpline['balance']) + $refearnedamount;
                    $refBalanceUpdated = User::where('id', $lastUpline['id'])->update(['balance' => strval($newrefuserbalance)]);

                    deposit::create([
                        'user_id' => $lastUpline['id'],
                        'gateway' => 'ReferralBonus',
                        'amount' => $refearnedamount,
                        'deposit_status' => '1',
                    ]);

                    if ($refBalanceUpdated) {
                        $mailData = [
                            'subject' => 'Referral Bonus',
                            'body' => '<p>You just earned $' . $refearnedamount . ' from ' . $currentuser['username'] . '\'s deposit</p>
                            <p><strong>You can now login to your dashboard to view balance</strong></p>
                            ',
                            'username' => $lastUpline['username']
                        ];

                        Mail::to($lastUpline['email'])->send(new DepositapprovalMail($mailData));
                    }
                }

                return redirect()->back()->with('deposit_message', 'Your have successfully approved the deposit');
            } elseif ($action === "decline") {
                $depositUpdated = deposit::where('id', $depositId)->update(['deposit_status' => '3']);
                return redirect()->back()->with('deposit_message', 'Your have successfully declined the deposit');
            }
        }

        $deposits = deposit::join('users', 'deposits.user_id', '=', 'users.id')
            ->select('users.*', 'deposits.*')->orderBy('deposits.id', 'desc')
            ->get();
        return view('admin.deposit')->with(compact('deposits'));
    }
}
