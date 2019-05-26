<?php
namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * This is the model class for table "story".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $content
 * @property string $files
 * @property int $status
 * @property int $created_at
 * @property int $clicks
 */
class Story extends BaseModel
{
    const STATUS_NEW = 0;
    const STATUS_PROCESSED = 1;

    protected static $statuses = [
        self::STATUS_NEW       => 'New',
        self::STATUS_PROCESSED => 'Processed',
    ];
    protected $isSeoRequired = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'story';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'content'], 'required'],
            ['email', 'email'],
            [['content'], 'string'],
            [['status', 'created_at', 'clicks'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            ['files', 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'rtf'], 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Name',
            'email'      => 'Email',
            'content'    => 'Content',
            'files'      => 'Files',
            'status'     => 'Status',
            'created_at' => 'Created At',
            'clicks' => 'Clicks',
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
            $prefix = $namesOnly ? '' : '/uploads/user_data/story/' . $this->id . '/';

            foreach ($files as $file) {
                $list[] = $prefix . $file;
            }
        }

        return $list;
    }

    /**
     * @return string|null
     */
    public function getFileLinks($target = '_blank')
    {
        $links = [];
        $files = Json::decode($this->files);

        if ($files) {
            foreach ($files as $file) {
                $links[] = Html::a($file, '/uploads/user_data/story/' . $this->id . '/' . $file, ['target' => $target]);
            }
        }

        return implode(', ', $links);
    }

    /**
     *
     */
    public function afterDelete()
    {
        FileHelper::removeDirectory(Yii::$app->basePath . '/../frontend/web/uploads/user_data/story/' . $this->id);
        parent::afterDelete();
    }
}
