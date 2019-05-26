<?php
/* @var $this yii\web\View */
/* @var $model backend\models\News */

use backend\models\News;
use backend\models\Tag;
use common\components\Y;
use backend\models\Section;
use kartik\select2\Select2;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper as ArrayHelperAlias;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $this->title = 'Create News';
    $this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->blocks['content_header'] = 'Update News';
    $this->title = 'Update News: ' . $model->title;
    $this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'Update';
}
?>

<div class="news-update">
    <h3><?= Html::encode($this->title) ?></h3>


    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= \common\modules\seo\widgets\SeoWidget::widget(['model' => $model]) ?>

    <?php // Hidden field to display other error messages except validation errors  ?>
    <?= Html::activeHiddenInput($model, 'id') ?>

    <?php // Hidden field for using in js/controllers/news.js  ?>
    <?= Html::hiddenInput('noimage_url', News::NOIMAGE_URL, ['id' => 'noimage_url']) ?>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropDownList($model->getStatusListData()) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?php $container = Yii::$container->getDefinitions()[Select2::class]; ?>

            <?= $form->field($model, 'sectionList')->widget(Select2::class,
                ArrayHelperAlias::merge($container, [
                'data' => Section::getListData(['status' => Section::STATUS_VISIBLE], ['title' => SORT_ASC]),
            ]))->label('Sections') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'tagList')->widget(Select2::class,
                ArrayHelperAlias::merge($container, [
                'data' => Tag::getListData(['status' => Tag::STATUS_VISIBLE], ['title' => SORT_ASC]),
                    'pluginOptions' => [
                        'tags' => true,
                    ],
            ]))->label('Tags') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Html::activeLabel($model, 'cover_image') ?>

            <div class="cover_image_container">
                <?php
                echo Html::activeHiddenInput($model, 'cover_image');

                $imgWidth = News::$tiles['news news-min']['img']['width'] . 'px';
                $imgHeight = News::$tiles['news news-min']['img']['height'] . 'px';
                $imgUrl = $model->cover_image ? $model->cover_image : News::NOIMAGE_URL;
                $img = Html::img($imgUrl, ['style' => "width: $imgWidth; height: $imgHeight"]);
                echo Html::a($img, $imgUrl, ['class' => 'preview', 'target' => '_blank']);

                echo InputFile::widget([
                    'buttonTag' => 'a',
                    'buttonName' => 'Select photo',
                    'controller' => 'elfinder',
                    'filter' => 'image',
                    'name' => 'cover_image',
                    'value' => '',
                    'template' => '{button}<span style="display: none">{input}</span>',
                    'options' => ['class' => 'uploaded_image'],
                    'buttonOptions' => [
                        'class' => 'btn btn-default',
                        'style' => 'vertical-align: top; margin: 0 15px 0 15px',
                    ],
                    'multiple' => false
                ]);

                $deleteButtonStyle = 'vertical-align: top;';
                if (!$model->cover_image) {
                    $deleteButtonStyle .= ' display: none;';
                }

                echo Html::a('Delete', '#', [
                    'class' => 'btn btn-default remove-image', 'style' => $deleteButtonStyle,
                ]);
                ?>
            </div>

            <?php /*
        <?= $form->field($model, 'cover_image',
            ['template' => '{label}{input}', 'options' => ['class' => '']])->hiddenInput() ?>

        <img src="<?php if ($model->isNewRecord || !$model->cover_image) { ?>/img/no-image.png<?php } else {
            echo $model->cover_image;
        } ?>" alt="" width="200" style="margin-bottom: 15px" class="selected-image">

        <?php
        $buttonsTemplate = '<div class="flex-row">{button}<span style="display: none">{input}</span>';

        if ($model->cover_image) {
            $buttonsTemplate .= ' &nbsp; <a href="#" class="btn btn-default remove-image">Delete</a>';
        }
        $buttonsTemplate .= '</div>';
        ?>
        <?= InputFile::widget([
            'buttonTag' => 'a',
            'buttonName' => 'Select photo',
            'controller' => 'elfinder',
            'filter' => 'image',
            'name' => 'cover_image',
            'value' => '',
            'template' => $buttonsTemplate,
            'options' => ['class' => 'form-control image-select'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => false
        ]);
        ?>
        */ ?>

        </div>

        <div class="col-md-5">
            <?= $form->field($model, 'cover_video')->textInput(['maxlength' => true])
                ->label('Type Youtube or Vimeo URL to assign Cover Video. OR click here -->') ?>
        </div>

        <div class="col-md-1">
            <?= $form->field($model, 'uploadedVideo', ['labelOptions' => ['style' => 'cursor: pointer']])
                ->fileInput(['id' => 'input_type_file', 'style' => 'opacity:0', ])
                ->label('to upload local video') ?>
        </div>
    </div>

    <?= $form->field($model, 'short_content', ['options' => ['style' => 'margin-top: 15px']])
        ->textarea(['maxlength' => true, 'rows' => 3]) ?>

    <?= Y::getTinyMceWidget($form, $model, 'content') ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', Url::previous(), ['class' => 'btn btn-default', 'style' => 'margin-left: 10px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php
$newsUpdateJs = <<< JS
$("#input_type_file").on("change", function() {
    var uploadedFileType = this.files[0].type;
    
    if (uploadedFileType.indexOf("video") === -1) {
        alert("Incorrect file extension. Only video files allowed");
        return false;
    }
    
    var uploadedFileName = this.files[0].name;
    document.getElementById('news-cover_video').value = uploadedFileName;
    return true;
});
JS;

$this->registerJs($newsUpdateJs);
