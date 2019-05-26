<?php

use frontend\models\Section;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use common\components\Y;

// Maybe already selected in the views/news/search_filter.php
$menuItems = $this->params['mainMenuItems'] ?? Section::getMainMenuItems();
$menuItemsCount = count($menuItems);
?>

<div class="m_menu">
    <div class="head">
        <div class="logo">
            <span>ST</span>
        </div>
        <div class="close"></div>
    </div>
    <div class="link_list">
        <?php
        for ($i = 0; $i < $menuItemsCount; $i++) {
            echo Html::a(
                $menuItems[$i]['title'],
                Section::getMainMenuItemUrl($menuItems[$i]),
                [
                    'class'      => Inflector::slug($menuItems[$i]['title'], '_') . ' material-design',
                    'data-color' => '#2f5398',
                ]
            );
        }
        ?>
    </div>
    <div class="social_links">

    </div>
</div>

<div class="menu"><!-- menu--blue -->
    <div class="container">
        <div class="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="search"></div>

        <div class="search_form__mobile">
            <form action="">
                <input type="search" placeholder="Search">
                <input type="submit">
            </form>
        </div>


        <a href="<?= Url::home() ?>">
            <div class="logo">
                <span class="mobile">ST</span>
                <span>The Siberian Times</span>
            </div>
        </a>

        <ul class="drop-menu-main">
            <?php
            for ($i = 0; $i < 6; $i++) {
                echo '<li>' . Html::a(
                        $menuItems[$i]['title'],
                        Section::getMainMenuItemUrl($menuItems[$i]),
                        ['class' => Y::getSectionClassName($i)]
                    //['class' => Inflector::slug($menuItems[$i]['title'], '_')]
                    ) . '</li>';
            }
            ?>

            <li class="open_submenu">
                <span class="drop-down">More <span class="arrow"></span></span>
            </li>
        </ul>
    </div>

    <div class="submenu">
        <div class="container">
            <ul>
                <?php
                for ($i = $menuItemsCount - 1; $i > 5; $i--) {
                    echo '<li>' . Html::a(
                            $menuItems[$i]['title'],
                            Section::getMainMenuItemUrl($menuItems[$i]),
                            ['class' => Y::getSectionClassName($i)]
                        //['class' => Inflector::slug($menuItems[$i]['title'], '_')]
                        ) . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="status_bar">
        <div class="container">
            <div class="day">
                <span><?= date('l, M d') ?></span>
            </div>
            <div class="weather">
                <span class="city">Tomsk ?</span>
                <span class="weather_status"><i class="sun"></i></span>
                <span class="temperature">8°C ?</span>
            </div>
            <div class="search_form">
                <?= Html::beginForm(['/news/search'], 'get') ?>
                <?= Html::textInput('search', '', ['placeholder' => 'Search', 'type' => 'search']) ?>
                <?= Html::input('submit', '', '') ?>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
</div>
