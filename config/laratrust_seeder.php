<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'offices' => 'c,r,u,d,i,e',
            'schools' => 'c,r,u,d,i,e',
            'teachers' => 'c,r,u,d,i,e',
            'students' => 'c,r,u,d,i,e',
            'supervisors' => 'c,r,u,d,i,e',
        ],
        'admin' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'i' => 'import',
        'e' => 'export',
    ]
];
