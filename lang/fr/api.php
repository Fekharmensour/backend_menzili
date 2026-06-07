<?php

return [
    'listings' => [
        'index' => [
            'success' => 'Données récupérées avec succès',
        ],
        'show' => [
            'success' => 'Détails de l\'annonce récupérés avec succès',
        ],
        'store' => [
            'success' => 'Annonce créée avec succès',
            'insufficient_balance' => 'Solde de pièces insuffisant pour créer une annonce. Vous avez besoin de :amount pièces.',
        ],
        'update' => [
            'success' => 'Annonce mise à jour avec succès',
            'unauthorized' => 'Vous n\'êtes pas autorisé à mettre à jour cette annonce',
        ],
        'destroy' => [
            'success' => 'Annonce supprimée avec succès',
        ],
    ],
    'wallet' => [
        'show' => [
            'success' => 'Données du portefeuille récupérées avec succès',
        ],
        'transactions' => [
            'success' => 'Historique des transactions récupéré avec succès',
        ],
        'add_coins' => [
            'success' => 'Pièces ajoutées avec succès',
        ],
    ],
    'payment' => [
        'invalid' => 'Processus de paiement invalide',
        'not_found' => 'Paiement non trouvé',
        'already_processed' => 'Paiement déjà traité',
    ],
    'common' => [
        'unauthorized' => 'Vous n\'êtes pas autorisé à effectuer cette action',
    ],
    'ai' => [
        'chat' => [
            'success' => 'Message de chat envoyé avec succès',
            'no_results' => 'Désolé, je n\'ai trouvé aucun résultat correspondant à votre recherche dans cet état. Souhaitez-vous essayer d\'autres critères?',
            'relaxed_results' => '(Aucune correspondance exacte trouvée, voici les options les plus proches actuellement disponibles)',
        ],
        'conversations' => [
            'index' => [
                'success' => 'Conversations récupérées avec succès',
                'not_found' => 'Aucune conversation trouvée',
            ],
        ],
    ],
    'ad' => [
        'index' => [
            'success' => 'Annonces récupérées avec succès',
        ],
        'created' => 'Annonce créée avec succès',
        'show' => 'Détails de l\'annonce récupérés avec succès',
        'updated' => 'Annonce mise à jour avec succès',
        'deleted' => 'Annonce supprimée avec succès',
        'validation' => [
            'required_target_parameter' => 'Le champ :field est obligatoire lorsque target_type est :type.',
        ],
    ],
    'report' => [
        'sent_success' => 'Signalement envoyé avec succès',
        'already_reported' => 'Vous avez déjà signalé cet élément',
    ],
    'boost' => [
        'success' => 'Annonce boostée avec succès',
        'score_breakdown' => 'Détails du score récupérés avec succès',
    ],
    'reviews' => [
        'store_success' => 'Avis soumis avec succès',
        'store_already_reviewed' => 'Vous avez déjà évalué cette annonce',
        'self_review_not_allowed' => 'Vous ne pouvez pas évaluer votre propre annonce',
        'delete_success' => 'Avis supprimé avec succès',
        'member_not_found' => 'Membre non trouvé',
        'review_not_found' => 'Avis non trouvé',
        'unauthorized' => 'Vous n\'êtes pas autorisé à effectuer cette opération',
    ],

    'activities' => [
        'listing_creation' => 'Créé une nouvelle annonce : :title',
        'coin_purchase' => 'Achat d\'un pack de pièces',
        'ad_publication' => 'Publication d\'une nouvelle publicité',
        'initial_bonus' => 'Bonus de bienvenue',
        'boost' => 'Boost de l\'annonce : :title',
    ],
];
