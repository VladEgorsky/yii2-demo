<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head lang="<?= Yii::$app->language ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?= $this->render('main_header') ?>
<?= $content ?>
<?= $this->render('main_alert') ?>
<?= $this->render('main_footer') ?>

<?php registerFlashMessages($this) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<?php
function registerFlashMessages($view)
{
    $session = Yii::$app->session;
    $flashes = $session->getAllFlashes();
    $alertMessage = '';

    foreach ($flashes as $type => $flash) {
        foreach ((array)$flash as $i => $message) {
            $message = str_replace("'", "", $message);
            $message = str_replace("\"", "", $message);
            $glue = empty($alertMessage) ? '' : "<br />";
            //$alertMessage .= $glue . $message;
            $alertMessage .= addslashes($message);
        }

        $session->removeFlash($type);
    }

    if (!empty($alertMessage)) {
        $alertWinsowClass = ($type == 'success') ? 'alert successfully' : 'alert fail';

        $js = <<< JS
        
$("#main_alert_window p").html("$alertMessage");       
$("#main_alert_window").removeClass("alert successfully fail hide").addClass("$alertWinsowClass");
JS;

        $view->registerJs($js);
    }
}
