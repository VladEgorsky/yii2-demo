<?php
$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            'imagesStorePath' => '@frontend/web/uploads',
            'imagesCachePath' => '@frontend/web/uploads/cache',
            'graphicsLibrary' => 'GD',
            'imageCompressionQuality' => 85,
        ],
        'seo' => [
            'class' => 'common\modules\seo\Module',
        ],
    ],

    'components' => [
        'elastic'   => [
            'class' => '\common\components\elastic\ElasticComponent',
            'port'  => 9200,
            'host'  => 'localhost'
        ],
        'cache'     => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d.m.Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_DEBUG,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'srg.webhost1.ru',
//                'username' => 'ecards@cms.vlad-tests.ru',
//                'password' => 'ecards2233',
//                'port' => '465',
//                'encryption' => 'ssl',
//            ],
        ],
    ],
];

if (YII_DEBUG && !YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
