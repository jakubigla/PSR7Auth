<?php

use PSR7Auth\Verifier;

return [
    'psr7_auth' => [
        'middleware' => [
            'form' => [
                'identity_key' => 'identity',
                'credential_key' => 'credential',
                'rules' => [
                ],
                'verifiers' => [
                    Verifier\BCryptPasswordVerifier::class,
                ],
            ],
        ],
    ],

    'dependencies' => [
        'invokables' => [
            Verifier\BCryptPasswordVerifier::class => Verifier\BCryptPasswordVerifier::class,
        ],
    ],
];
