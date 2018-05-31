<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

return [
    'rules' => [
        [
            '__class' => \yii\rest\UrlRule::class,
            'pluralize' => false,
            'controller' => [
                'v1/core/user'
            ],
            'tokens' => [
                '{id}' => '<id:\\w[\\w,]*>',
            ],
            'extraPatterns' => [
                'GET me' => 'me',
                'POST me' => 'update-me',
            ]
        ],
    ]
];