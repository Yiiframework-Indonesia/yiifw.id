<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\controllers',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module'
        ],
        'event' => [
            'class' => 'modules\event\Module',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'app\models\ar\User',
            'loginUrl' => ['user/login'],
            'enableAutoLogin' => true,
            'as profile' => 'app\classes\UserInfo'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'session' => [
            'class' => 'yii\web\DbSession'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => require 'url-rules.php',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'assetManager' => [
            'assetMap' => [
                'jquery.js' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js',
                'jquery-ui.js' => 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',
                'jquery-ui.css' => 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css'
            ],
        ],
    ],
    'params' => $params,
];
