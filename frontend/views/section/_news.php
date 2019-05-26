<?php
/**
 * Created by PhpStorm.
 * @var $model \frontend\models\News
 */

$image = $model->getImage();

?>

<div>
    <?php if ($image) { ?>
        <?= \yii\helpers\Html::img($image->getUrl('300x200')) ?>
    <?php } ?>
    <?= \yii\helpers\Html::a($model->title, [$model->seoUrl]); ?>
</div>