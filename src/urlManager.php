<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

return [
    'rules'=>[
        [
            '__class' => \yii\rest\UrlRule::class,
            'pluralize1' => false,
            'controller' => 'user',
            'tokens' => [
                '{id}' => '<id:\\w[\\w,]*>',
            ],
            //'patterns'=>[],
            'extraPatterns' => [
                'GET test' => 'test',
            ]
        ],
    ]
];