<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\web\View;

class GetMoreNewsButton extends Widget
{
    public $location_key;       // MAINSECTION, SECTION, TAG
    public $buttonClass = 'border_button load_more';
    public $buttonSelector = '.border_button.load_more';
    public $buttonTitle = 'More';
    public $url;
    public $location_id;
    public $nextOffset;
    public $pagetemplate_id;
    public $js;

    public function init()
    {
        $this->js = <<< JS
$(document).on("click", "$this->buttonSelector", function() {
    var button = $(this);
    var url = button.data("url");
    var data = {
        "location_key": button.data("location_key"),
        "location_id": button.data("location_id"),
        "offset": button.attr("data-next_offset"),
        "pagetemplate_id": button.attr("data-pagetemplate_id")
    };

    $.get(url, data, function(response) {
        if (response.html !== undefined) {
            var container = button.closest("div.category").find("div.news_list_container");
            var items = $(response.html);
            container.append(items).packery("appended", items);
        }
        if (response.nextOffset !== undefined) {
            button.attr("data-next_offset", response.nextOffset);
        }
        if (response.message !== undefined) {
            alert(response.message);
        }
    });
});
JS;
    }

    public function run()
    {
        $this->view->registerJs($this->js, View::POS_READY, 'getMoreNewsButton');

        return $this->render('get_more_news_button', [
            'location_key' => $this->location_key,
            'buttonClass' => $this->buttonClass,
            'buttonTitle' => $this->buttonTitle,
            'url' => $this->url,
            'location_id' => $this->location_id,
            'nextOffset' => $this->nextOffset,
            'pagetemplate_id' => $this->pagetemplate_id,
        ]);
    }
}