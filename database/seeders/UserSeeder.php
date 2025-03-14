<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //
        $userRecords = [
            [
                'id'=> 1, 
                'name'=>'test user', 
                'email'=>'testuser@yahoo.com', 
                'username'=>'username', 
                'balance'=>'0', 
                'demo_balance'=>'10,000', 
                'withdraw_balance'=>'0', 
                'password'=> Hash::make('testuser'),
                'status'=>'0', 
                'refcode'=>'sdfs', 
                'referral_code'=>'0', 
                'refearned'=>'0', 
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]
        ];
        User::insert($userRecords);
    }
}
