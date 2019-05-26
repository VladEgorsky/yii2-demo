<?php

namespace frontend\widgets;

use yii\base\Widget;

class PicSliderWidget extends Widget
{
    public $newsForSlider;

    public function run()
    {
        return $this->render('pic_slider', [
            'newsForSlider' => $this->newsForSlider,
        ]);
    }
}