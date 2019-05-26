<?php
/**
 * @var $sectionModel \frontend\models\Section
 * @var $newsForSlider array
 * @var $newsForPage array
 * @var $nextOffset integer      for MORE button
 */

use frontend\models\News;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$countNewsForPage = count($newsForPage);
?>

<div class="container">
    <div class="header_slider">
        <h1><?= Html::encode($sectionModel->title) ?></h1>

        <?= \frontend\widgets\PicSliderWidget::widget([
            'newsForSlider' => $newsForSlider,
        ]) ?>
    </div>


    <div class="news_page">
        <div class="news_content">
            <?php if (!empty($countNewsForPage)) : ?>
                <?php for ($i = 0; $i < $countNewsForPage; $i++) : ?>

                    <?php $model = $newsForPage[$i] ?>
                    <?php $imgUrl = $model->getImageUrl('912x584', '') ?>
                    <?php $newsUrl = Url::to(['/picture/view', 'id' => $model->id, 'section_id' => $sectionModel->id]) ?>

                    <div class="news_prev">
                        <a href="<?= $newsUrl ?>">
                            <header>
                                <h1><?= Html::encode($model->title) ?></h1>

                                <div class="info_line">
                                    <div class="date">
                                        <span><?= Yii::$app->formatter->asDate($model->created_at, 'long') ?></span>
                                    </div>
                                    <div class="reporter">
                                        <span><?= $model->author ?></span>
                                    </div>
                                </div>
                            </header>

                            <div class="news_text">
                                <div class="content">
                                    <img src="<?= $imgUrl ?>" alt="">
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endfor; ?>
            <?php endif; ?>
        </div>

        <?= \frontend\widgets\RightBarWidget::widget(['sectionId' => $sectionModel->id]) ?>
    </div>

    <div class="partner_content news_page">
        <?= \frontend\widgets\AdvertiseWithUsWidget::widget(['sectionId' => $sectionModel->id]) ?>
    </div>
</div>
