<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminRecords = [
            [
                'id'=> 1, 
                'name'=>'Nxcai admin', 
                'type'=>'admin',
                'vendor_id'=>'0',
                'mobile'=>'8373839383', 
                'email'=>'test@test.com', 
                'password'=> Hash::make('12345678'),
                'image'=>'',
                'status'=>1 
            ]
        ];
        admin::insert($adminRecords);
    }
}
