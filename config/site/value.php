<?php
return [
    'session' => [
        'current_currency_id' => '$5#ds5%$D',
    ],
    'mercadopago' => [
        'response' => [
            'success' => "success",
            'pending' => "pending",
            'failed' => "failure",
        ],
        'status' => [
            'pending' => "pending",
            'in_process' => "in_process",
            'approved' => "approved",
            'rejected' => "rejected",
            'cancelled' => "cancelled",
            'refunded' => "refunded",
        ],
        'auto-return' => [
            'all' => "all",
            'approved' => "approved",
        ],
    ],
    'order' => [
        'status' => [
            'success' => 'success',
            'pending' => 'pending',
            'failed' =>  'failed',
        ],
        'payment-status' => [
            'pending' => "pending",
            'approved' => "approved",
            'rejected' => "rejected",
            'cancelled' => "cancelled",
            'refunded' => "refunded",
        ],
    ],
    'product' => [
        'presentation-type' => [
            'latest-section' => 'latest-section',
            'filter-section' => 'filter-section',
        ],
        'box-type' => [
            'general' => 'general',
            'catalogue' => 'catalogue',
            'mini' => 'mini',
        ],
    ],
];