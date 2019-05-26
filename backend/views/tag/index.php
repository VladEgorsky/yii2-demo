<?php
/**
 * @var $this yii\web\View
 * @var $searchModel backend\models\search\TagsSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use common\components\Y;
use backend\models\Tag;
use lo\widgets\modal\ModalAjax;
use richardfan\sortable\SortableGridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Tags';
$this->blocks['content_header'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tag-index">
    <?= Html::a('New Tag', Url::to(['create']), ['class' => 'btn btn-primary', 'style' => 'margin-left: 10px;']) ?>
    <?= Html::button('Sort', ['type' => 'button', 'class' => 'btn btn-success',
        'style' => 'margin-left: 10px;', 'onclick' => 'alert("Drag and drop rows to sort the grid")'])
    ?>

    <?php Pjax::begin(['id' => 'grid_tag_pjax']); ?>
    <?= SortableGridView::widget([
        'id' => 'grid_tag',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'sortUrl' => Url::to(['sortItem']),
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
            ],
            'title',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Tag::getStatusListData(),
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
//            [
//                'attribute' => 'sections',
//                'value' => function ($model) {
//                    if (empty($model->sections)) {
//                        return '';
//                    }
//
//                    $titles = ArrayHelper::getColumn($model->sections, 'title');
//                    return implode(', ', $titles);
//                }
//            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} &nbsp; {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    <!-- For using in js below -->
    <input type="hidden" id="ajax_update_model_url" name="hi1" value="<?= Url::to(['/auxx/ajax-update-model']) ?>"/>
    <input type="hidden" id="model_class" name="hi2" value="<?= addcslashes(Tag::class, '\\') ?>"/>
</div>

<?php
$tagIndexJs = <<< JS
    // Change Tag.status inside the grid
    $(document).on("click", "#grid_tag .status_checkbox", function () {
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
        main.makeAjaxRequest(url, data, {pjaxSelector: "#grid_tag_pjax"});
    });
JS;

$this->registerJs($tagIndexJs);