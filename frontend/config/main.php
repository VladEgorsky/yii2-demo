<?php

use yii\web\View;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'params' => $params,

    'id'                  => 'news-frontend',
    'name'                => 'The Siberian Times',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'container' => require __DIR__ . '/container.php',
    'components'          => [
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        'https://code.jquery.com/jquery-1.12.4.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js',
                    ],
                    'jsOptions' => ['position' => View::POS_HEAD],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                ],

            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'news-frontend-FTeIEmSeocqRbOYFj3JPuwJ9y8Etox-8',
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'news-frontend',
        ],
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'socialNetworks' => [
                'twitter' => [
                    'class' => \ymaker\social\share\drivers\Twitter::class,
                    'label' => false,
                    'options' => ['class' => 'social twitter'],
                    'config' => [
                        'account' => $params['twitterAccount']
                    ],
                ],
                'facebook' => [
                    'class' => \ymaker\social\share\drivers\Facebook::class,
                    'label' => false,
                    'options' => ['class' => 'social facebook'],
                ],
                'telegram' => [
                    'class' => \ymaker\social\share\drivers\Telegram::class,
                    'label' => false,
                    'options' => ['class' => 'social telegram'],
                ],
                // ...
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'class'           => '\frontend\components\BaseUrlManager',
            'rules'           => [
                '<id:([0-9])+>/images/image-by-item-and-alias' => 'yii2images/images/image-by-item-and-alias',
                '<view:[\w-]+>'                                => 'site/page',
                '<controller:\w+>/<action:\w+>/<id:\d+>'       => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                => '<controller>/<action>',
                '<controller:\w+>'                             => '<controller>/index',
            ],
        ],
    ],
];
