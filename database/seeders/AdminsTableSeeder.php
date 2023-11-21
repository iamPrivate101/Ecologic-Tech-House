<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwod = Hash::make('123456');
        $adminRecords = [
            ['id'=>2,'name'=>'Anjali Mali','type'=>'subadmin','mobile'=>9841602262,'email'=>'anjali@admin.com',
            'password'=>$passwod,'image'=>'','status'=>1],
            ['id'=>3,'name'=>'Reemas Maharjan','type'=>'subadmin','mobile'=>9813356663,'email'=>'reemas@admin.com',
            'password'=>$passwod,'image'=>'','status'=>1],
            ['id'=>4,'name'=>'Jhon Maharjan','type'=>'subadmin','mobile'=>9813356663,'email'=>'jhon@admin.com',
            'password'=>$passwod,'image'=>'','status'=>1],
        ];
        Admin::insert($adminRecords);
    }
}
