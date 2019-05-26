<?php

namespace frontend\models;

use yii\helpers\Url;

/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property string $title
 * @property int $ordering
 * @property int $status
 * @property int $pagetemplate_id
 * @property int $mainmenu
 *
 * @property News[] $news
 */
class Section extends \common\models\Section
{
    // Number of items (news) on the main Section Page
    const PICTUREOFTHEDAY_ITEMS_ON_INDEX_PAGE = 4;
    const PICTUREOFTHEDAY_ITEMS_ON_SLIDER = 11;
    const VIDEO_ITEMS_ON_SLIDER = 11;

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMainMenuItems()
    {
        $where = ['mainmenu' => 1, 'status' => static::STATUS_VISIBLE];
        $order = ['ordering' => SORT_ASC];
        return static::find()->where($where)->orderBy($order)->asArray()->all();
    }

    /**
     * @param $section
     * @return string
     */
    public static function getMainMenuItemUrl($section)
    {
        switch ($section['pagetemplate_id']) {
            case Section::PAGE_TEMPLATE_PICTUREOFTHEDAY:
                return Url::to(['/picture/index', 'id' => $section['id']]);
                break;
            case Section::PAGE_TEMPLATE_VIDEO:
                return Url::to(['/video/index', 'id' => $section['id']]);
                break;
            default:
                return Url::to(['/section/index', 'id' => $section['id']]);
        }
    }
}