<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2piknikio',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '',
                'password' => '',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            //'db' => ['dsn' => 'sqlite:@runtime/cache.sqlite']
        ],
        'queue' => [
            'class' => 'dee\queue\queues\DbQueue',
            'module' => 'task',
        ],
        'authClientCollection' => [
            'clients' => [
                'google' => [
                    'clientId' => '',
                    'clientSecret' => '',
                ],
                'facebook' => [
                    'clientId' => '',
                    'clientSecret' => '',
                ],
                'github' => [
                    'clientId' => '',
                    'clientSecret' => '',
                ],
            ],
        ],
    ],
];
