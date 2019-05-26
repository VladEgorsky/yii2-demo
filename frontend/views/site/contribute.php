<?php
/**
 * Created by PhpStorm.
 */

use yii\helpers\Url;

?>

    <div class="container">
        <div class="text_page">
            <div class="text_page_content">
                <header>
                    <h1>Contribute</h1>
                </header>

                <div class="text_page_text">
                    <div class="content">
                        <p>Make a monthly commitment to support The Siberian Times long term or a one-time contribution
                            as and when you feel like it — choose the option that suits you best.</p>

                        <form action="<?= Yii::$app->params['paypal']['url'] ?>" method="post"
                              id="contribution-form" class="contribute_form">

                            <!-- Identify your business so that you can collect the payments. -->
                            <input type="hidden" name="business" value="<?= Yii::$app->params['paypal']['email'] ?>">

                            <!-- Specify a Donate button. -->
                            <input type="hidden" name="cmd" value="_donations">

                            <div class="toggle-radio">

                        <span>
                            <input id="monthly" type="radio" name="period" checked="checked">
                            <label for="monthly">
                                Monthly
                            </label>
                        </span>
                                <span>
                            <input id="oneoff" type="radio" name="period">
                            <label for="oneoff">
                                One-off
                            </label>
                        </span>
                                <div class="toggle-highlight" style=""></div>
                            </div>

                            <div class="toggle-radio_delimer">
                        <span>
                            <input id="amount-1" type="radio" name="amount" checked="checked">
                            <label class="Switcher" for="amount-1">
                                $5
                            </label>
                        </span>
                                <span>
                            <input id="amount-2" type="radio" name="amount">
                            <label class="Switcher" for="amount-2">
                                $10
                            </label>
                        </span>
                                <span>
                            <input id="amount-3" type="radio" name="amount">
                            <label class="Switcher" for="amount-3">
                                $20
                            </label>
                        </span>
                                <span>
                            <input id="amount-4" type="number" placeholder="$ Other amount" name="amount" min="1">
                        </span>
                            </div>

                            <div class="toggle-radio">
                        <span>
                            <input id="paypal" type="radio" name="payment" checked="checked">
                            <label for="paypal">
                                PayPal
                            </label>
                        </span>
                                <span>
                            <input id="card" type="radio" name="payment">
                            <label for="card">
                                Card
                            </label>
                        </span>
                                <div class="toggle-highlight" style=""></div>
                            </div>

                            <div class="btn_block">
                                <input class="contribute_btn" type="submit" value="Contribute">
                            </div>
                        </form>

                        <p>By proceeding, you are agreeing to our
                            <a href="<?= Url::to(['/site/page', 'view' => 'terms']) ?>">Terms and Conditions</a>.
                            To find out what personal data we collect and how we use it, please visit our
                            <a href="<?= Url::to(['/site/page', 'view' => 'policy']) ?>">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
            </div>

            <?= \frontend\widgets\RightBarWidget::widget() ?>
        </div>
    </div>

    <!--    <div style="padding-top: 100px"></div>-->
    <!--    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="contribution-form">-->
    <!---->
    <!--        <!-- Identify your business so that you can collect the payments. -->
    <!--        <input type="hidden" name="business"-->
    <!--               value="solomin@fresco.bz">-->
    <!---->
    <!--        <!-- Specify a Donate button. -->
    <!--        <input type="hidden" name="cmd" value="_donations">-->
    <!---->
    <!--        <!-- Specify details about the contribution -->
    <!--        <!--    <input type="hidden" name="item_name" value="Friends of the Park">-->
    <!--        <!--    <input type="hidden" name="item_number" value="Fall Cleanup Campaign">-->
    <!---->
    <!--        <label for="cn1">-->
    <!--            <input class="c-amount" type="radio" name="pay_amount" value="5" id="cn1" checked>-->
    <!--            5$-->
    <!--        </label>-->
    <!--        <label for="cn2">-->
    <!--            <input class="c-amount" type="radio" name="pay_amount" value="10" id="cn2">-->
    <!--            10$-->
    <!--        </label>-->
    <!--        <label for="cn3">-->
    <!--            <input class="c-amount" type="radio" name="pay_amount" value="20" id="cn3">-->
    <!--            20$-->
    <!--        </label>-->
    <!---->
    <!--        <input type="text" class="c-amount" placeholder="$ Other amount">-->
    <!---->
    <!--        <input type="hidden" name="amount" value="5" id="amount">-->
    <!--        <input type="hidden" name="currency_code" value="USD">-->
    <!---->
    <!--        <div>-->
    <!--            <button type="submit" class="btn btn-success">Contribute</button>-->
    <!--        </div>-->
    <!--    </form>-->
    <!---->
    <!---->
<?php
//$this->registerJs(
//    <<<JS
//            $(document).on('change', '.c-amount', function() {
//              $('#amount').val($(this).val());
//            })
//
//JS
//
//)
?>