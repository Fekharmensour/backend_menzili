<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Wilaya;
use Illuminate\Database\Seeder;

class NewWilayasCitiesSeeder extends Seeder
{
    public function run(): void
    {
        // Format : ['code_wilaya' => '59', 'cities' => [ ['ar' => '...', 'en' => '...'], ... ]]
        $newWilayasData = [

            // 59 - Aflou (ex-circonscription de Laghouat)
            '59' => [
                ['ar' => 'أفلو',         'en' => 'Aflou'],
                ['ar' => 'سيدي بوزيد',   'en' => 'Sidi Bouzid'],
                ['ar' => 'سبقاق',        'en' => 'Sebgag'],
                // + d'autres si tu trouves (ex: Hassi Delaa, El Houita, etc. dans la CAT Aflou)
            ],

            // 60 - Barika (ex-Batna)
            '60' => [
                ['ar' => 'بريكة',        'en' => 'Barika'],
                ['ar' => 'مدوكل',        'en' => "M'doukel"],
                ['ar' => 'بيطام',        'en' => 'Bitam'],
                // → souvent ces 3 seulement pour la daïra historique de Barika
            ],

            // 61 - Ksar Chellala (ex-Tiaret)
            '61' => [
                ['ar' => 'قصر الشلالة',   'en' => 'Ksar Chellala'],
                ['ar' => 'سرغين',        'en' => 'Serghine'],
                ['ar' => 'زمالة الأمير عبد القادر', 'en' => 'Zmalet El Emir Abdelkader'],
                // + éventuellement d'autres de l'ancienne daïra
            ],

            // 62 - Messaad / Messâad (ex-Djelfa)
            '62' => [
                ['ar' => 'مسعد',         'en' => 'Messaad'],
                ['ar' => 'سلمانة',       'en' => 'Selmana'],
                ['ar' => 'دالدول',       'en' => 'Deldoul'],
                ['ar' => 'قطارة',        'en' => 'Guettara'],
                ['ar' => 'سدر الرحال',   'en' => 'Sed Rahal'],
                // → daïra Messaad historique → 5–6 communes typiquement
            ],

            // 63 - Aïn Oussara (ex-Djelfa)
            '63' => [
                ['ar' => 'عين وسارة',    'en' => 'Aïn Oussara'],
                ['ar' => 'قرنيني',       'en' => 'Guernini'],
                // + d'autres si disponibles (souvent 3–5)
            ],

            // 64 - Boussaâda / Bou Saâda (ex-M'Sila)
            '64' => [
                ['ar' => 'بوسعادة',      'en' => "Boussaâda"],
                ['ar' => 'أولاد سيدي سعيد', 'en' => 'Ouled Sidi Saïd'], // exemple
                // → wilaya avec plusieurs communes (10+ possible)
            ],

            // 65 - El Bayadh Sidi Cheikh / El Biodh Sidi Cheikh (ex-El Bayadh)
            '65' => [
                ['ar' => 'البيض سيدي الشيخ', 'en' => 'El Bayadh Sidi Cheikh'],
                ['ar' => 'سيدي الشيخ',   'en' => 'Sidi Cheikh'],
                // peu de communes souvent
            ],

            // 66 - El Kantara (ex-Biskra)
            '66' => [
                ['ar' => 'القنطرة',      'en' => 'El Kantara'],
                // + quelques autres si besoin
            ],

            // 67 - Bir El Ater (ex-Tébessa)
            '67' => [
                ['ar' => 'بئر العاتر',   'en' => 'Bir El Ater'],
                // + communes limitrophes
            ],

            // 68 - Ksar El Boukhari (ex-Médéa)
            '68' => [
                ['ar' => 'قصر البخاري',  'en' => 'Ksar El Boukhari'],
                // souvent capitale + 2–4
            ],

            // 69 - El Aricha (ex-Tlemcen ?)
            '69' => [
                ['ar' => 'العريشة',      'en' => 'El Aricha'],
                // peu documenté pour l'instant
            ],
        ];

        $count = 0;

        foreach ($newWilayasData as $wilayaCode => $cities) {
            $wilaya = Wilaya::where('code', $wilayaCode)->first();

            if (!$wilaya) {
                $this->command->warn("Wilaya code $wilayaCode non trouvée → skip");
                continue;
            }

            foreach ($cities as $city) {
                City::updateOrCreate(
                    [
                        'name_ar'   => $city['ar'],
                        'wilaya_id' => $wilaya->id,
                    ],
                    [
                        'name_en'   => $city['en'] ?? $city['ar'], // fallback si pas d'anglais
                    ]
                );
                $count++;
            }
        }

        $this->command->info("Seeded $count cities for new wilayas (59–69).");
    }
}