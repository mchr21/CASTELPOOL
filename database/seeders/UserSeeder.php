<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Maribel',
            'phone'=>'75787576',
            'email'=>'d@gmail.com',
            'profile'=>'ADMIN',
            'status'=>'ACTIVE',
            'password'=>bcrypt('123')  
        ]);
        User::create([
            'name'=>'Ana',
            'phone'=>'2387576',
            'email'=>'ana@gmail.com',
            'profile'=>'EMPLOYEE',
            'status'=>'ACTIVE',
            'password'=>bcrypt('123')  
        ]);
        
    }
}
