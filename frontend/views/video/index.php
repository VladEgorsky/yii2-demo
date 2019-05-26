<?php
/**
 * @var $sectionModel \frontend\models\Section
 * @var $newsForSlider array
 * @var $newsForPage array
 * @var $tileClasses array
 * @var $nextOffset integer      for MORE button
 */

use frontend\models\News;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$countNewsForPage = count($newsForPage);
?>

<div class="container">
    <div class="header_player">
        <h1><?= Html::encode($sectionModel->title) ?></h1>

        <?= \frontend\widgets\VideoPlayerWidget::widget([
            'newsForPlayer' => $newsForSlider,
        ]) ?>
    </div>

    <div class="news_page">
        <div class="news_content categories_list">

            <div class="category travel-cut">
                <div class="header">
                    <div class="name">
                        <h1>Must see</h1>
                    </div>
                </div>

                <div class="content">
                    <div class="news_list_container" data-packery='{ "itemSelector": ".news", "gutter": 24 }'>

                        <?= \frontend\widgets\NewsBlockWidget::widget([
                            'newsModels' => $newsForPage, 'tileClasses' => $tileClasses
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>

        <?= \frontend\widgets\RightBarWidget::widget(['sectionId' => $sectionModel->id]) ?>
    </div>

    <div class="partner_content news_page">
        <?= \frontend\widgets\AdvertiseWithUsWidget::widget(['sectionId' => $sectionModel->id]) ?>
    </div>
</div>
