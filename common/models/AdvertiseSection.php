<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertise_section".
 *
 * @property int $section_id
 * @property int $advertise_id
 *
 * @property Advertise $advertise
 * @property Section $section
 */
class AdvertiseSection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertise_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id', 'advertise_id'], 'required'],
            [['section_id', 'advertise_id'], 'integer'],
            [['section_id', 'advertise_id'], 'unique', 'targetAttribute' => ['section_id', 'advertise_id']],
            [['advertise_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertise::className(), 'targetAttribute' => ['advertise_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'section_id' => 'Section ID',
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
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }
}
