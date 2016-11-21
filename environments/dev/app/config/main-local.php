<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:@runtime/main-db.sqlite',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
