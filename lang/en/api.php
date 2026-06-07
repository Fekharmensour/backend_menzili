<?php

return [
    'listings' => [
        'index' => [
            'success' => 'Data retrieved successfully',
        ],
        'show' => [
            'success' => 'Listing details retrieved successfully',
        ],
        'store' => [
            'success' => 'Listing created successfully',
            'insufficient_balance' => 'Insufficient coins balance to create a listing. You need :amount coins.',
        ],
        'update' => [
            'success' => 'Listing updated successfully',
            'unauthorized' => 'You are not authorized to update this listing',
        ],
        'destroy' => [
            'success' => 'Listing deleted successfully',
        ],
        'active' => [
            'success' => 'Listing activated successfully',
        ],
        'deactive' => [
            'success' => 'Listing deactivated successfully',
        ],
    ],
    'wallet' => [
        'show' => [
            'success' => 'Wallet data retrieved successfully',
        ],
        'transactions' => [
            'success' => 'Transaction history retrieved successfully',
        ],
        'add_coins' => [
            'success' => 'Coins added successfully',
        ],
    ],
    'payment' => [
        'invalid' => 'Invalid payment process',
        'not_found' => 'Payment not found',
        'already_processed' => 'Payment already processed',
    ],
    'common' => [
        'unauthorized' => 'You are not authorized to perform this action',
    ],
    'ai' => [
        'chat' => [
            'success' => 'Chat message sent successfully',
            'no_results' => 'Sorry, I couldn\'t find any results matching your search in this state. Would you like to try other criteria?',
            'relaxed_results' => '(No exact matches found, these are the closest options currently available)',
        ],
        'conversations' => [
            'index' => [
                'success' => 'Conversations retrieved successfully',
                'not_found' => 'No conversation found',
            ],
        ],
    ],
    'ad' => [
        'index' => [
            'success' => 'Ads retrieved successfully',
        ],
        'created' => 'Ad created successfully',
        'show' => 'Ad details retrieved successfully',
        'updated' => 'Ad updated successfully',
        'deleted' => 'Ad deleted successfully',
        'validation' => [
            'required_target_parameter' => 'The :field field is required when target_type is :type.',
        ],
    ],
    'report' => [
        'sent_success' => 'Report sent successfully',
        'already_reported' => 'You have already reported this item',
    ],
    'boost' => [
        'success' => 'Listing boosted successfully',
        'score_breakdown' => 'Score breakdown retrieved successfully',
    ],
    'reviews' => [
        'store_success' => 'Review submitted successfully',
        'store_already_reviewed' => 'You have already reviewed this listing',
        'self_review_not_allowed' => 'You cannot review your own listing',
        'delete_success' => 'Review deleted successfully',
        'member_not_found' => 'Member not found',
        'review_not_found' => 'Review not found',
        'unauthorized' => 'You are not authorized to perform this operation',
    ],

    'activities' => [
        'listing_creation' => 'Created a new listing: :title',
        'coin_purchase' => 'Purchased coins bundle',
        'ad_publication' => 'Published a new advertisement',
        'initial_bonus' => 'Account welcome bonus',
        'boost' => 'Boosted listing: :title',
    ],
];
