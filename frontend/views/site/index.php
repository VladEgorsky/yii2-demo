<?php
/**
 * @var $upperBlock array
 *      [id1 => [title1, itemsClasses1, topNews1, nextOffset1, pagetemplate_id1]]
 * @var $mainSections array
 *      [id1 => [title1, itemsClasses1, topNews1, nextOffset1, pagetemplate_id1],
 *          id2 => [title2, itemsClasses2, topNews2, nextOffset2, pagetemplate_id2]]
 * @var $activeTagsListData array
 *      [id1 => name1, id2 => name2]
 */

use frontend\models\Template;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use common\components\Y;

$sectionOrder = 0;
?>

<div class="container">
    <div class="last_top_news" data-packery='{ "itemSelector": ".news", "gutter": 12 }'>

        <?php foreach ($upperBlock as $section_id => $section) : ?>
            <?= \frontend\widgets\NewsBlockWidget::widget([
                'section' => $section,
                'activeTagsListData' => $activeTagsListData
            ]) ?>
        <?php endforeach; ?>

    </div>


    <div class="categories_list">
        <?php foreach ($mainSections as $section_id => $section) : ?>
            <?php //$categoryClass = 'category ' . Inflector::slug($section['title'], '_') . '-cut' ?>
            <?php $categoryClass = Y::getSectionClassName($sectionOrder++, '-cut') ?>

            <div class="category <?= $categoryClass ?>">
                <div class="header">
                    <div class="name show_hide">
                        <h1><?= Html::encode($section['title']) ?></h1>
                    </div>
                    <span class="border_button show_hide">Hide</span>
                </div>

                <div class="content">
                    <?php /*
                    <?php if ($section['pagetemplate_id'] == \common\models\Section::PAGE_TEMPLATE_PICTUREOFTHEDAY) : ?>
                        <?= \frontend\widgets\PicSliderWidget::widget([
                            'newsForSlider' => $section['topNews'],
                        ]) ?>
                        <div class="news_list_container" data-packery='{ "itemSelector": ".news", "gutter": 24 }'></div>

                    <?php elseif ($section['pagetemplate_id'] == \common\models\Section::PAGE_TEMPLATE_VIDEO) : ?>
                        <?= \frontend\widgets\VideoPlayerWidget::widget([
                            'newsForPlayer' => $section['topNews'],
                        ]) ?>
                        <div class="news_list_container" data-packery='{ "itemSelector": ".news", "gutter": 24 }'></div>

                    <?php else: ?>
                        <div class="news_list_container" data-packery='{ "itemSelector": ".news", "gutter": 24 }'>

                            <?= \frontend\widgets\NewsBlockWidget::widget([
                                'newsModels' => $section['topNews'],
                                'tileClasses' => $section['itemClasses'],
                                'sectionTitle' => $section['title'],
                            ]) ?>

                        </div>

                        <?= \frontend\widgets\RightBarWidget::widget(['sectionId' => $section_id]) ?>
                    <?php endif; ?>
*/ ?>

                    <?php if ($section['pagetemplate_id'] == \frontend\models\Section::PAGE_TEMPLATE_STANDART) : ?>
                    <div class="news_list_container" data-packery='{ "itemSelector": ".news", "gutter": 24 }'>
                        <?php endif; ?>

                        <?= \frontend\widgets\NewsBlockWidget::widget([
                            'section' => $section,
                            'activeTagsListData' => $activeTagsListData
                        ]) ?>

                        <?php if ($section['pagetemplate_id'] == \frontend\models\Section::PAGE_TEMPLATE_STANDART) : ?>
                    </div>
                <?= \frontend\widgets\RightBarWidget::widget(['sectionId' => $section_id]) ?>
                <?php endif; ?>
                </div>

                <div class="partner_content content content_footer">
                    <?= \frontend\widgets\AdvertiseWithUsWidget::widget(['sectionId' => $section_id]) ?>

                    <?php if ($section['pagetemplate_id'] == \frontend\models\Section::PAGE_TEMPLATE_STANDART) : ?>
                        <?= \frontend\widgets\GetMoreNewsButton::widget([
                            'location_key' => Template::LOCATION_MAINSECTION,
                            'url' => Url::to(['/site/get-more-news']),
                            'location_id' => $section_id,
                            'nextOffset' => $section['nextOffset'],
                            'pagetemplate_id' => $section['pagetemplate_id'],
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
