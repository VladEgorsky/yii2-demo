<?php

namespace frontend\widgets;

use frontend\models\Section;
use yii\base\Widget;

class NewsBlockWidget extends Widget
{
    /*
     * @var $section array
     * For Upper Block and all other Sections also
     *
     * [id1 => [
     *      title1,
     *      topModels => [
     *          // frontend\models/News
     *          Model1, Model2, Model3, Model4, Model5 ...
     *      ],
     *      itemClasses1 => [
     *          // For each model
     *          'news big-news', 'news', 'news-tall', 'news', 'news'
     *      ],
     *      nextOffset1,
     *      pagetemplate_id1
     * ]]
     *
     *
     * @var $activeTagsListData array
     *      [id1 => name1, id2 => name2]
     */
    public $section;

    /**
     * @var $activeTagsListData array
     *      [id1 => name1, id2 => name2]
     */
    public $activeTagsListData;

    public function run()
    {
        switch ($this->section['pagetemplate_id']) {
            case Section::PAGE_TEMPLATE_VIDEO :
                $viewFileName = 'news_block_video';
                break;

            case Section::PAGE_TEMPLATE_PICTUREOFTHEDAY :
                $viewFileName = 'news_block_pictureoftheday';
                break;

            default :
                $viewFileName = 'news_block_standart';
                break;
        }

        return $this->render($viewFileName, [
            'section' => $this->section,
            'activeTagsListData' => $this->activeTagsListData
        ]);
    }
}