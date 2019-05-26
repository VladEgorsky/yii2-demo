<?php

namespace common\models;

use Yii;
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
 * @property string $target_url
 *
 * @property Section[] $sections
 * @property Tag[] $tags
 */
class Advertise extends BaseModel
{
    const STATUS_NEW = 0;
    const STATUS_PROCESSED = 1;
    const LOCATION_RIGHT = 1;
    const LOCATION_BOTTOM = 2;

    public $_files;
    public $img_file;

    protected static $statuses = [
        self::STATUS_NEW       => 'New',
        self::STATUS_PROCESSED => 'Processed',
    ];
    protected static $locations = [
        0 => '#N/A',
        self::LOCATION_RIGHT => 'Right bar',
        self::LOCATION_BOTTOM => 'Bottom bar',
    ];
    protected $isSeoRequired = false;

    /**
     * @return string
     */
    public function getLocation($key = null)
    {
        if (is_null($key)) {
            return static::$locations[$this->location_id];
        }

        return static::$locations[$key] ?? '#N/A';
    }

    /**
     * @return array
     */
    public static function getLocationListData()
    {
        return static::$locations;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'content'], 'required'],
            [['name', 'email', 'target_url'], 'string', 'max' => 255],
            ['target_url', 'url', 'defaultScheme' => 'http'],
            ['email', 'email'],
            [['content'], 'string'],
            [['status', 'created_at', 'clicks', 'location_id'], 'integer'],
            ['files', 'file', 'extensions' => [
                'png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'xls', 'xlsx', 'pdf'
            ], 'maxFiles' => 10],
            ['img_file', 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxFiles' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'location_id' => 'Location',
            'content' => 'Content',
            'files' => 'Files',
            'img_file' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'clicks' => 'Clicks',
            'target_url' => 'Target URL',
        ];
    }

    /**
     * @return array|null
     */
    public function getFiles($namesOnly = false)
    {
        $list = null;
        $files = Json::decode($this->files);

        if ($files) {
            $prefix = $namesOnly ? '' : '/uploads/user_data/advertise/' . $this->id . '/';

            foreach ($files as $file) {
                $list[] = $prefix . $file;
            }
        }

        return $list;
    }

    /**
     * @param bool $nameOnly
     * @return null|string
     */
    public function getImage($nameOnly = false)
    {
        if (!$this->image) {
            return null;
        }

        $prefix = $nameOnly ? '' : '/uploads/user_data/advertise/' . $this->id . '/';
        return $prefix . $this->image;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::class, ['id' => 'section_id'])->viaTable('advertise_section', ['advertise_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('advertise_tag', ['advertise_id' => 'id']);
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

    public function getSectionAndTags()
    {
        $list = '';
        $sectionList = $this->getSectionsList();
        if (!empty($sectionList)) {
            $list .= "SECTIONS: \n" . implode(", ", $sectionList);
        }

        $tagList = $this->getTagsList();
        if (!empty($tagList)) {
            if (!empty($sectionList)) {
                $list .= "\n";
            }

            $list .= "TAGS: \n" . implode(", ", $tagList);
        }

        return $list;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert)
            $this->created_at = time();

//        if ($this->files) {
//            $this->_files = $this->files;
//            $list = [];
//            foreach ($this->files as $file)
//                $list[] = $file->name;
//
//            $this->files = $list;
//        }
//        $this->files = Json::encode($this->files);

        if ($this->img_file) {
            $this->image = $this->img_file->name;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\base\ErrorException
     * @throws \yii\base\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
//        if ($this->_files)
//            foreach ($this->_files as $file)
//                $file->saveAs($path . $file->name);

        if ($this->img_file) {
            $path = Yii::$app->basePath . '/../frontend/web/uploads/user_data/advertise/' . $this->id . '/';
            FileHelper::removeDirectory($path);
            FileHelper::createDirectory($path);

            $this->img_file->saveAs($path . $this->img_file->name);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     *
     */
    public function afterDelete()
    {
        $path = Yii::$app->basePath . '/../frontend/web/uploads/user_data/advertise/' . $this->id . '/';
        FileHelper::removeDirectory($path);
        parent::afterDelete();
    }
}
