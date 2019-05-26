<?php
/**
 * @var $location_key string            MAINSECTION, SECTION, TAG
 * @var $buttonClass string
 * @var $buttonTitle string
 * @var $url string
 * @var $location_id integer
 * @var $nextOffset integer
 * @var $pagetemplate_id integer
 */

?>

<button class="<?= $buttonClass ?>" data-url="<?= $url ?>" data-location_id="<?= $location_id ?>"
        data-next_offset="<?= $nextOffset ?>" data-location_key="<?= $location_key ?>"
        data-pagetemplate_id="<?= $pagetemplate_id ?>">
    <?= $buttonTitle ?>
</button>
