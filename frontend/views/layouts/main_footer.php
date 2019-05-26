<?php

use yii\helpers\Url;

?>

<?php if (Yii::$app->request->cookies->getValue('cookie_policy_clicked') == 'on') : ?>
    <div class="cookies">
        <div class="container">
            <p>
                We use cookies to improve your experience on our site and to show you relevant advertising.
                <br>
                To find out more, read our updated <a href="<?= Url::to(['/site/page', 'view' => 'privacy']) ?>">privacy
                    and cookie policy</a>.
            </p>
            <div class="border_button close">Ok</div>
        </div>
    </div>
<?php endif; ?>

    <footer>
        <div class="container">
            <div class="daily_email">
                <span>Sign up to our daily e-mail</span>
                <div class="form">
                    <?php //= \frontend\widgets\SubscribeWidget::widget() ?>
                    <?= \yii\helpers\Html::a('Subscribe', Url::to(['/site/subscribe']), ['id' => 'sub_form']) ?>
                </div>
            </div>

            <div class="follow">
                <span>Follow us, read us, like us</span>

                <?php $seo = \common\modules\seo\models\Seo::getSEOData(Url::current()) ?>

                <?= \ymaker\social\share\widgets\SocialShare::widget([
                    // Default settings are in /config/container.php
                    'url' => yii\helpers\Url::current([], true),
                    'title' => $this->title,
                    'description' => $seo->description ?? false,
                ]); ?>
            </div>

            <div class="link_list">
                <a href="<?= Url::to(['/site/page', 'view' => 'about']) ?>">About us</a>
                <a href="<?= Url::to(['/site/contribute']) ?>">Make a contribution</a>
                <div class="clear"></div>
                <a href="<?= Url::to(['/story/create']) ?>">Send us a story</a>
                <a href="<?= Url::to(['/advertise/create']) ?>">Advertise with us</a>
            </div>

            <div class="copy">
                <span>© 2018 The Siberian Times. All rights reserved.</span>

                <a href="https://fresco.bz/" target="_blank" class="dev">
                    <img src="/img/icons/fresco-logo.svg" alt="fresco">
                </a>
            </div>
        </div>
    </footer>

<?php
$expires = Yii::$app->params['cookiePolicyClickedExpires'];
$main_footer_js = <<< JS
    $("div.cookie .close").on("click", function() {
        Cookies.set("cookie_policy_clicked", "on", { expires: parseInt("$expires") });
    });
JS;

$this->registerJs($main_footer_js);