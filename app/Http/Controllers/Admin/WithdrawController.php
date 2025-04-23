<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WithdrawMail;
use App\Models\User;
use App\Models\withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WithdrawController extends Controller
{
    //
    public function withdraw(Request $request){
        
        $data = $request->all();


        if($request->isMethod('POST')){
            $currentwithdraw = withdraw::where('id',$data['withdrawid'])->first()->toArray();
            $currentuser = User::where('id',$currentwithdraw['user_id'])->first()->toArray();

            //if approved is clicked
            if($data['action'] == "approve"){
                //step 1 update withdraw status to 1
                $withdrawUpdated = withdraw::where('id',$data['withdrawid'])->update(['withdraw_status'=> '1']);
              
                // $newbalance = $currentuser['balance'] - $currentwithdraw['amount'];
    
                // $updated = User::where('id', $currentuser['id'])->update(['balance'=> $newbalance]);
               

                //email withdraw user approval
                $mailData = [
                    'title' => 'Withdrawal Approved',
                    'body' => '<p>Your Withdrawal of $'.$currentwithdraw['amount'].' to the '.$currentwithdraw['gateway'].' wallet  <strong>'.$currentwithdraw['userwallet_id'].'</strong> has been approved and payment sent to wallet specified</p>
                    ',
                    'username'=> $currentuser['username']
                ];
                Mail::to($currentuser['email'])->send(new WithdrawMail($mailData));

                return redirect()->back()->with('withdraw_message', 'Your have successfully approved the withdrawal ');

            }elseif($data['action'] == "decline") {
                //step 1 update withdraw status to 3
                $withdrawUpdated = withdraw::where('id',$data['withdrawid'])->update(['withdraw_status'=> '3']);


                $newbalance = floatval($currentuser['balance']) + floatval($currentwithdraw['amount']);
    
                $updated = User::where('id', $currentuser['id'])->update(['balance'=> strval($newbalance)]);

                return redirect()->back()->with('deposit_message', 'Your have successfully declined the withdraw');
            }
        }
          
        $withdraws = DB::table('withdraws')
            ->join('users', 'withdraws.user_id', '=', 'users.id')
            ->select('users.*', 'withdraws.*')->orderBy('withdraws.id','desc')->paginate(50);
        return view('admin.withdraw')->with(compact('withdraws'));
    }
}
