<?php
/* @var $this yii\web\View */
/* @var $model backend\models\Subscribe */

use backend\models\Section;
use backend\models\Tag;
use common\models\Subscribe;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? 'Create Subscribe' : 'Update Subscribe';

?>


<div class="subscribe-update">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin(); ?>

    <?php // Hidden field to display other error messages except validation errors  ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-4']])
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status', ['options' => ['class' => 'col-md-2']])
            ->dropDownList(Subscribe::getStatusListData()) ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'col-md-4']])
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'period', ['options' => ['class' => 'col-md-2']])
            ->dropDownList(Subscribe::getPeriodListData(), ['disabled' => 'disabled']) ?>
    </div>


    <div class="row">
        <?= $form->field($model, 'sectionList', ['options' => ['class' => 'col-md-6']])
            ->widget(Select2::class, [
                'data' => ArrayHelper::map(Section::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Search', 'multiple' => true],
                'pluginOptions' => [
                    'tokenSeparators' => [','],
                    'allowClear' => true,
                ],
            ])->label('Sections') ?>

        <?= $form->field($model, 'tagList', ['options' => ['class' => 'col-md-6']])
            ->widget(Select2::class, [
                'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Search', 'multiple' => true],
                'pluginOptions' => [
                    'tokenSeparators' => [','],
                    'allowClear' => true,
                ],
                'readonly' => true,
            ])->label('Tags') ?>
    </div>

    <br/>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', Url::previous(), ['class' => 'btn btn-default', 'style' => 'margin-left: 10px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
