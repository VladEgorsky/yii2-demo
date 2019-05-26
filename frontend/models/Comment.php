<?php

namespace frontend\models;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $news_id
 * @property string $user_name
 * @property string $user_address
 * @property string $comment
 * @property int $rate
 * @property int $status
 * @property int $created_at
 *
 */
class Comment extends \common\models\Comment
{
    public $captcha;

    /**
     * @return array
     */
//    public function rules()
//    {
//        return ArrayHelper::merge(parent::rules(),
//            [
//                ['captcha', 'required'],
//                ['captcha', 'captcha', 'captchaAction' => '/comment/captcha'],
//            ]
//        );
//    }

    /**
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere([
            'news_id' => $this->news_id,
            'status'  => static::STATUS_VISIBLE,
        ]);

        $query->orderBy('id desc');

        return $dataProvider;
    }
}
