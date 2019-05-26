<?php
/**
 * @var advertiseModel \frontend\models\Advertise
 */

$href = $advertiseModel->target_url ?? '#123';
?>


<div class="partners_link_line">
    <a href="<?= $href ?>" target="_blank">
        <img src="<?= $advertiseModel->getImage() ?>" alt="">
    </a>

    <div class="develop_together">
        <a href="<?= \yii\helpers\Url::to(['advertise/create']) ?>" class="border_button">Advertise with us</a>
    </div>
</div>