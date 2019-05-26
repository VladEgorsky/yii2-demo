<?php

namespace frontend\widgets;

use frontend\models\Advertise;
use frontend\models\News;
use frontend\models\Section;
use yii\base\Widget;

class RightBarWidget extends Widget
{
    public $news = [];
    public $pageTemplateId;
    public $sectionId;
    public $tagId;
    public $advertiseModel;

    public function init()
    {
        $route = \Yii::$app->controller->route;
        switch ($route) {
            case 'video/index' :
                $this->pageTemplateId = Section::PAGE_TEMPLATE_VIDEO;
                break;
            case 'picture/index' :
                $this->pageTemplateId = Section::PAGE_TEMPLATE_PICTUREOFTHEDAY;
                break;
            default :
                $this->pageTemplateId = Section::PAGE_TEMPLATE_STANDART;
        }

        $limit = News::RIGHT_PANEL_WITH_PREVIEW_NEWS_NUMBER
            + News::RIGHT_PANEL_WITHOUT_PREVIEW_NEWS_NUMBER;

        if ($this->sectionId) {
            $this->news = $this->getNewsBySection($limit);
            $this->advertiseModel = Advertise::getLastModelBySectionId($this->sectionId, Advertise::LOCATION_RIGHT);
        } elseif ($this->tagId) {
            $this->news = $this->getNewsByTag($limit);
            $this->advertiseModel = Advertise::getLastModelByTagId($this->tagId, Advertise::LOCATION_RIGHT);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $newsWithPreview = array_slice($this->news, 0, News::RIGHT_PANEL_WITH_PREVIEW_NEWS_NUMBER);
        $newsWithoutPreview = array_slice($this->news, News::RIGHT_PANEL_WITH_PREVIEW_NEWS_NUMBER);

        return $this->render('right_bar', [
            'newsWithPreview' => $newsWithPreview,
            'newsWithoutPreview' => $newsWithoutPreview,
            'pageTemplateId' => $this->pageTemplateId,
            'advertiseModel' => $this->advertiseModel,
        ]);
    }

    /**
     * @param $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function getNewsBySection($limit)
    {
        return News::find()->joinWith('newsSection')->orderBy(['clicks' => SORT_DESC])
            ->where(['news_section.section_id' => $this->sectionId, 'news.status' => News::STATUS_VISIBLE])
            ->limit($limit)->all();
    }

    /**
     * @param $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function getNewsByTag($limit)
    {
        return News::find()->joinWith('newsTag')->orderBy(['clicks' => SORT_DESC])
            ->where(['news_tag.tag_id' => $this->tagId, 'news.status' => News::STATUS_VISIBLE])
            ->limit($limit)->all();
    }
}