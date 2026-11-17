<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DosePresetSeeder::class,
            SequenceSeeder::class,
            SettingSeeder::class,
        ]);

        // Sample medicines are for development and testing only.
        if (app()->environment('local', 'testing')) {
            $this->call(SampleMedicineSeeder::class);
        }
    }
}
