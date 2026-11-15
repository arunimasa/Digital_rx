<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $password = Hash::make('password');

        DB::table('users')->insert([
            'name' => 'Admin', 'email' => 'admin@rx.test', 'password' => $password,
            'role' => 'admin', 'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('users')->insert([
            'name' => 'Doctor', 'email' => 'doctor@rx.test', 'password' => $password,
            'role' => 'doctor', 'degrees' => 'MBBS, FCPS', 'bmdc_no' => 'A-12345',
            'chamber' => 'Test Chamber, Dhaka', 'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('users')->insert([
            'name' => 'Test Assistant', 'email' => 'assistant@rx.test', 'password' => $password,
            'role' => 'assistant', 'created_at' => $now, 'updated_at' => $now,
        ]);
    }
}