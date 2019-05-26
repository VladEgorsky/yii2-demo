<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertise_tag".
 *
 * @property int $tag_id
 * @property int $advertise_id
 *
 * @property Advertise $advertise
 * @property Tag $tag
 */
class AdvertiseTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertise_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'advertise_id'], 'required'],
            [['tag_id', 'advertise_id'], 'integer'],
            [['tag_id', 'advertise_id'], 'unique', 'targetAttribute' => ['tag_id', 'advertise_id']],
            [['advertise_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertise::className(), 'targetAttribute' => ['advertise_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'advertise_id' => 'Advertise ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertise()
    {
        return $this->hasOne(Advertise::className(), ['id' => 'advertise_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
