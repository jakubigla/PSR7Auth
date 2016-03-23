<?php

use PSR7Auth\Verifier;

return [
    'sexy_auth' => [
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
