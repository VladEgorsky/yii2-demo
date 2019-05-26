<?php
/**
 * @var $this yii\web\View
 * @var $model backend\models\Template
 * @var $isMainPageUpperBlock bool
 */

?>

<div class="grid-item news-big" data-item_class="news news-big">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="width: 100%"/>

    <div class="description">
        <div>NEWS TITLE</div>
        <div>news text</div>
    </div>
</div>

<div class="grid-item news" data-item_class="news">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="width: 100%"/>
    <div class="description" style="height: 40%">
        NEWS TITLE
    </div>
</div>


<?php
//if ($isMainPageUpperBlock) {
//    return true;
//}
?>


<div class="grid-item news-tall" data-item_class="news news-tall">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="width: 100%"/>
    <div style="height: 40%">
        <div>NEWS TITLE</div>
        <div>news text</div>
    </div>
</div>

<div class="grid-item news-tall-selected" data-item_class="news news-tall news-tall-selected">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="width: 100%"/>
    <div class="description" style="height: 50%">
        <div>NEWS TITLE</div>
        <div>news text</div>
    </div>
</div>

<div class="grid-item news-wide" data-item_class="news news-wide">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="height: 100%; float:right"/>
    <div>
        <div>NEWS TITLE</div>
        <div>news text</div>
    </div>
</div>

<div class="grid-item news-wide-l_img" data-item_class="news news-wide news-wide-l_img">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="height: 100%; float:left"/>
    <div>
        <div>NEWS TITLE</div>
        <div>news text</div>
    </div>
</div>

<div class="grid-item news-no-img-big" data-item_class="news news-no-img-big">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <div>NEWS TITLE</div>
    <div>news text</div>
</div>

<div class="grid-item news-no-img-big-selected" data-item_class="nnews news-no-img-big news-no-img-big-selected">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <div>NEWS TITLE</div>
    <div>news text</div>
</div>

<div class="grid-item news-min" data-item_class="news news-min">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="height: 100%; float:left"/>
    <div>
        title
    </div>
</div>

<div class="grid-item news-min-right" data-item_class="news news-min news-min-right">
    <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
    <img src="/img/template.png" style="height: 100%; float:right"/>
    <div>
        title
    </div>
</div>
