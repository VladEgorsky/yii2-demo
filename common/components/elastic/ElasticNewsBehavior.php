<?php
/**
 * Created by PhpStorm.
 * Date: 15.09.18
 */

namespace common\components\elastic;

use backend\models\News;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class ElasticNewsBehavior
 * @package common\components\elastic
 */
class ElasticNewsBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'addToSearch',
            ActiveRecord::EVENT_AFTER_UPDATE => 'addToSearch',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteFromSearch',
        ];
    }

    /**
     *
     */
    public function deleteFromSearch($event)
    {
        $model = $event->sender;

        $params = [
            'index' => 'news_index',
            'type'  => 'news_type',
            'id'    => $model->id,
        ];

        try {
            \Yii::$app->elastic->delete($params);
        } catch (\Exception $e) {
        };

    }

    public function addToSearch($event)
    {
        $model = $event->sender;

        /**
         * @var $model News
         */

        $image = $model->getImage();

        if ($image) {
            $image = $image->getUrl('184x106');
        }

        $data = [
            'title'         => $model->title,
            'content'       => $model->content,
            'image'         => $image,
            'url'           => $model->seoUrl,
            'created_at'    => $model->created_at,
            'sections_list' => implode(', ', $model->getSectionsList()),
            'tags_list'     => implode(', ', $model->getTagsList()),
            'sections'      => $model->getSections()->select('id')->column(),
            'tags'          => $model->getTags()->select('id')->column(),
        ];

        $params = [
            'index' => 'news_index',
            'type'  => 'news_type',
            'id'    => $model->id,
            'body'  => $data,
        ];

        $s = [
            'index' => 'news_index',
            'type'  => 'news_type',
            'id'    => $model->id,
        ];

        try {
            $response = \Yii::$app->elastic->get($s);
        } catch (\Exception $e) {
            $response = null;
        }

        if ($response == null)
            \Yii::$app->elastic->add($params);
        else {
            unset($data['id']);
            $params = [
                'index' => 'news_index',
                'type'  => 'news_type',
                'id'    => $response['_id'],
                'body'  => [
                    'doc' => $data,
                ],
            ];

            \Yii::$app->elastic->update($params);

        }

    }

}