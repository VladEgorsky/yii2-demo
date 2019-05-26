<?php
/**
 * @var $section array
 * For Upper Block and all other Sections (except Video & Pic of the day) also
 * !!! HERE WE USE $section['topNews'] ONLY !!!
 *
 * [id => [
 *      title,
 *      topNews => [
 *          // frontend\models\News
 *          Model1, Model2, Model3, Model4, Model5,
 *      ],
 *      itemClasses => [
 *          // For each model
 *          'news big-news', 'news', 'news-tall', 'news', 'news'
 *      ],
 *      nextOffset,
 *      pagetemplate_id
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

$countNewsForPlayer = count($section['topNews']);
if ($countNewsForPlayer == 0) {
    echo '<div>Not exist in Database</div>';
    return true;
}

$topVideo = $section['topNews'][0]
?>

    <div class="player">
        <div class="vidcontainer">
            <iframe id="myiframe" src="<?= $topVideo->cover_video ?>" frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>

            <video id="myvid" src="">
                Your browser does not support the video tag.
            </video>

            <div class="topControl">
                <div class="progress">
                    <span class="bufferBar"></span>
                    <span class="timeBar"></span>
                </div>

                <div class="time">
                    <span class="current"></span> / <span class="duration"></span>
                </div>

                <div class="btnPlay" title="Play/Pause video"></div>
                <div class="sound sound2 btn"></div>

                <div class="volume_line" title="Set volume">
                    <div class="volume">
                        <span class="volumeBar"></span>
                    </div>
                </div>

                <div class="btnFS" title="full screen"></div>
            </div>

            <div class="bigplay" title="play the video"></div>
        </div>

        <div id="video_name">
            <?= Html::encode($topVideo->title) ?>
        </div>

        <div class="videolist scrollert">
            <nav class="vids scrollert-content">

                <?php if ($countNewsForPlayer > 1) : ?>
                    <?php for ($i = 0; $i < $countNewsForPlayer; $i++) : ?>

                        <?php $model = $section['topNews'][$i] ?>
                        <?php $title = Html::encode($model->title) ?>
                        <?php //$newsUrl = Url::to(['/news/view', 'id' => $model->id]) ?>
                        <?php $videoUrl = $model->cover_video ? $model->cover_video : '' ?>
                        <?php $imgUrl = $model->getImageUrl('95x75') ?>
                        <?php $style = $imgUrl ? 'background-image: url(' . $imgUrl . ')' : '' ?>
                        <?php $titleMaxLength = News::$tiles['news news-no-img-big']['titleMaxLength'] ?>

                        <a class="link" href="<?= $videoUrl ?>" title="<?= $title ?>">
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

<div class="player">
    <div class="">
        <video id="myvid" src="">
            Your browser does not support the video tag.
        </video>

        <div class="topControl">
            <div class="progress">
                <span class="bufferBar"></span>
                <span class="timeBar"></span>
            </div>

            <div class="time">
                <span class="current"></span> / <span class="duration"></span>
            </div>

            <div class="btnPlay" title="Play/Pause video"></div>
            <div class="sound sound2 btn"></div>

            <div class="volume_line" title="Set volume">
                <div class="volume">
                    <span class="volumeBar"></span>
                </div>
            </div>

            <div class="btnFS" title="full screen"></div>
        </div>

        <div class="bigplay" title="play the video"></div>
    </div>

    <div id="video_name">
        <?= Html::encode($section['topNews'][0]->title) ?>
    </div>

    <div class="videolist scrollert">
        <nav class="vids scrollert-content">
            <?php if ($countNewsForPlayer > 1) : ?>
                <?php for ($i = 0; $i < $countNewsForPlayer; $i++) : ?>

                    <?php $model = $section['topNews'][$i] ?>
                    <?php $title = Html::encode($model->title) ?>
                    <?php $newsUrl = Url::to(['/news/view', 'id' => $model->id]) ?>
                    <?php $videoUrl = $model->cover_video ? $model->cover_video : '' ?>
                    <?php $imgUrl = $model->getImageUrl('95x75') ?>
                    <?php $style = $imgUrl ? 'background-image: url(' . $imgUrl . ')' : '' ?>
                    <?php $titleMaxLength = News::$tiles['news news-no-img-big']['titleMaxLength'] ?>

                    <a class="link" href="<?= $videoUrl ?>" title="<?= $title ?>">
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