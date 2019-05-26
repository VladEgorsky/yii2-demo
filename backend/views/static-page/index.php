<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\StaticPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Y;
use backend\models\StaticPage;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Static Pages';
$this->blocks['content_header'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="static-page-index">
    <?= Html::a('New Static Page', Url::to(['create']), ['class' => 'btn btn-primary', 'style' => 'margin-left: 10px;']) ?>

    <?php Pjax::begin(['id' => 'grid_page_pjax']); ?>
    <?= GridView::widget([
        'id' => 'grid_page',
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'attribute' => 'id',
                'filter' => false,
            ],
            'title',
            'view',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StaticPage::getStatusListData(),
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
                'template' => '{update} &nbsp; {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

    <!-- For using in js below -->
    <input type="hidden" id="ajax_update_model_url" name="hi1" value="<?= Url::to(['/auxx/ajax-update-model']) ?>"/>
    <input type="hidden" id="model_class" name="hi2" value="<?= addcslashes(StaticPage::class, '\\') ?>"/>
</div>

<?php
$pageIndexJs = <<< JS
    // Change StaticPage.status inside the grid
    $(document).on("click", "#grid_page .status_checkbox", function () {
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
        main.makeAjaxRequest(url, data, {pjaxSelector: "#grid_page_pjax"});
    });
JS;

$this->registerJs($pageIndexJs);