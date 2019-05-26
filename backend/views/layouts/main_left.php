<?php
/**
 * @var $this \yii\web\View
 * @var $directoryAsset string
 */

use yii\helpers\ArrayHelper;

$menuItems = [
    [
        'label' => Yii::t('app', 'News'),
        'icon' => 'newspaper-o',
        'url' => ['/news/index']
    ],
    [
        'label' => Yii::t('app', 'Sections'),
        'icon' => 'bookmark',
        'url' => ['/section/index']
    ],
    [
        'label' => Yii::t('app', 'Tags'),
        'icon' => 'hashtag',
        'url' => ['/tag/index']
    ],
    [
        'label' => Yii::t('app', 'Static pages'),
        'icon' => 'file',
        'url' => ['/static-page/index']
    ],
    [
        'label' => Yii::t('app', 'Comments'),
        'icon' => 'comments-o',
        'url' => ['/comment/index']
    ],
    [
        'label' => Yii::t('app', 'Subscribe'),
        'icon' => 'rss-square',
        'url' => ['/subscribe/index']
    ],
    [
        'label' => Yii::t('app', 'User stories'),
        'icon' => 'file',
        'url' => ['/story/index']
    ],
    [
        'label' => Yii::t('app', 'User advertise'),
        'icon' => 'file',
        'url' => ['/advertise/index']
    ],
    [
        'label' => Yii::t('app', 'Logs'),
        'icon' => 'book',
        'url' => ['/log/index']
    ],
];

if (Yii::$app->user->can('admin')) {
    $menuItems = ArrayHelper::merge(
        $menuItems,
        [
            [
                'label' => Yii::t('app', 'Templates'),
                'icon' => 'edit',
                'url' => ['/template/index'],
            ],
            [
                'label' => Yii::t('app', 'Users'),
                'icon' => 'users',
                'items' => [
                    ['label' => 'User List', 'icon' => 'user-plus',
                        'url' => ['/user/index']],
                    ['label' => 'Routes', 'icon' => 'location-arrow',
                        'url' => ['/rbac/route']],
                    ['label' => 'Roles', 'icon' => 'user-circle-o',
                        'url' => ['/rbac/role']],
                    ['label' => 'Permissions', 'icon' => 'user-times',
                        'url' => ['/rbac/permission']],
                    ['label' => 'Rules', 'icon' => 'scissors',
                        'url' => ['/rbac/rule']],
                ],
            ],
        ]
    );
}

?>

<aside class="main-sidebar">
    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget([
            'activateItems' => true,
            'activateParents' => true,
            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
            'items' => $menuItems,
        ]) ?>

    </section>
</aside>
