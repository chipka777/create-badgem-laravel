<?php

return [
    'role_structure' => [
        'administrator' => [
            'users' => 'c,r,u,d',
            'upload' => 'c,r,u,d',
            'profile' => 'r,u',
            'favorite' => 'c,r,u,d'
        ],
        'designer' => [
            'profile' => 'c,r,u',
            'upload' => 'c,r,u,d',            
            'favorite' => 'c,r,u,d'
        ],
        'consumer' => [
            'profile' => 'c,r,u',
            'favorite' => 'c,r,u,d'
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
