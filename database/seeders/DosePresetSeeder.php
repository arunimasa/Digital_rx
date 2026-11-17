<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosePresetSeeder extends Seeder
{
    public function run(): void
    {
        $presets = [
            'dose' => [
                ['১+০+০', '1+0+0'], ['০+১+০', '0+1+0'], ['০+০+১', '0+0+1'],
                ['১+০+১', '1+0+1'], ['১+১+০', '1+1+0'], ['০+১+১', '0+1+1'],
                ['১+১+১', '1+1+1'], ['১+১+১+১', '1+1+1+1'],
                ['½+০+½', '½+0+½'], ['½+½+½', '½+½+½'],
                ['১ চামচ ×৩ বার', '1 tsp TDS'], ['২ চামচ ×৩ বার', '2 tsp TDS'],
                ['প্রয়োজন হলে', 'SOS'],
            ],
            'timing' => [
                ['সকালে', 'Morning'], ['দুপুরে', 'Noon'], ['রাতে', 'Night'],
                ['ঘুমানোর আগে', 'At bedtime'], ['সকালে ও রাতে', 'Morning & night'],
                ['প্রতি ৬ ঘণ্টা পরপর', 'Every 6 hours'], ['প্রতি ৮ ঘণ্টা পরপর', 'Every 8 hours'],
                ['প্রতি ১২ ঘণ্টা পরপর', 'Every 12 hours'],
            ],
            'duration' => [
                ['৩ দিন', '3 days'], ['৫ দিন', '5 days'], ['৭ দিন', '7 days'],
                ['১০ দিন', '10 days'], ['১৪ দিন', '14 days'], ['১ মাস', '1 month'],
                ['২ মাস', '2 months'], ['৩ মাস', '3 months'], ['৬ মাস', '6 months'],
                ['চলবে', 'Continue'], ['প্রয়োজন হলে', 'When needed'],
            ],
            'instruction' => [
                ['খাওয়ার আগে', 'Before meal'], ['খাওয়ার পরে', 'After meal'],
                ['খাওয়ার মাঝখানে', 'With meal'], ['খালি পেটে', 'Empty stomach'],
                ['পানি দিয়ে গিলে খাবেন', 'Swallow with water'], ['চিবিয়ে খাবেন', 'Chew before swallowing'],
                ['জ্বর বা ব্যথা হলে', 'If fever or pain'], ['ডাক্তারের পরামর্শ ছাড়া বন্ধ করবেন না', 'Do not stop without advice'],
            ],
        ];

        $now = now();

        foreach ($presets as $type => $rows) {
            foreach ($rows as $i => [$bn, $en]) {
                DB::table('dose_presets')->updateOrInsert(
                    ['type' => $type, 'label_bn' => $bn],
                    [
                        'label_en'   => $en,
                        'sort_order' => $i + 1,
                        'is_active'  => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
