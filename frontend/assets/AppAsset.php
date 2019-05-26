<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fonts.css',
        'css/main.min.css',
        'css/libs.min.css',
    ];
    public $js = [
        'js/libs.min.js',
        'https://unpkg.com/packery@2/dist/packery.pkgd.min.js',
        'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js',
        'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js',
        'js/common.js'
    ];
//    public $depends = [
//        'yii\web\JqueryAsset',
//    ];

    public function init()
    {
        parent::init();

        // Если нужно, то для контроллеров создаем одноименные файлы стилей и скриптов
        // т.е.для контроллера UserController создаем /css/user.css & /js/user.js
        // Здесь их подключаем. Файлы /css/main.css & /js/main.js подключаются всегда
        $ctrlId = \Yii::$app->controller->id;
        $controllerRelatedCssFile = '/css/controllers/' . $ctrlId . '.css';
        $controllerRelatedJsFile = '/js/controllers/' . $ctrlId . '.js';

        if (is_file($this->basePath . $controllerRelatedCssFile)) {
            $this->css[] = $controllerRelatedCssFile;
        }
        if (is_file($this->basePath . $controllerRelatedJsFile)) {
            $this->js[] = $controllerRelatedJsFile;
        }
    }
}
