<?php

namespace frontend\models;

use Yii;
use yii\helpers\FileHelper;
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
class Story extends \common\models\Story
{
    public $_files;

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert)
            $this->created_at = time();

        if ($this->files) {
            $this->_files = $this->files;
            $list = [];
            foreach ($this->files as $file)
                $list[] = $file->name;

            $this->files = $list;
        }

        $this->files = Json::encode($this->files);

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
        if ($this->_files) {
            $path = Yii::$app->basePath . '/../frontend/web/uploads/user_data/story/' . $this->id . '/';
            FileHelper::removeDirectory($path);
            FileHelper::createDirectory($path);

            foreach ($this->_files as $file) {
                $file->saveAs($path . $file->name);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

}