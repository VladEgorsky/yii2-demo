<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Story */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $model backend\models\Story */
/* @var $saved */

$this->title = 'Send us a story';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
    <div class="text_page">
        <div class="text_page_content">
            <header>
                <h1>Send us a story</h1>
            </header>

            <div class="text_page_text">
                <div class="content">
                    <p>We want to hear about your experience of living in Siberia, or traveling there, and to receive
                        tips about interesting stories from the region which you believe are worth writing.</p>
                    <p>Send us a message via the form below, in Russian or English, or email
                        <b>news@siberiantimes.com</b></p>

                    <?= Html::beginForm('', 'post', [
                        'class' => 'form',
                        'id' => 'validate_form',
                        'enctype' => 'multipart/form-data',
                    ]) ?>
                    <div class="line">
                        <div class="required_field">
                            <?= Html::activeTextInput($model, 'name',
                                ['maxlength' => true, 'placeholder' => 'Name', 'required' => 'required']) ?>
                        </div>

                        <div class="required_field">
                            <?= Html::activeTextInput($model, 'email',
                                ['maxlength' => true, 'placeholder' => 'E-mail', 'required' => 'required']) ?>
                        </div>
                    </div>

                    <?= Html::activeTextarea($model, 'content',
                        ['placeholder' => 'Message', 'required' => 'required']) ?>

                    <div class="files_line">
                        <output id="list"></output>
                    </div>

                    <div class="btn_block">
                        <div class="file_style">
                            <?= Html::activeFileInput($model, 'files[]',
                                ['id' => 'files', 'multiple' => true]) ?>

                            <div class="mask"><span>Attach file</span></div>
                        </div>

                        <?= Html::submitInput('Submit', ['class' => 'btn_with_bg']) ?>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <?= \frontend\widgets\RightBarWidget::widget() ?>
    </div>
</div>