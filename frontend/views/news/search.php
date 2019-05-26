<?php

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 *
 * @var $q
 * @var $page
 * @var $results array
 * @var $selectedSection array
 * @var $pages
 */

$items = isset($results['hits']['hits']) ? $results['hits']['hits'] : null;
?>
<div class="container">
    <div class="search_page">
        <div class="content">

            <?= Html::beginForm('/news/search', 'get', ['class' => 'search_form', 'id' => 'search-form']); ?>
            <div class="serch_input">
                <?= Html::hiddenInput('page', 1, ['id' => 'search-page']) ?>
                <?= Html::textInput('search', $q, ['placeholder' => 'Search', 'type' => 'search',]) ?>
                <?= Html::input("submit", 'search_btn', '') ?>
            </div>

            <div class="filter_sort_line">
                <?= $this->render('search_filter', ['selectedSection' => $selectedSection]) ?>
                <?= $this->render('search_sort') ?>
            </div>
            <?= Html::endForm(); ?>

            <div class="result">
                <?php if ($items): ?>
                    <div class="items">
                        <?php foreach ($items as $item):
                            $item = $item['_source'];
                            ?>
                            <div class="news_prev">
                                <a href="<?= \yii\helpers\Url::to([$item['url']]) ?>">
                                    <div class="img"
                                         style="background-image: url('<?= $item['image'] ?>'); background-size: cover"></div>
                                    <div class="info">
                                        <h3><?= $item['title'] ?></h3>
                                        <p><?= \yii\helpers\StringHelper::truncateWords($item['content'], 25, '...',
                                                true) ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ($pages > 1) { ?>
                    <div style="text-align: center; padding-top: 20px" class="search-pager">
                        <button class="border_button more-search-result" data-page="<?= $page ?>"
                                data-pages="<?= $pages ?>">Show more
                        </button>
                    </div>
                <?php } ?>
            </div>

        </div>

        <?= \frontend\widgets\RightBarWidget::widget() ?>
    </div>
</div>