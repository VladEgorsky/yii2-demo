<?php

namespace frontend\widgets;

use yii\base\Widget;

class VideoPlayerWidget extends Widget
{
    public $newsForPlayer;

    public function run()
    {
        return $this->render('video_player', [
            'newsForPlayer' => $this->newsForPlayer,
        ]);
    }
}