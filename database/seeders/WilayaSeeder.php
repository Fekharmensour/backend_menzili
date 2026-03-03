<?php

namespace Database\Seeders;

use App\Models\Wilaya;
use App\Models\Country;
use Illuminate\Database\Seeder;

class WilayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Algeria country
        $algeria = Country::where('code', 'DZ')->first();
        
        if (!$algeria) {
            $this->command->warn('Algeria country not found. Please seed CountrySeeder first.');
            return;
        }

        $wilayas = [
            ['name_ar' => 'أدرار', 'name_en' => 'Adrar', 'code' => '1'],
            ['name_ar' => 'الشلف', 'name_en' => 'Chlef', 'code' => '2'],
            ['name_ar' => 'الأغواط', 'name_en' => 'Laghouat', 'code' => '3'],
            ['name_ar' => 'أم البواقي', 'name_en' => 'Oum El Bouaghi', 'code' => '4'],
            ['name_ar' => 'باتنة', 'name_en' => 'Batna', 'code' => '5'],
            ['name_ar' => 'بجاية', 'name_en' => 'Béjaïa', 'code' => '6'],
            ['name_ar' => 'بسكرة', 'name_en' => 'Biskra', 'code' => '7'],
            ['name_ar' => 'بشار', 'name_en' => 'Bechar', 'code' => '8'],
            ['name_ar' => 'البليدة', 'name_en' => 'Blida', 'code' => '9'],
            ['name_ar' => 'البويرة', 'name_en' => 'Bouira', 'code' => '10'],
            ['name_ar' => 'تمنراست', 'name_en' => 'Tamanrasset', 'code' => '11'],
            ['name_ar' => 'تبسة', 'name_en' => 'Tbessa', 'code' => '12'],
            ['name_ar' => 'تلمسان', 'name_en' => 'Tlemcen', 'code' => '13'],
            ['name_ar' => 'تيارت', 'name_en' => 'Tiaret', 'code' => '14'],
            ['name_ar' => 'تيزي وزو', 'name_en' => 'Tizi Ouzou', 'code' => '15'],
            ['name_ar' => 'الجزائر', 'name_en' => 'Alger', 'code' => '16'],
            ['name_ar' => 'الجلفة', 'name_en' => 'Djelfa', 'code' => '17'],
            ['name_ar' => 'جيجل', 'name_en' => 'Jijel', 'code' => '18'],
            ['name_ar' => 'سطيف', 'name_en' => 'Sétif', 'code' => '19'],
            ['name_ar' => 'سعيدة', 'name_en' => 'Saïda', 'code' => '20'],
            ['name_ar' => 'سكيكدة', 'name_en' => 'Skikda', 'code' => '21'],
            ['name_ar' => 'سيدي بلعباس', 'name_en' => 'Sidi Bel Abbes', 'code' => '22'],
            ['name_ar' => 'عنابة', 'name_en' => 'Annaba', 'code' => '23'],
            ['name_ar' => 'قالمة', 'name_en' => 'Guelma', 'code' => '24'],
            ['name_ar' => 'قسنطينة', 'name_en' => 'Constantine', 'code' => '25'],
            ['name_ar' => 'المدية', 'name_en' => 'Medea', 'code' => '26'],
            ['name_ar' => 'مستغانم', 'name_en' => 'Mostaganem', 'code' => '27'],
            ['name_ar' => 'المسيلة', 'name_en' => "M'Sila", 'code' => '28'],
            ['name_ar' => 'معسكر', 'name_en' => 'Mascara', 'code' => '29'],
            ['name_ar' => 'ورقلة', 'name_en' => 'Ouargla', 'code' => '30'],
            ['name_ar' => 'وهران', 'name_en' => 'Oran', 'code' => '31'],
            ['name_ar' => 'البيض', 'name_en' => 'El Bayadh', 'code' => '32'],
            ['name_ar' => 'إليزي', 'name_en' => 'Illizi', 'code' => '33'],
            ['name_ar' => 'برج بوعريريج', 'name_en' => 'Bordj Bou Arreridj', 'code' => '34'],
            ['name_ar' => 'بومرداس', 'name_en' => 'Boumerdes', 'code' => '35'],
            ['name_ar' => 'الطارف', 'name_en' => 'El Tarf', 'code' => '36'],
            ['name_ar' => 'تندوف', 'name_en' => 'Tindouf', 'code' => '37'],
            ['name_ar' => 'تيسمسيلت', 'name_en' => 'Tissemsilt', 'code' => '38'],
            ['name_ar' => 'الوادي', 'name_en' => 'El Oued', 'code' => '39'],
            ['name_ar' => 'خنشلة', 'name_en' => 'Khenchela', 'code' => '40'],
            ['name_ar' => 'سوق أهراس', 'name_en' => 'Souk Ahras', 'code' => '41'],
            ['name_ar' => 'تيبازة', 'name_en' => 'Tipaza', 'code' => '42'],
            ['name_ar' => 'ميلة', 'name_en' => 'Mila', 'code' => '43'],
            ['name_ar' => 'عين الدفلى', 'name_en' => 'Ain Defla', 'code' => '44'],
            ['name_ar' => 'النعامة', 'name_en' => 'Naama', 'code' => '45'],
            ['name_ar' => 'عين تموشنت', 'name_en' => 'Ain Temouchent', 'code' => '46'],
            ['name_ar' => 'غرداية', 'name_en' => 'Ghardaia', 'code' => '47'],
            ['name_ar' => 'غليزان', 'name_en' => 'Relizane', 'code' => '48'],
            ['name_ar' => 'المغير', 'name_en' => "El M'ghair", 'code' => '49'],
            ['name_ar' => 'المنيعة', 'name_en' => 'El Menia', 'code' => '50'],
            ['name_ar' => 'أولاد جلال', 'name_en' => 'Ouled Djellal', 'code' => '51'],
            ['name_ar' => 'برج باجي مختار', 'name_en' => 'Bordj Baji Mokhtar', 'code' => '52'],
            ['name_ar' => 'بني عباس', 'name_en' => 'Béni Abbès', 'code' => '53'],
            ['name_ar' => 'تيميمون', 'name_en' => 'Timimoun', 'code' => '54'],
            ['name_ar' => 'تقرت', 'name_en' => 'Touggourt', 'code' => '55'],
            ['name_ar' => 'جانت', 'name_en' => 'Djanet', 'code' => '56'],
            ['name_ar' => 'عين صالح', 'name_en' => 'In Salah', 'code' => '57'],
            ['name_ar' => 'عين قزام', 'name_en' => 'In Guezzam', 'code' => '58'],
            ['name_ar' => 'أفلُو', 'name_en' => 'Aflou', 'code' => '59'],
            ['name_ar' => 'بريكة', 'name_en' => 'Barika', 'code' => '60'],
            ['name_ar' => 'قصر الشلالة', 'name_en' => 'Ksar Chellala', 'code' => '61'],
            ['name_ar' => 'مسعد', 'name_en' => 'Messaad', 'code' => '62'],
            ['name_ar' => 'عين وسارة', 'name_en' => 'Aïn Oussara', 'code' => '63'],
            ['name_ar' => 'بوسعادة', 'name_en' => 'Boussaâda', 'code' => '64'],
            ['name_ar' => 'البيض سيدي الشيخ', 'name_en' => 'El Bayadh Sidi Cheikh', 'code' => '65'],
            ['name_ar' => 'القنطرة', 'name_en' => 'El Kantara', 'code' => '66'],
            ['name_ar' => 'بئر العاتر', 'name_en' => 'Bir El Ater', 'code' => '67'],
            ['name_ar' => 'قصر البخاري', 'name_en' => 'Ksar El Boukhari', 'code' => '68'],
            ['name_ar' => 'العريشة', 'name_en' => 'El Aricha', 'code' => '69'],
        ];

        foreach ($wilayas as $wilaya) {
            Wilaya::updateOrCreate(
                ['code' => $wilaya['code']],
                [
                    'name_ar' => $wilaya['name_ar'],
                    'name_en' => $wilaya['name_en'],
                    'country_id' => $algeria->id,
                ]
            );
        }

        $this->command->info('Seeded ' . count($wilayas) . ' wilayas for Algeria');
    }
}
