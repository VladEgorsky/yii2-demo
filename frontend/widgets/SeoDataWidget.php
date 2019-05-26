<?php
/**
 * Created by PhpStorm.
 * User: yurik
 * Date: 11.09.18
 * Time: 8:21
 */

namespace frontend\widgets;


use yii\base\Widget;

class SeoDataWidget extends Widget
{

    public $model;

    public function run()
    {
        return $this->render('_seo_data', [
            'model' => $this->model
        ]);
    }
}