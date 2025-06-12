<?php
return [
    'ManageGroups' => [
        'type' => 2,
        'description' => 'Kezelheti a csoportokat',
    ],

    'admin' => [
        'type' => 1,
        'description' => 'Admin felhasználó',
        'children' => [
            'ManageGroups',
        ],
    ],
    'student' => [
        'type' => 1,
        'description' => 'Diák felhasználó',
    ],
];
