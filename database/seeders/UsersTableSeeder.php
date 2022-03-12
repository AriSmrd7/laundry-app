<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Tona',
            'email' => 'tona@gmail.com',
            'password' => bcrypt('admin'),
        ]);    
        
        DB::table('users')->insert([
            'name' => 'Fitri',
            'email' => 'fitri@gmail.com',
            'password' => bcrypt('kasir'),
        ]);    

        DB::table('users')->insert([
            'name' => 'Fery',
            'email' => 'fery@gmail.com',
            'password' => bcrypt('kasir'),
        ]);    
    }
}
