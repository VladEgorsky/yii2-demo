<?php

namespace frontend\widgets;

use frontend\models\Comment;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: yurik
 * Date: 10.09.18
 * Time: 8:03
 */
class CommentWidget extends Widget
{

    public $model;

    public function run()
    {
        $model = new Comment();
        $searchModel = new Comment();
        $searchModel->news_id = $this->model->id;
        $dataProvider = $searchModel->search();

        return $this->render('_comments', [
            'newsModel'    => $this->model,
            'dataProvider' => $dataProvider,
            'model'        => $model,
        ]);
    }
}