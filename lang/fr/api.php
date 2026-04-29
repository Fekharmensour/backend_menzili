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

];
