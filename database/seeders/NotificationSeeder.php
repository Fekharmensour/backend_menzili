<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $notifications = [
            [
                'title_ar' => 'مرحبًا بك في منزلي!',
                'title_en' => 'Welcome to Menzili!',
                'title_fr' => 'Bienvenue sur Menzili!',
                'body_ar' => 'شكرًا لانضمامك إلى منصتنا. اكتشف أفضل العروض العقارية.',
                'body_en' => 'Thank you for joining our platform. Discover the best real estate offers.',
                'body_fr' => 'Merci de rejoindre notre plateforme. Découvrez les meilleures offres immobilières.',
            ],
            [
                'title_ar' => 'عقار جديد متاح',
                'title_en' => 'New Listing Available',
                'title_fr' => 'Nouvelle annonce disponible',
                'body_ar' => 'تمت إضافة عقار جديد. تصفح الآن!',
                'body_en' => 'A new property listing has been added. Check it out now!',
                'body_fr' => 'Une nouvelle propriété a été ajoutée. Consultez-la maintenant!',
            ],
            [
                'title_ar' => 'تنبيه جديد',
                'title_en' => 'New Alert',
                'title_fr' => 'Nouvelle alerte',
                'body_ar' => 'تمت إضافة عقار جديد قد يناسبك. تصفح الآن!',
                'body_en' => 'A new property that may suit you has been added. Browse now!',
                'body_fr' => 'Une nouvelle propriété qui pourrait vous convenir a été ajoutée. Parcourez-la maintenant!',
            ],
            [
                'title_ar' => 'عرض خاص',
                'title_en' => 'Special Offer',
                'title_fr' => 'Offre spéciale',
                'body_ar' => 'استفد من عروضنا الخاصة على الإيجار والبيع.',
                'body_en' => 'Take advantage of our special offers on rentals and sales.',
                'body_fr' => 'Profitez de nos offres spéciales sur les locations et ventes.',
            ],
        ];

        foreach ($users as $user) {
            foreach ($notifications as $notif) {
                Notification::create([
                    'title_ar' => $notif['title_ar'],
                    'title_en' => $notif['title_en'],
                    'title_fr' => $notif['title_fr'],
                    'body_ar' => $notif['body_ar'],
                    'body_en' => $notif['body_en'],
                    'body_fr' => $notif['body_fr'],
                    'user_id' => $user->id,
//                    'type' => 'info',
                    'is_read' => false,
                    'icon' => null,
                    'reference_type' => null,
                    'reference_id' => null,
                ]);
            }
        }
    }
}
