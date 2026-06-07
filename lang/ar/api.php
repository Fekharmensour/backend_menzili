<?php

return [
    'listings' => [
        'index' => [
            'success' => 'تم جلب البيانات بنجاح',
        ],
        'show' => [
            'success' => 'تم جلب تفاصيل الإعلان بنجاح',
        ],
        'store' => [
            'success' => 'تم إضافة الإعلان بنجاح',
            'insufficient_balance' => 'رصيد العملات غير كافٍ لإنشاء إعلان. تحتاج إلى :amount عملة.',
        ],
        'update' => [
            'success' => 'تم تحديث الإعلان بنجاح',
            'unauthorized' => 'غير مصرح لك بتعديل هذا الإعلان',
        ],
        'destroy' => [
            'success' => 'تم حذف الإعلان بنجاح',
        ],
        'active' => [
            'success' => 'تم تفعيل الإعلان بنجاح',
        ],
        'deactive' => [
            'success' => 'تم إلغاء تفعيل الإعلان بنجاح',
        ],
    ],
    'wallet' => [
        'show' => [
            'success' => 'تم جلب بيانات المحفظة بنجاح',
        ],
        'transactions' => [
            'success' => 'تم جلب سجل العمليات بنجاح',
        ],
        'add_coins' => [
            'success' => 'تم إضافة العملات بنجاح',
        ],
    ],
    'payment' => [
        'invalid' => 'عملية دفع غير صالحة',
        'not_found' => 'لم يتم العثور على عملية الدفع',
        'already_processed' => 'تم معالجة عملية الدفع مسبقاً',
    ],
    'common' => [
        'unauthorized' => 'غير مصرح لك بالقيام بهذا الإجراء',
    ],
    'ai' => [
        'chat' => [
            'success' => 'تم إرسال رسالة الدردشة بنجاح',
            'no_results' => 'عذراً، لم أجد أي نتائج تطابق بحثك حالياً في هذه الولاية. هل ترغب في تجربة معايير أخرى؟',
            'relaxed_results' => '(لا توجد نتائج مطابقة تماماً، هذه أقرب الخيارات المتاحة حالياً)',
        ],
        'conversations' => [
            'index' => [
                'success' => 'تم جلب المحادثات بنجاح',
                'not_found' => 'لم يتم العثور على محادثة',
            ],
        ],
    ],
    'ad' => [
        'index' => [
            'success' => 'تم جلب الإعلانات بنجاح',
        ],
        'created' => 'تم إنشاء الإعلان بنجاح',
        'show' => 'تم جلب تفاصيل الإعلان بنجاح',
        'updated' => 'تم تحديث الإعلان بنجاح',
        'deleted' => 'تم حذف الإعلان بنجاح',
        'validation' => [
            'required_target_parameter' => 'الحقل :field مطلوب عندما تكون قيمة target_type هي :type.',
        ],
    ],
    'report' => [
        'sent_success' => 'تم إرسال البلاغ بنجاح',
        'already_reported' => 'لقد قمت بالإبلاغ عن هذا العنصر مسبقاً',
    ],
    'boost' => [
        'success' => 'تم تمييز الإعلان بنجاح',
        'score_breakdown' => 'تم جلب تفاصيل النتيجة بنجاح',
    ],
    'reviews' => [
        'store_success' => 'تم إضافة التقييم بنجاح',
        'store_already_reviewed' => 'لقد قمت بتقييم هذا الإعلان مسبقاً',
        'self_review_not_allowed' => 'لا يمكنك تقييم إعلانك الخاص',
        'delete_success' => 'تم حذف التقييم بنجاح',
        'member_not_found' => 'لم يتم العثور على العضو',
        'review_not_found' => 'لم يتم العثور على التقييم',
        'unauthorized' => 'غير مصرح لك بالقيام بهذه العملية',
    ],

    'activities' => [
        'listing_creation' => 'إنشاء إعلان جديد : :title',
        'coin_purchase' => 'شراء باقة عملات',
        'ad_publication' => 'نشر إعلان ترويجي جديد',
        'initial_bonus' => 'هدية ترحيبية',
        'boost' => 'ترقية الإعلان : :title',
    ],
];
