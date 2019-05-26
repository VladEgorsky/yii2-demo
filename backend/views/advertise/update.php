<?php
/* @var $this yii\web\View */
/* @var $model backend\models\Advertise */

use backend\models\Advertise;
use common\models\Section;
use common\models\Tag;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$title = $model->isNewRecord ? 'Create New Advertise' : 'Update Advertise'
?>

<div class="advertise-update">
    <h3><?= $title ?></h3>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php // Hidden field to display other error messages except validation errors  ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-6']])
            ->label('Author')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'col-md-6']])
            ->textInput(['maxlength' => true]) ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'target_url', ['options' => ['class' => 'col-md-6']])
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status', ['options' => ['class' => 'col-md-3']])
            ->dropDownList(Advertise::getStatusListData()) ?>

        <?= $form->field($model, 'location_id', ['options' => ['class' => 'col-md-3']])
            ->dropDownList(Advertise::getLocationListData()) ?>
    </div>


    <div class="row">
        <?php $container = Yii::$container->getDefinitions()[Select2::class]; ?>

        <?= $form->field($model, 'sectionList', ['options' => ['class' => 'col-md-6']])
            ->widget(Select2::class,
                ArrayHelper::merge($container, [
                'data' => Section::getListData(['status' => Section::STATUS_VISIBLE], ['title' => SORT_ASC]),
                ]))->label('Sections') ?>

        <?= $form->field($model, 'tagList', ['options' => ['class' => 'col-md-6']])
            ->widget(Select2::class,
                ArrayHelper::merge($container, [
                'data' => Tag::getListData(['status' => Tag::STATUS_VISIBLE], ['title' => SORT_ASC]),
                ]))->label('Tags') ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'content', ['options' => ['class' => 'col-md-12']])
            ->textarea(['rows' => 8]) ?>
    </div>


    <?php /*= Y::getTinyMceWidget($form, $model, 'content', ['rows' => 8]); */ ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', Url::previous(), ['class' => 'btn btn-default', 'style' => 'margin-left: 10px;']) ?>
    </div>

    <?php $style = $model->image ? 'display: block; max-height: 200px;' : 'max-height: 200px;'; ?>

    <div class="form-group">
        <img src="<?= $model->getImage() ?>" id="advertise_image" style="<?= $style ?>"/>
        <input type="file" id="input_type_file" name="Advertise[img_file]"/>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$advertiseUpdateJs = <<<JS
    function showFile(e) {
        var file = e.target.files[0];
        if (!file.type.match('image.*')) return false;
        
        var fr = new FileReader();
        fr.onload = (function(theFile) {
            return function(e) {
                var image = document.getElementById('advertise_image');
                image.src = e.target.result;
            };
      })(file);
    
      fr.readAsDataURL(file);
    }
    
    document.getElementById('input_type_file').addEventListener('change', showFile, false);
JS;

$this->registerJs($advertiseUpdateJs);