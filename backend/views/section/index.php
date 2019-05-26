<?php
/**
 * @var $this yii\web\View
 * @var $searchModel backend\models\search\SectionSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use common\components\Y;
use backend\models\Section;
use richardfan\sortable\SortableGridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Sections';
$this->blocks['content_header'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="section-index">
    <?= Html::a('New Section', Url::to(['create']), ['class' => 'btn btn-primary', 'style' => 'margin-left: 10px;']) ?>
    <?= Html::button('Sort', ['type' => 'button', 'class' => 'btn btn-success',
        'style' => 'margin-left: 10px;', 'onclick' => 'alert("Drag and drop rows to sort the grid")'])
    ?>

    <?php Pjax::begin(['id' => 'grid_section_pjax']); ?>
    <?= SortableGridView::widget([
        'id' => 'grid_section',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'sortUrl' => Url::to(['sortItem']),
        'columns' => [
            'title',
            [
                'attribute' => 'pagetemplate_id',
                'format' => 'raw',
                'filter' => Section::getPageTemplateListData(),
                'label' => 'Page templates',
                'value' => function ($model) {
                    return $model->getPageTemplate();
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Section::getStatusListData(),
                'label' => 'Visibility',
                'value' => function ($model) {
                    return Y::getBoolValueAsCheckboxIcon($model->status);
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    return [
                        'class' => 'status_checkbox',
                        'data-attribute' => 'status',
                        'data-value' => $model->status,
                        'style' => 'cursor: pointer;'
                    ];
                },
            ],
            [
                'attribute' => 'mainmenu',
                'format' => 'raw',
                'filter' => false,
                'value' => function ($model) {
                    return Y::getBoolValueAsCheckboxIcon($model->mainmenu);
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    return [
                        'class' => 'mainmenu_checkbox',
                        'data-attribute' => 'mainmenu',
                        'data-value' => $model->mainmenu,
                        'style' => 'cursor: pointer;'
                    ];
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} &nbsp; {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    <!-- For using in js below -->
    <input type="hidden" id="ajax_update_model_url" name="hi1" value="<?= Url::to(['/auxx/ajax-update-model']) ?>"/>
    <input type="hidden" id="model_class" name="hi2" value="<?= addcslashes(Section::class, '\\') ?>"/>
</div>

<?php
$sectionIndexJs = <<< JS
    // Change Section.status or Section.mainmenu inside the grid
    $(document).on("click", "#grid_section .status_checkbox, #grid_section .mainmenu_checkbox", function () {
        var attribute = $(this).data("attribute");      // status or mainmenu
        var newValue = ($(this).data("value") === 1 ? 0 : 1);
        
        var dopData = {};
        dopData['id'] = $(this).closest("tr").data("key");
        dopData[attribute] = newValue;
        
        var data = {
            classname: $("#model_class").val(),
            attributes: dopData,
            validate: "0"
        };
        
        var url = $("#ajax_update_model_url").val();
        main.makeAjaxRequest(url, data, {pjaxSelector: "#grid_section_pjax"});
    });
JS;

$this->registerJs($sectionIndexJs);