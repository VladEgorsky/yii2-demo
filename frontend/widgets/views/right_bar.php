<?php
/**
 * @var $this \yii\web\View
 * @var $newsWithPreview array
 * @var $newsWithoutPreview array
 * @var $pageTemplateId int
 * @var $advertiseModel \frontend\models\Advertise
 */

use frontend\models\Section;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>

<div class="right_bar">
    <div class="right_bar_title">
        <h3>Top news</h3>
    </div>


    <?php if (!empty($newsWithPreview)) : ?>
        <?php foreach ($newsWithPreview as $news) : ?>

        <div class="news news-min">
            <a href="<?= Url::to(['news/view', 'id' => $news->id]) ?>">
                <?php
                $imgUrl = $news->getImageUrl('80x64');
                $style = $imgUrl ? 'background-image: url(' . $imgUrl . ')' : '';
                ?>
                <div class="bg" style="">
                    <div class="image" style="<?= $style ?>"></div>
                </div>

                <div class="description">
                    <h2 class="title"><?= StringHelper::truncate(Html::encode($news->title), 55) ?></h2>
                </div>
            </a>
        </div>

    <?php endforeach; ?>
    <?php endif; ?>


    <div class="news_list">
        <?php if (!empty($newsWithoutPreview)) : ?>
            <?php foreach ($newsWithoutPreview as $news) : ?>

            <div class="news news-no-img">
                <a href="<?= Url::to(['news/view', 'id' => $news->id]) ?>">
                    <div class="description">
                        <h2 class="title"><?= StringHelper::truncate(Html::encode($news->title), 55) ?></h2>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
        <?php endif; ?>
    </div>


    <?php if ($advertiseModel && $advertiseModel->image) : ?>
        <div class="adv">
            <?php $href = $advertiseModel->target_url ?? '#123' ?>

            <a href="<?= $href ?>" target="_blank">
                <img src="<?= $advertiseModel->getImage() ?>" alt="">
            </a>

        </div>
    <?php endif; ?>
</div>
