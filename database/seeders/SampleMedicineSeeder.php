<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * DEV/TEST ONLY. Small sample so autocomplete, allergy and duplicate
 * warnings can be tried before the real Excel import (RX-09).
 */
class SampleMedicineSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $companies = ['Square Pharmaceuticals', 'Beximco Pharmaceuticals', 'Incepta Pharmaceuticals', 'Renata Limited'];
        foreach ($companies as $name) {
            DB::table('companies')->insertOrIgnore(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        }

        // brand, generic, company, strength, form
        $medicines = [
            ['Napa',      'Paracetamol',   'Beximco Pharmaceuticals', '500 mg', 'Tablet'],
            ['Napa Extend', 'Paracetamol', 'Beximco Pharmaceuticals', '665 mg', 'Tablet'],
            ['Ace',       'Paracetamol',   'Square Pharmaceuticals',  '500 mg', 'Tablet'],
            ['Seclo',     'Omeprazole',    'Square Pharmaceuticals',  '20 mg',  'Capsule'],
            ['Losectil',  'Omeprazole',    'Eskayef',                 '20 mg',  'Capsule'],
            ['Maxpro',    'Esomeprazole',  'Renata Limited',          '20 mg',  'Tablet'],
            ['Fexo',      'Fexofenadine',  'Square Pharmaceuticals',  '120 mg', 'Tablet'],
            ['Monas',     'Montelukast',   'Acme Laboratories',       '10 mg',  'Tablet'],
            ['Azithro',   'Azithromycin',  'Square Pharmaceuticals',  '500 mg', 'Tablet'],
            ['Moxacil',   'Amoxicillin',   'Incepta Pharmaceuticals', '500 mg', 'Capsule'],
            ['Ciprocin',  'Ciprofloxacin', 'Square Pharmaceuticals',  '500 mg', 'Tablet'],
            ['Napro',     'Naproxen',      'Incepta Pharmaceuticals', '500 mg', 'Tablet'],
        ];

        foreach ($medicines as [$brand, $generic, $company, $strength, $form]) {
            DB::table('generics')->insertOrIgnore(['name' => $generic, 'created_at' => $now, 'updated_at' => $now]);
            DB::table('companies')->insertOrIgnore(['name' => $company, 'created_at' => $now, 'updated_at' => $now]);

            $genericId = DB::table('generics')->where('name', $generic)->value('id');
            $companyId = DB::table('companies')->where('name', $company)->value('id');

            DB::table('medicines')->updateOrInsert(
                ['brand_name' => $brand, 'strength' => $strength, 'dosage_form' => $form, 'company_id' => $companyId],
                [
                    'generic_id' => $genericId,
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
