<?php
return [
    'definitions' => [
        yii\grid\GridView::class => [
            'summaryOptions' => ['tag' => 'span', 'class' => 'pull-right'],
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-sm',
            ],
        ],
        richardfan\sortable\SortableGridView::class => [
            'summaryOptions' => ['tag' => 'span', 'class' => 'pull-right'],
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-sm',
            ],
        ],
        lo\widgets\modal\ModalAjax::class => [
            'header' => null,
            'options' => ['class' => 'header-primary'],
            'size' => lo\widgets\modal\ModalAjax::SIZE_LARGE,
        ],
        kartik\select2\Select2::class => [
            'theme' => kartik\select2\Select2::THEME_CLASSIC,
            'readonly' => true,
            'options' => [
                'placeholder' => 'Search',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'tokenSeparators' => [','],
                'allowClear' => true,
            ],
        ],
    ],
];

//return [
//    'definitions' => [
//        yii\grid\GridView::class => [
//            'summaryOptions' => ['tag' => 'span', 'class' => 'pull-right'],
//            'tableOptions' => [
//                'class' => 'table table-striped table-bordered table-sm',
//            ],
//        ],
//        richardfan\sortable\SortableGridView::class => [
//            'summaryOptions' => ['tag' => 'span', 'class' => 'pull-right'],
//            'tableOptions' => [
//                'class' => 'table table-striped table-bordered table-sm',
//            ],
//        ],
//        lo\widgets\modal\ModalAjax::class => [
//            'header' => null,
//            'options' => ['class' => 'header-primary'],
//            'size' => lo\widgets\modal\ModalAjax::SIZE_LARGE,
//        ],
//        kartik\select2\Select2::class => [
//            'theme' => kartik\select2\Select2::THEME_CLASSIC,
//            'options' => [
//                'placeholder' => 'Search',
//                'multiple' => true,
//            ],
//            'pluginOptions' => [
//                'tokenSeparators' => [','],
//                'allowClear' => true,
//            ],
//            'readonly' => true,
//        ],
//    ],
//];
