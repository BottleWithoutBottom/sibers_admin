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
    ]


];