<?php

namespace frontend\models;

use yii\helpers\Json;

class TemplateLocation extends \common\models\TemplateLocation
{
    public static $defaultItemsClasses = [
        'MAIN_UPPERBLOCK' => ['news news-big', 'news', 'news', 'news', 'news'],
        'MAINSECTION' => [
            'news news-big', 'news',
            'news news-wide',
            'news news-wide news-wide-l_img', 'news news-tall',
            'news news-no-img-big',
        ],
        'SECTION' => [
            'news news-big', 'news', 'news',
            'news news-wide', 'news news-wide news-wide-l_img', 'news news-tall',
            'news news-min', 'news news-min', 'news news-min',
        ],
        'TAG' => [
            'news', 'news', 'news',
            'news news-tall news-tall-selected', 'news news-tall', 'news news-tall'
        ],
    ];

    public static function getItemsClasses($locationKey, $locationId, $advertKey = null)
    {
        $query = TemplateLocation::find()->with(['template'])
            ->where(['location_key' => $locationKey, 'location_id' => $locationId])
            ->orderBy(['id' => SORT_DESC]);

        if (is_null($advertKey)) {
            $query->andWhere(['is', 'advert_key', null]);
        }

        $model = $query->asArray()->one();
        if (is_null($model) && is_null($model['template'])) {
            return static::$defaultItemsClasses[$locationKey];
        }

        return JSON::decode($model['template']['items_classes']);
    }
}