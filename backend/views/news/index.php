<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Y;
use backend\models\News;
use kartik\date\DatePicker;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'News';
$this->blocks['content_header'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
$sections = \backend\models\Section::getListData();
?>

<div class="news-index">
    <?= Html::a('Create News', ['create'], ['class' => 'btn btn-primary', 'style' => 'margin-left: 10px;']) ?>
    <?= Html::button('Sort', ['type' => 'button', 'class' => 'btn btn-success',
        'style' => 'margin-left: 10px;', 'onclick' => 'alert("Drag and drop rows to sort the grid")'])
    ?>

    <?php Pjax::begin(['id' => 'grid_news_pjax']); ?>
    <?= SortableGridView::widget([
        'id' => 'grid_news',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'sortUrl' => Url::to(['sortItem']),
        'columns' => [
            ['attribute' => 'id', 'filter' => false],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.y'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy',
                    ]
                ]),
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'options' => [
                    'style' => [
                        'max-width' => '350px',
                    ],
                ],
            ],
            [
                'attribute' => 'short_content',
                'format' => 'raw',
                'options' => [
                    'style' => [
                        'max-width' => '350px',
                    ],
                ],
            ],
            [
                'attribute' => 'section_id',
                'label' => 'Locations',
                'format' => 'raw',
                'filter' => $sections,
                'value' => function ($model) {
                    /** @var $model backend\models\News */
                    return $model->getLocationNames();
                }
            ],
            [
                'attribute' => 'cover_image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Y::getBoolValueAsCheckboxIcon($model->cover_image);
                },
                'filter' => false
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => News::getStatusListData(),
                'label' => 'Visibility',
                'value' => function ($model) {
                    return Y::getBoolValueAsCheckboxIcon($model->status);
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    return [
                        'class' => 'status_checkbox',
                        'data-value' => $model->status,
                        'style' => 'cursor: pointer;'
                    ];
                },
            ],
            'clicks',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->can('admin')
                    ? '{view} {update} {delete}' : '{view} {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    <!-- For using in js below -->
    <input type="hidden" id="ajax_update_model_url" name="hi1" value="<?= Url::to(['/auxx/ajax-update-model']) ?>"/>
    <input type="hidden" id="model_class" name="hi2" value="<?= addcslashes(News::class, '\\') ?>"/>
</div>

<?php
$newsIndexJs = <<< JS
    // Change News.status inside the grid
    $(document).on("click", "#grid_news .status_checkbox", function () {
        var modelId = $(this).closest("tr").data("key");
        var newValue = ($(this).data("value") === 1 ? 0 : 1);
        var data = {
            classname: $("#model_class").val(),
            attributes: {
                id: modelId, status: newValue
            },
            validate: "0"
        };
        
        var url = $("#ajax_update_model_url").val();
        main.makeAjaxRequest(url, data, {pjaxSelector: "#grid_news_pjax"});
    });
JS;

$this->registerJs($newsIndexJs);
