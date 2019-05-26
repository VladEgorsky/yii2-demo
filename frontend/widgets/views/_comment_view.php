<?php
/**
 * Created by PhpStorm.
 * @var $model \frontend\models\Comment
 */

use yii\helpers\Html;

$rated = Yii::$app->session->get('comment_rate', []);

// Этот класс работает только с Bootstrap, в верстке его нет
$class = in_array($model->id, $rated) ? 'disabled' : '';
?>

    <div class="comment">
        <header>
            <div class="name"><span><?= Html::encode($model->user_name) ?></span></div>
            <div class="location"><span><?= Html::encode($model->user_address) ?></span></div>
            <div class="time"><span><?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i') ?></span>
            </div>
            <div class="rate">
                <button class="up" data-id="<?= $model->id ?>" data-rate="1"></button>
                <?php $rateClass = ($model->rate > 0) ? 'green' : 'red'; ?>
                <span class="<?= $rateClass ?>"><?= $model->rate ?></span>
                <button class="down" data-id="<?= $model->id ?>" data-rate="-1"></button>
            </div>
        </header>

        <p><?= \yii\helpers\HtmlPurifier::process($model->comment) ?></p>
</div>

<?php
$this->registerJs(
    <<<JS
    $(document).on('click', 'button.up, button.down', function() {
        var id = $(this).data('id');
        var rate = $(this).data('rate');
        var _this = $(this).parents('.rate');
        if(!_this.hasClass('disabled')) {
            $.get('/comment/rate', {id: id, rate: rate}, function(result) {
                var rateClass = (result > 0) ? "green" : "red";
                $("span", _this).removeClass("red green").addClass(rateClass).html(result);
                _this.addClass("disabled");
            });
        }

        return false;
    });

JS

)
?>