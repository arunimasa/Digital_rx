<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $settings = [
            'clinic_name'         => 'My Clinic',
            'patient_code_prefix' => 'P',
            'rx_number_prefix'    => 'RX',
            'default_paper_size'  => 'A4',
            'default_language'    => 'bn',
            'qr_verify_enabled'   => '1',
            'print_show_logo'     => '1',
            'follow_up_alert_days' => '3',
        ];

        foreach ($settings as $key => $value) {
            // insertOrIgnore so admin-edited values are not overwritten on re-seed
            DB::table('settings')->insertOrIgnore([
                'key'        => $key,
                'value'      => $value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
