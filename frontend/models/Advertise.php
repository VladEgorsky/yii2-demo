<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "advertise".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $location_id
 * @property string $content
 * @property string $image
 * @property string $files
 * @property int $status
 * @property int $created_at
 * @property int $clicks
 *
 * @property Section[] $sections
 * @property Tag[] $tags
 */
class Advertise extends \common\models\Advertise
{
    /**
     * @param $section_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getLastModelBySectionId($section_id, $location_id)
    {
        return static::find()->joinWith('sections')
            ->where(['section_id' => $section_id, 'location_id' => $location_id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)->one();
    }

    /**
     * @param $tag_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getLastModelByTagId($tag_id, $location_id)
    {
        return static::find()->joinWith('tags')
            ->where(['tag_id' => $tag_id, 'location_id' => $location_id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)->one();
    }
}
