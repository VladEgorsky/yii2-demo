<?php
namespace common\models;

use common\modules\seo\behaviors\SeoBehavior;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property string $cover_image
 * @property string $cover_video
 * @property string $author
 * @property int $comment_count
 * @property int $ordering
 * @property int $status
 * @property int $created_at
 * @property int $clicks
 *
 * @property Section[] $sections
 * @property \yii\db\ActiveQuery $seo
 * @property array $tagsList
 * @property null|string $seoUrl
 * @property Tag[] $tags
 */
class News extends BaseModel
{
    const STATUS_HIDDEN = 0;
    const STATUS_VISIBLE = 1;
    const COVER_VIDEO_URL_PREFIX = 'uploads/video/';

    // To upload local video except Youtube or Vimeo
    public $uploadedVideo;

    protected $isSeoRequired = true;
    protected static $nameField = 'title';
    protected static $statuses = [
        self::STATUS_HIDDEN => 'Hidden',
        self::STATUS_VISIBLE => 'Visible',
    ];

    public static $tiles = [
        'news news-big' => [
            'titleMaxLength' => 70,
            'shortDescriptionMaxLength' => 130,
            'img' => [
                'width' => 605, 'height' => 383,
                'size' => '605x383', 'position' => 'standart'
            ],
            'newsLabel' => ['position' => 'beforeDivClassDescription'],
        ],
        'news' => [
            'titleMaxLength' => 80,
            'shortDescriptionMaxLength' => 0,
            'img' => [
                'width' => 297, 'height' => 184,
                'size' => '297x184', 'position' => 'standart'
            ],
            'newsLabel' => ['position' => 'beforeDivClassDescription'],
        ],
        'news news-tall' => [
            'titleMaxLength' => 65,
            'shortDescriptionMaxLength' => 90,
            'img' => [
                'width' => 288, 'height' => 165,
                'size' => '288x165', 'position' => 'standart'
            ],
            'newsLabel' => ['position' => 'afterDivClassBg'],
        ],
        'news news-tall news-tall-selected' => [
            'titleMaxLength' => 55,
            'shortDescriptionMaxLength' => 85,
            'img' => [
                'width' => 288, 'height' => 165,
                'size' => '288x165', 'position' => 'standart'
            ],
            'newsLabel' => ['position' => 'afterDivClassBg'],
        ],
        'news news-wide' => [
            'titleMaxLength' => 65,
            'shortDescriptionMaxLength' => 110,
            'img' => [
                'width' => 288, 'height' => 190,
                'size' => '288x190', 'position' => 'right'
            ],
            'newsLabel' => ['position' => 'afterDivClassBg'],
        ],
        'news news-wide news-wide-l_img' => [
            'titleMaxLength' => 65,
            'shortDescriptionMaxLength' => 110,
            'img' => [
                'width' => 288, 'height' => 190,
                'size' => '288x190', 'position' => 'left'
            ],
            'newsLabel' => ['position' => 'afterDivClassBg'],
        ],
        'news news-min' => [
            'titleMaxLength' => 55,
            'shortDescriptionMaxLength' => 0,
            'img' => [
                'width' => 80, 'height' => 64,
                'size' => '80x64', 'position' => 'left'
            ],
            'newsLabel' => false,
        ],
        'news news-min news-min-right' => [
            'titleMaxLength' => 55,
            'shortDescriptionMaxLength' => 0,
            'img' => [
                'width' => 80, 'height' => 64,
                'size' => '80x64', 'position' => 'right'
            ],
            'newsLabel' => false,
        ],
        'news news-no-img-big' => [
            'titleMaxLength' => 70,
            'shortDescriptionMaxLength' => 110,
            'img' => false,
            'newsLabel' => false,
        ],
        'news news-no-img-big news-no-img-big-selected' => [
            'titleMaxLength' => 55,
            'shortDescriptionMaxLength' => 55,
            'img' => false,
            'newsLabel' => false,
        ],
    ];


    /**
     * @return array
     * @throws \ReflectionException
     */
    public function behaviors()
    {
        return [
            'seo'   => [
                'class' => SeoBehavior::class,
                'model' => $this->getModelName(),
                'view_category' => 'news',
                'view_action' => 'news/view',
            ],
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['short_content', 'content'], 'string'],
            [['comment_count', 'ordering', 'status', 'clicks'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'cover_image', 'cover_video', 'author'], 'string', 'max' => 255],
            [['uploadedVideo'], 'file', 'extensions' => ['mpeg', 'mp4', 'ogg', 'wmv', 'flv'], 'maxFiles' => 1],
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
            'short_content' => 'Short Content',
            'content' => 'Content',
            'cover_image' => 'Cover Image',
            'cover_video' => 'Cover Video',
            'author' => 'Author',
            'comment_count' => 'Comment Count',
            'ordering' => 'Ordering',
            'status' => 'Status',
            'created_at' => 'Date',
            'clicks' => 'Clicks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::class, ['id' => 'section_id'])->viaTable('news_section', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('news_tag', ['news_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getTagsList()
    {
        $list = [];

        if ($this->tags)
            foreach ($this->tags as $tag) {
                $list[] = $tag->title;
            }

        return $list;
    }

    /**
     * @return array
     */
    public function getSectionsList()
    {
        $list = [];

        if ($this->sections)
            foreach ($this->sections as $section) {
                $list[] = $section->title;
            }

        return $list;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($changedAttributes['cover_image'])) {
            $this->removeImages();      // See rico\yii2images\behaviors\ImageBehave
        }

        if ($this->cover_image) {
            $coverImage = str_replace('%20', ' ', $this->cover_image);
            $this->attachImage(Yii::getAlias('@frontend') . '/web' . $coverImage, true);
        }

        $this->uploadVideo($changedAttributes);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param $changedAttributes
     * @return bool
     *
     * 1. Delete existing uploaded file (except Youtube or Vimeo)
     * 2. Upload new file if not empty $this->uploadedVideo
     * 3. Save Youtube or Vimeo Url if exists and empty $this->uploadedVideo
     */
    public function uploadVideo($changedAttributes)
    {
        if (!empty($changedAttributes['cover_video'])) {
            $this->deleteUploadedVideo($changedAttributes['cover_video']);
        }

        if (!$this->uploadedVideo) {
            return true;
        }

        $path = $this->getVideoPath();
        $newVideo = $this->uploadedVideo->baseName . uniqid() . '.' . $this->uploadedVideo->extension;
        $this->uploadedVideo->saveAs($path . $newVideo);
        $this->updateAttributes(['cover_video' => $this->getVideoUrl($newVideo)]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        $this->removeImages();          // See rico\yii2images\behaviors\ImageBehave
        $this->deleteUploadedVideo($this->cover_video);

        parent::afterDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * @param $filename
     * @return bool
     *
     * Delete file if exists. Here can be uploaded file only, not Youtube or Vimeo
     */
    public function deleteUploadedVideo($filename)
    {
        $videoFile = $this->getVideoPath($filename);
        if (is_file($videoFile)) {
            unlink($videoFile);
        }

        return true;
    }

    public function getVideoPath($filename = null)
    {
        $path = Yii::getAlias('@webroot') . DS . self::COVER_VIDEO_URL_PREFIX;
        return is_null($filename) ? $path : $path . $filename;
    }

    /**
     * @param $filename
     * @return string
     *
     * Substitute prefix for uploaded files.
     * Youtube and Vimeo taking as is
     */
    public function getVideoUrl($filename)
    {
        $file = Yii::getAlias('@webroot') . DS . self::COVER_VIDEO_URL_PREFIX . $filename;
        return is_file($file)
            ? Yii::getAlias('@web') . DS . self::COVER_VIDEO_URL_PREFIX . $filename
            : $filename;
    }

    /**
     * @param string $size '80x64' for example
     * @return bool
     */
    public function getImageUrl($size, $defaultValue = false)
    {
        $img = $this->getImage();       // See rico\yii2images\behaviors\ImageBehave
        return $img ? $img->getUrl($size) : $defaultValue;
    }
}
