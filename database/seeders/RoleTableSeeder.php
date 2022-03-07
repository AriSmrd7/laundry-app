<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'ROLE_ADMIN',
            'description' => 'Administrator',
        ]);    

        DB::table('roles')->insert([
            'name' => 'ROLE_KASIR',
            'description' => 'Kasir',
        ]);      
     }
}
