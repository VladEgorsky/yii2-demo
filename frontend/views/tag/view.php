<?php
/**
 * Created by PhpStorm.
 * @var $model \common\models\Tag
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
\frontend\widgets\SeoDataWidget::widget(['model' => $model]);
?>
<h1><?= $model->title ?></h1>

<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => '_news'
]) ?>
