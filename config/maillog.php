<?php
return [
    'send_message' => [
        'save_error' => true,
        'throw_exception' => true,
    ],
    'send_swift_message' => [
        'save_error' => true,
        'throw_exception' => false,
    ],
    'route' => [
        'enable' => true,
        'domain' => null,
        'middleware' => ['web'],
        'prefix' => 'mail-logs',
        'as' => 'mail-logs'
    ],
    'prune' => [
        'enable' => true,
        'days' => 30
    ]
];
