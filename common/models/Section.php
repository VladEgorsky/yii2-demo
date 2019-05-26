<?php
namespace common\models;

use common\modules\seo\behaviors\SeoBehavior;

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
class Section extends BaseModel
{
    const STATUS_HIDDEN = 0;
    const STATUS_VISIBLE = 1;

    protected $isSeoRequired = true;
    protected static $nameField = 'title';
    protected static $statuses = [
        self::STATUS_HIDDEN => 'Hidden',
        self::STATUS_VISIBLE => 'Visible',
    ];

    const PAGE_TEMPLATE_STANDART = 0;
    const PAGE_TEMPLATE_PICTUREOFTHEDAY = 1;
    const PAGE_TEMPLATE_VIDEO = 2;
    const PAGE_TEMPLATE_UPPER_BLOCK = 3;

    protected static $pageTemplates = [
        self::PAGE_TEMPLATE_STANDART => 'Standart',
        self::PAGE_TEMPLATE_PICTUREOFTHEDAY => 'Picture',
        self::PAGE_TEMPLATE_VIDEO => 'Video',
        self::PAGE_TEMPLATE_UPPER_BLOCK => 'Mainpage Upper Block',
    ];

    /**
     * @return array
     */
    public static function getPageTemplateListData()
    {
        return static::$pageTemplates;
    }

    /**
     * @return string
     */
    public function getPageTemplate($key = null)
    {
        if (is_null($key)) {
            return static::$pageTemplates[$this->pagetemplate_id] ?? '#N/A';
        }

        return static::$pageTemplates[$key] ?? '#N/A';
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
                'view_action' => 'section/index',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['ordering', 'status', 'pagetemplate_id'], 'integer'],
            //[['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['ordering', 'default', 'value' => static::find()->max('ordering') + 1],
            ['mainmenu', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'ordering' => 'Ordering',
            'status' => 'Status',
            'pagetemplate_id' => 'Page template',
            'mainmenu' => 'Mainmenu'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['id' => 'news_id'])->viaTable('news_section', ['section_id' => 'id']);
    }

}
