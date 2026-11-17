<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SequenceSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $sequences = [
            ['name' => 'patient', 'year' => 0],              // never resets
            ['name' => 'rx', 'year' => (int) $now->year],    // resets every year
        ];

        foreach ($sequences as $seq) {
            // insertOrIgnore keeps the existing last_number if re-seeded
            DB::table('sequences')->insertOrIgnore($seq + [
                'last_number' => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
