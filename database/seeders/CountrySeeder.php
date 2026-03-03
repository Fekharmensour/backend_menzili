<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name_ar' => 'الجزائر', 'name_en' => 'Algeria', 'flag_path' => 'https://flagcdn.com/w320/dz.png', 'code' => 'DZ'],
            ['name_ar' => '', 'name_en' => 'United States', 'flag_path' => 'https://flagcdn.com/w320/us.png', 'code' => 'US'],
            ['name_ar' => '', 'name_en' => 'United Kingdom', 'flag_path' => 'https://flagcdn.com/w320/gb.png', 'code' => 'GB'],
            ['name_ar' => '', 'name_en' => 'France', 'flag_path' => 'https://flagcdn.com/w320/fr.png', 'code' => 'FR'],
            ['name_ar' => '', 'name_en' => 'Germany', 'flag_path' => 'https://flagcdn.com/w320/de.png', 'code' => 'DE'],
            ['name_ar' => '', 'name_en' => 'Spain', 'flag_path' => 'https://flagcdn.com/w320/es.png', 'code' => 'ES'],
            ['name_ar' => '', 'name_en' => 'Italy', 'flag_path' => 'https://flagcdn.com/w320/it.png', 'code' => 'IT'],
            ['name_ar' => '', 'name_en' => 'Canada', 'flag_path' => 'https://flagcdn.com/w320/ca.png', 'code' => 'CA'],
            ['name_ar' => '', 'name_en' => 'Australia', 'flag_path' => 'https://flagcdn.com/w320/au.png', 'code' => 'AU'],
            ['name_ar' => '', 'name_en' => 'Japan', 'flag_path' => 'https://flagcdn.com/w320/jp.png', 'code' => 'JP'],
            ['name_ar' => '', 'name_en' => 'China', 'flag_path' => 'https://flagcdn.com/w320/cn.png', 'code' => 'CN'],
            ['name_ar' => '', 'name_en' => 'India', 'flag_path' => 'https://flagcdn.com/w320/in.png', 'code' => 'IN'],
            ['name_ar' => '', 'name_en' => 'Brazil', 'flag_path' => 'https://flagcdn.com/w320/br.png', 'code' => 'BR'],
            ['name_ar' => '', 'name_en' => 'Mexico', 'flag_path' => 'https://flagcdn.com/w320/mx.png', 'code' => 'MX'],
            ['name_ar' => '', 'name_en' => 'Russia', 'flag_path' => 'https://flagcdn.com/w320/ru.png', 'code' => 'RU'],
            ['name_ar' => '', 'name_en' => 'Saudi Arabia', 'flag_path' => 'https://flagcdn.com/w320/sa.png', 'code' => 'SA'],
            ['name_ar' => '', 'name_en' => 'Turkey', 'flag_path' => 'https://flagcdn.com/w320/tr.png', 'code' => 'TR'],
            ['name_ar' => '', 'name_en' => 'South Africa', 'flag_path' => 'https://flagcdn.com/w320/za.png', 'code' => 'ZA'],
            ['name_ar' => '', 'name_en' => 'Nigeria', 'flag_path' => 'https://flagcdn.com/w320/ng.png', 'code' => 'NG'],
            ['name_ar' => '', 'name_en' => 'Egypt', 'flag_path' => 'https://flagcdn.com/w320/eg.png', 'code' => 'EG'],
            ['name_ar' => '', 'name_en' => 'Morocco', 'flag_path' => 'https://flagcdn.com/w320/ma.png', 'code' => 'MA'],
            ['name_ar' => '', 'name_en' => 'Tunisia', 'flag_path' => 'https://flagcdn.com/w320/tn.png', 'code' => 'TN'],
            ['name_ar' => '', 'name_en' => 'Argentina', 'flag_path' => 'https://flagcdn.com/w320/ar.png', 'code' => 'AR'],
            ['name_ar' => '', 'name_en' => 'South Korea', 'flag_path' => 'https://flagcdn.com/w320/kr.png', 'code' => 'KR'],
            ['name_ar' => '', 'name_en' => 'Netherlands', 'flag_path' => 'https://flagcdn.com/w320/nl.png', 'code' => 'NL'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
