<?php
/**
 * @var $model \frontend\models\News
 * @var $section_id int
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

\frontend\widgets\SeoDataWidget::widget(['model' => $model]);
$seo = \common\modules\seo\models\Seo::getSEOData(Url::current());
?>

<div class="container">
    <div class="news_page">
        <div class="news_content w_full">
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
                <?= \ymaker\social\share\widgets\SocialShare::widget([
                    // Default settings are in /config/container.php
                    'url' => yii\helpers\Url::current([], true),
                    'title' => $this->title,
                    'description' => $seo->description ?? false,
                ]); ?>

                <div class="content">
                    <?= Html::encode($model->content); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="partner_content">
        <div class="tags">
            <span>Tags:</span>

            <?php
            $tags = $model->tags;
            if ($tags) {
                foreach ($tags as $tag) {
                    echo Html::a($tag->title, [$tag->seoUrl]);
                }
            }
            ?>
        </div>

        <?= \ymaker\social\share\widgets\SocialShare::widget([
            // Default settings are in /config/container.php
            'url' => yii\helpers\Url::current([], true),
            'title' => $this->title,
            'description' => $seo->description ?? false,
        ]); ?>

        <?= \frontend\widgets\AdvertiseWithUsWidget::widget(['sectionId' => $section_id]) ?>
    </div>
</div>

<?php // \frontend\widgets\CommentWidget::widget(['model' => $model]) ?>

<!--<div class="partner_content">-->
<?php // \frontend\widgets\AdvertiseWithUsWidget::widget(['sectionId' => $section_id]) ?>
<!--</div>-->
