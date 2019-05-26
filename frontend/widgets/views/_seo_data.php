<?php
/**
 * Created by PhpStorm.
 * @var $model \common\models\BaseModel
 */

$seo = $model->seo;

if ($seo) {

    $this->title = $seo->title;

    $this->registerMetaTag([
        'name'    => 'description',
        'content' => $seo->description,
    ]);

    $this->registerMetaTag([
        'name'    => 'keywords',
        'content' => $seo->keywords,
    ]);

    $this->registerMetaTag([
        'name'    => 'robots',
        'content' => ($seo->noindex ? 'noindex' : 'index') . ', ' . ($seo->nofollow ? 'nofollow' : 'follow'),
    ]);
}