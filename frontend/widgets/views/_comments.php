<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $model \frontend\models\Comment
 * @var $newsModel \common\models\News
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <div class="comments">
        <div class="comments_content">
            <h3>Comments (<?= $dataProvider->totalCount ?>)</h3>

            <?php
            if ($dataProvider->totalCount > 0) {
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_comment_view',
                ]);
            }
            ?>

            <div class="add_comment">
                <h3>Add your comment</h3>
                <p>We welcome a healthy debate, but do not accept offensive or abusive comments.<br>
                    Please also read ‘The Siberian Times’ <a href="#PrivacyPolicy">Privacy Policy</a>.</p>

                <?= Html::beginForm(Url::to(['/comment/add', 'id' => $newsModel->id]),
                    'post', ['class' => 'form', 'id' => 'validate_form']) ?>
                <div class="line">
                    <div class="required_field">
                        <?= Html::activeTextInput($model, 'user_name',
                            ['maxlength' => true, 'placeholder' => 'Name', 'required' => 'required']) ?>
                    </div>

                    <div class="required_field">
                        <?= Html::activeTextInput($model, 'user_address',
                            ['maxlength' => true, 'placeholder' => 'Town/Country', 'required' => 'required']) ?>
                    </div>
                </div>

                <?= Html::activeTextArea($model, 'comment',
                    ['placeholder' => 'Message', 'required' => 'required']) ?>

                <div class="btn_block">
                    <?= Html::submitInput('Submit', ['class' => 'btn_with_bg']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>

        <div class="right_bar">
            <div class="adv">
                <a href="#123" target="_blank">
                    <img src="/img/av1.jpg" alt="">
                </a>
            </div>
        </div>
    </div>


<?php
$jsCommentWidget = <<<JS
    $("#validate_form").on("submit", function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr("action");
        var data = form.serialize();
        
        // See code in /frontend/views/layout/main.php
        $.post(url, data, function(result) {
            if (result == "ok") {
                $("#main_alert_window p").html("Your comment has been successfully added and will be published after moderation");       
                $("#main_alert_window").removeClass("alert successfully fail hide").addClass("alert successfully");
                form.trigger("reset");
            } else {
                $("#main_alert_window p").html(result);       
                $("#main_alert_window").removeClass("alert successfully fail hide").addClass("alert fail");
            }
        });
        
        return false;
    });
JS;

$this->registerJs($jsCommentWidget);
