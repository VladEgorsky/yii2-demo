<?php
/*
 * @var $model \frontend\models\StaticPage
 */

?>

<div class="container">

    <div class="text_page">
        <div class="text_page_content">
            <header>
                <h1><?= $model->title ?></h1>
            </header>

            <div class="text_page_text">
                <div class="content">
                    <?= $model->content ?>
                </div>
            </div>
        </div>

        <?= \frontend\widgets\RightBarWidget::widget() ?>
    </div>
</div>
