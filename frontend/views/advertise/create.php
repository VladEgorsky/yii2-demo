<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Advertise */
/* @var $saved bool */

$this->title = 'Advertise with us';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
    <div class="text_page">
        <div class="text_page_content">
            <header>
                <h1>Advertise with us</h1>
            </header>

            <div class="text_page_text">
                <div class="content">
                    <p>The Siberian Times is keen to offer space on our English language web portal to the owners and
                        managers of the Siberian businesses, and officials of Siberia's great cities and regions, who
                        are interested in presenting themselves in good English to the outside world.</p>
                    <p>From banner advertising on our website, to sponsorship deals and stories about your business or
                        region (marked: Sponsored or Advertising Feature), we will make sure that you will get a clear,
                        concise, effective message about your company in modern colloquial English.</p>
                    <p>Email us on <b>advertise@siberiantimes.com</b> in English and Russian.</p>

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
                        ['placeholder' => 'Message']) ?>

                    <div class="files_line">
                        <output id="list"></output>
                    </div>

                    <div class="btn_block">
                        <div class="file_style">
                            <input type="file" id="files" name="Advertise[img_file]"/>
                            <div class="mask"><span>Attach image &nbsp; </span></div>
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
