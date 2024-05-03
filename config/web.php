<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/dbamanda.php';
$dbsimponi = require __DIR__ . '/dbsimponi.php';
$dbpusharlis = require __DIR__ . '/dbpusharlis.php';

$config = [
    'id' => 'AMANDA',
    'name'=>'AMANDA',
    'timeZone' => 'Asia/Jakarta',
    'homeUrl' => 'https://sppd.hapindo.co.id/',
    'sourceLanguage' => 'id',
    'language' => 'id',
    'basePath' => dirname(__DIR__),
    // 'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
       'dynagrid'=> [
            'class'=>'\kartik\dynagrid\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Api',
        ],
    ],
    'components' => [
        'AllComponent' => [
            'class' => 'app\components\AllComponent',
        ],
        'MyComponent' => [
            'class' => 'app\components\MyComponent',
        ],
        'formatter' => [
            'locale' => 'en-US',
            'dateFormat' => 'Y-m-d',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => '$',
            'locale' => 'Asia/Jakarta',
            'defaultTimeZone' => 'UTS+7',
            'timeZone' => 'Asia/Jakarta',
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
        ],
        'request' => [
            // 'baseUrl' => 'https://tesamanda.hapindo.co.id',
            'enableCsrfValidation' => false,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '78jz3i7JAkMU1if9t0OY3FxTHNiIaodD4',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => ['app\models\Admin','app\models\User'],
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_amandasppd', // unique 
                'httpOnly' => true
            ]
        ],
        'session' => [
            'name' => '_amandaSppdSessionId', // unique 
            'savePath' => __DIR__ . '/../runtime', // a temporary folder on backend
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'dbsimponi' => $dbsimponi,
        'dbpusharlis' => $dbpusharlis,
        'urlManager' => [
          'class' => 'yii\web\UrlManager',
          // Disable index.php
          'showScriptName' => false,
          // Disable r= routes
          'enablePrettyUrl' => true,
          'suffix' => '.html',
          'rules' => [
                ['class' => 'yii\rest\UrlRule','controller'=>'apa'],
                'dashboard' => 'web/site/index',
                '<alias:\w+>' => 'site/<alias>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
          ],
        ],
        
        // 'urlManager' => [
        //     'class' => 'yii\web\UrlManager',
        //     // Hide index.php
        //     'showScriptName' => true,
        //     // Use pretty URLs
        //     'enablePrettyUrl' => false,
        //     'rules' => [
        //     ],
        // ],
        
    ],
    'params' => $params,
];

if (!YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
    //     // uncomment the following to add your IP if you are not connecting from localhost.
    //     //'allowedIPs' => ['127.0.0.1', '::1'],
    // ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [ // HERE
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
