<?php
/**
 * @var $model frontend\models\Subscribe
 */

use yii\helpers\Html;

?>

<div class="container">

    <div class="text_page">
        <div class="text_page_content">
            <header>
                <h1>Don't send me news</h1>
            </header>

            <div class="text_page_text">
                <div class="content">
                    <?= Html::beginForm('', 'post', ['class' => 'form']) ?>
                    <div class="name_mail">
                        <p>Are you sure you want to unsubscribe from all the free newsletters.</p>
                        <div class="input-2">
                            <div>
                                <?= Html::activeTextInput($model, 'name', [
                                    'readonly' => 'readonly'])
                                ?>
                            </div>
                            <div>
                                <?= Html::activeTextInput($model, 'email', [
                                    'readonly' => 'readonly'])
                                ?>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="btn_block">
                        <input class="btn_with_bg" type="submit" value="Unsubscribe">
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <?= \frontend\widgets\RightBarWidget::widget() ?>
    </div>

</div>
