<?php
namespace backend\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "advertise".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $content
 * @property string $files
 * @property int $status
 * @property int $created_at
 */
class Advertise extends \common\models\Advertise
{
    public $tagList;
    public $sectionList;

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['tagList', 'sectionList'], 'safe'],
        ]);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->syncTags();
        $this->syncSections();

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function syncTags()
    {
        $ex = (new Query())
            ->select('tag_id')
            ->from('advertise_tag')
            ->where(['advertise_id' => $this->id])
            ->column();

        if (!$this->tagList)
            $this->tagList = [];

        $to_delete = array_diff($ex, $this->tagList);
        $to_add = array_diff($this->tagList, $ex);

        if (is_array($to_delete))
            Yii::$app->db->createCommand()->delete('advertise_tag', ['advertise_id' => $this->id, 'tag_id' => $to_delete])->execute();

        if (is_array($to_add)) {
            $toInsert = null;

            foreach ($to_add as $tagId) {
                if ($tagId)
                    $toInsert[] = [
                        $this->id,
                        $tagId
                    ];
            }

            //insert new sections
            if ($toInsert)
                \Yii::$app->db->createCommand()->batchInsert('advertise_tag', ['advertise_id', 'tag_id'], $toInsert)->execute();
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    public function syncSections()
    {
        $ex = (new Query())
            ->select('section_id')
            ->from('advertise_section')
            ->where(['advertise_id' => $this->id])
            ->column();

        if (!$this->sectionList)
            $this->sectionList = [];

        $to_delete = array_diff($ex, $this->sectionList);
        $to_add = array_diff($this->sectionList, $ex);

        if (is_array($to_delete))
            Yii::$app->db->createCommand()->delete('advertise_section', ['advertise_id' => $this->id, 'section_id' => $to_delete])->execute();

        if (is_array($to_add)) {
            $toInsert = null;

            foreach ($to_add as $sectionId) {
                if ($sectionId)
                    $toInsert[] = [
                        $this->id,
                        $sectionId
                    ];
            }

            //insert new sections
            if ($toInsert)
                \Yii::$app->db->createCommand()->batchInsert('advertise_section', ['advertise_id', 'section_id'], $toInsert)->execute();
        }
    }
}
