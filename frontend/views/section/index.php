<?php
/**
 * @var $model /frontend/models/Section
 * @var $data array
 *      [title, itemsClasses, topNews, nextOffset, pagetemplate_id]
 * @var $activeTagsListData array
 *      [id1 => name1, id2 => name2]
 */

use frontend\models\Template;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="container">
    <div class="categories_list">

        <div class="category education-cut">
            <div class="header">
                <div class="name">
                    <h1><?= Html::encode($model->title) ?></h1>
                </div>
            </div>

            <div class="content">
                <div class="news_list_container" data-packery='{ "itemSelector": ".news", "gutter": 24 }'>
                    <?= \frontend\widgets\NewsBlockWidget::widget([
                        'section' => $data,
                        'activeTagsListData' => $activeTagsListData
                    ]) ?>
                </div>

                <?= \frontend\widgets\RightBarWidget::widget(['sectionId' => $model->id]) ?>
            </div>

            <div class="partner_content content content_footer">
                <?= \frontend\widgets\AdvertiseWithUsWidget::widget(['sectionId' => $model->id]) ?>

                <?= \frontend\widgets\GetMoreNewsButton::widget([
                    'location_key' => Template::LOCATION_SECTION,
                    'url' => Url::to(['/site/get-more-news']),
                    'location_id' => $model->id,
                    'nextOffset' => $data['nextOffset'],
                    'pagetemplate_id' => $data['pagetemplate_id'],
                ]) ?>
            </div>
        </div>
    </div>
</div>
