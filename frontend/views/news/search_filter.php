<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 07.01.19
 * Time: 22:35
 *
 * @var $selectedSection ;
 */

use frontend\models\Section;
use yii\helpers\Inflector;

$menuItems = Section::getMainMenuItems();
$menuItemsCount = count($menuItems);

// For using in /views/layouts/main_header.php
$this->params['mainMenuItems'] = $menuItems;
?>

<div class="filter">
    <span>Filter:</span>

    <div class="item">
        <div class="select_all_cuts">all</div>
    </div>
    <!-- <div class="item">
        <input name="cuts_select[]" type="checkbox" class="checkbox" id="all" value="0" />
        <label for="all">all</label>
    </div> -->

    <?php for ($i = 0; $i < 3; $i++) : ?>

        <div class="item">
            <?php $sectionId = $menuItems[$i]['id'] ?>
            <?php $labelTitle = $menuItems[$i]['title'] ?>
            <?php $inputId = Inflector::slug($labelTitle, '_') ?>

            <input name="section[]" type="checkbox" class="checkbox" id="<?= $inputId ?>"
                   value="<?= $sectionId ?>" <?= in_array($sectionId, $selectedSection) ? 'checked' : '' ?>/>
            <label for="<?= $inputId ?>"><?= $labelTitle ?></label>
        </div>

    <?php endfor; ?>

    <div class="more pc">
        <span class="open_more_list">more</span>
        <ul>
            <?php for ($i = 3; $i < $menuItemsCount; $i++) : ?>

                <div class="item">
                    <?php $sectionId = $menuItems[$i]['id'] ?>
                    <?php $labelTitle = $menuItems[$i]['title'] ?>
                    <?php $inputId = Inflector::slug($labelTitle, '_') ?>

                    <input name="section[]" type="checkbox" class="checkbox" id="<?= $inputId ?>"
                           value="<?= $sectionId ?>"/>
                    <label for="<?= $inputId ?>"><?= $labelTitle ?></label>
                </div>

            <?php endfor; ?>
        </ul>
    </div>

    <div class="more mobile">
        <span class="open_more_list">all</span>

        <ul>
            <div class="item">
                <div class="select_all_cuts">all</div>
            </div>

            <?php for ($i = 0; $i < $menuItemsCount; $i++) : ?>

                <div class="item">
                    <?php $sectionId = $menuItems[$i]['id'] ?>
                    <?php $labelTitle = $menuItems[$i]['title'] ?>
                    <?php $inputId = Inflector::slug($labelTitle, '_') . '__mobile' ?>

                    <input name="cuts_select[]" type="checkbox" class="checkbox" id="<?= $inputId ?>"
                           value="<?= $sectionId ?>"/>
                    <label for="<?= $inputId ?>"><?= $labelTitle ?></label>
                </div>

            <?php endfor; ?>
        </ul>

    </div>
</div>
