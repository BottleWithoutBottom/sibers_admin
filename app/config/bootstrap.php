<?php
return [
    '/' => [
        'controller' => 'MainController',
        'action' => 'index',
    ],
    '/admin/' => [
        'controller' => 'AdminController',
        'action' => 'index',

        'children' => [
            '/admin/list/' => [
                'controller' => 'AdminController',
                'action' => 'index',

                'children' => [
                    '/admin/list/{id}/' => [
                        'controller' => 'AdminController',
                        'action' => 'show',
                        'pattern' => '#\/admin\/list\/[0-9]+\/#'
                    ],

                    '/admin/list/{id}/delete/' => [
                        'controller' => 'AdminController',
                        'action' => 'delete',
                        'pattern' => '#\/admin\/list\/[0-9]+\/delete\/#'
                    ],

                    '/admin/list/{id}/edit/' => [
                        'controller' => 'AdminController',
                        'action' => 'edit',
                        'pattern' => '#\/admin\/list\/[0-9]+\/edit\/#'
                    ]
                ]
            ]

        ]
    ],

    '/user/' => [
        'controller' => 'UserController',
        'action' => 'index',

        'children' => [
            '/user/login/' => [
                'controller' => 'UserController',
                'action' => 'login',
            ],
            '/user/authorize/' => [
                'controller' => 'UserController',
                'action' => 'authorize',
            ],
            '/user/logout/' => [
                'controller' => 'UserController',
                'action' => 'logout',
            ],
            '/user/register/' => [
                'controller' => 'UserController',
                'action' => 'register',
            ],
            '/user/reg/' => [
                'controller' => 'UserController',
                'action' => 'reg',
            ],
        ]
    ]


];