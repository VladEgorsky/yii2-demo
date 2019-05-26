<?php
/**
 * @var $section array
 * For Upper Block and all other Sections (except Video & Pic of the day) also
 * !!! HERE WE USE $section['topNews'] ONLY !!!
 *
 * [id1 => [
 *      title1,
 *      topNews1 => [
 *          // frontend\models\News
 *          Model1, Model2, Model3, Model4, Model5,
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

use common\models\News;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

// First Image must be placed in <div class="full_size_img"> (left side)
// First + Other images in <div class="picturelist scrollert"> (right side)
$countNewsForSlider = count($section['topNews']);
if ($countNewsForSlider == 0) {
    echo '<div>Not exist in Database</div>';
    return true;
}

$topPicture = $section['topNews'][0];
?>

    <div class="slider">
        <div class="full_size_img">
            <img src="<?= $topPicture->getImageUrl('832x468') ?>" alt="" id="full_size_img">
        </div>
        <div id="pictere_name"><?= Html::encode($topPicture->title) ?></div>

        <div class="picturelist scrollert">
            <nav class="pics scrollert-content">

                <?php if ($countNewsForSlider > 1) : ?>
                    <?php for ($i = 0; $i < $countNewsForSlider; $i++) : ?>

                        <?php $model = $section['topNews'][$i] ?>
                        <?php $title = Html::encode($model->title) ?>
                        <?php $imgUrl = $model->getImageUrl('832x468') ?>
                        <?php //$newsUrl = Url::to(['/picture/view', 'id' => $model->id]) ?>
                        <?php $style = $imgUrl ? 'background-image: url(' . $imgUrl . ')' : '' ?>
                        <?php $titleMaxLength = News::$tiles['news news-no-img-big']['titleMaxLength'] ?>

                        <a class="link" href="<?= $imgUrl ?>" title="<?= $title ?>">
                            <div class="prev">
                                <div class="img" style="<?= $style ?>"></div>
                            </div>
                            <span><?= StringHelper::truncate($title, $titleMaxLength) ?></span>
                        </a>

                    <?php endfor; ?>
                <?php endif; ?>

            </nav>
        </div>
    </div>


<?php /*
<div class="slider">
    <div class="full_size_img">
        <?php $model = $section['topNews'][0] ?>
        <?php $imgUrl = $model->getImageUrl('832x468', '') ?>

        <img src="<?= $imgUrl ?>" alt="" id="full_size_img">
    </div>
    <div id="pictere_name">
        <?= Html::encode($model->title) ?>
    </div>

    <div class="picturelist scrollert">
        <nav class="pics scrollert-content">

            <?php if ($countNewsForSlider > 1) : ?>
                <?php for ($i = 0; $i < $countNewsForSlider; $i++) : ?>

                    <?php $model = $section['topNews'][$i] ?>
                    <?php $title = Html::encode($model->title) ?>
                    <?php $imgUrl = $model->getImageUrl('832x468') ?>
                    <?php $newsUrl = Url::to(['/picture/view', 'id' => $model->id]) ?>
                    <?php $style = $imgUrl ? 'background-image: url(' . $imgUrl . ')' : '' ?>
                    <?php $titleMaxLength = News::$tiles['news news-no-img-big']['titleMaxLength'] ?>

                    <a class="link" href="<?= $newsUrl ?>" title="<?= $title ?>">
                        <div class="prev">
                            <div class="img" style="<?= $style ?>"></div>
                        </div>
                        <span><?= StringHelper::truncate($title, $titleMaxLength) ?></span>
                    </a>

                <?php endfor; ?>
            <?php endif; ?>

        </nav>
    </div>
</div>
*/ ?>