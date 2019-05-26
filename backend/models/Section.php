<?php
namespace backend\models;

use backend\components\LoggingBehavior;
use yii\helpers\ArrayHelper;

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
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'log' => [
                    'class' => LoggingBehavior::class,
                ]
            ]
        );
    }
}
