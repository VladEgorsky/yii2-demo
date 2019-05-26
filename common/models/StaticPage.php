<?php

namespace common\models;

use common\modules\seo\behaviors\SeoBehavior;

/**
 * This is the model class for table "static_page".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $status
 * @property int $clicks
 * @property string $view
 */
class StaticPage extends BaseModel
{
    const STATUS_HIDDEN = 0;
    const STATUS_VISIBLE = 1;
    protected static $nameField = 'title';
    protected static $statuses = [
        self::STATUS_HIDDEN  => 'Hidden',
        self::STATUS_VISIBLE => 'Visible',
    ];
    protected $isSeoRequired = true;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'static_page';
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function behaviors()
    {
        return [
            'seo' => [
                'class' => SeoBehavior::class,
                'model' => $this->getModelName(),
                'view_category' => '',
                'view_action' => 'site/page',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'view'], 'required'],
            [['title', 'view'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['status', 'clicks'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'title'   => 'Title',
            'content' => 'Content',
            'status'  => 'Publish',
            'clicks' => 'Clicks',
            'view' => 'View'
        ];
    }
}
