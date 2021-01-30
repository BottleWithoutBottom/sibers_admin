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
            ]

        ]
    ]


];