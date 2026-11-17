<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Default password comes from .env (SEED_DEFAULT_PASSWORD). CHANGE IT after first login.
        $password = Hash::make(env('SEED_DEFAULT_PASSWORD', 'changeme@123'));

        $users = [
            [
                'name'  => 'System Admin',
                'email' => 'admin@example.com',
                'role'  => 'admin',
                'mobile' => '01700000001',
            ],
            [
                'name'  => 'Dr. Sample Doctor',
                'email' => 'doctor@example.com',
                'role'  => 'doctor',
                'mobile' => '01700000002',
            ],
            [
                'name'  => 'Sample Assistant',
                'email' => 'assistant@example.com',
                'role'  => 'assistant',
                'mobile' => '01700000003',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                $user + [
                    'password'           => $password,
                    'preferred_language' => 'bn',
                    'is_active'          => true,
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ]
            );
        }

        // Doctor profile (placeholder data, edit from the Doctor Profile screen)
        $doctorId = DB::table('users')->where('email', 'doctor@example.com')->value('id');

        DB::table('doctor_profiles')->updateOrInsert(
            ['user_id' => $doctorId],
            [
                'name_en'           => 'Dr. Sample Doctor',
                'name_bn'           => 'ডাঃ স্যাম্পল ডাক্তার',
                'degrees'           => 'MBBS (DMC), FCPS (Medicine)',
                'specialty'         => 'Medicine Specialist',
                'bmdc_no'           => 'A-00000',
                'chamber_name'      => 'Sample Chamber',
                'chamber_address'   => 'House 1, Road 1, Dhaka',
                'chamber_phone'     => '01700000002',
                'visiting_hours'    => 'Sat-Thu, 5:00 PM - 9:00 PM',
                'default_paper_size' => 'A4',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]
        );
    }
}
