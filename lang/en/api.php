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
        ],
        'update' => [
            'success' => 'Listing updated successfully',
            'unauthorized' => 'You are not authorized to update this listing',
        ],
        'destroy' => [
            'success' => 'Listing deleted successfully',
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

];
