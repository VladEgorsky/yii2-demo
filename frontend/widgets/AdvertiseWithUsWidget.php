<?php

namespace frontend\widgets;

use frontend\models\Advertise;
use yii\base\Widget;

class AdvertiseWithUsWidget extends Widget
{
    public $sectionId;
    public $tagId;
    public $advertiseModel;

    public function init()
    {
        if ($this->sectionId) {
            $this->advertiseModel = Advertise::getLastModelBySectionId($this->sectionId, Advertise::LOCATION_BOTTOM);
        } elseif ($this->tagId) {
            $this->advertiseModel = Advertise::getLastModelByTagId($this->tagId, Advertise::LOCATION_BOTTOM);
        }
    }

    public function run()
    {
        if ($this->advertiseModel && $this->advertiseModel->image) {
            return $this->render('advertise_with_us', ['advertiseModel' => $this->advertiseModel]);
        }
    }
}