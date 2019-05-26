<?php
/**
 *
 */

use frontend\models\Section;
use frontend\models\Tag;
use yii\helpers\Html;
use yii\helpers\Inflector;
use common\components\Y;

$menuItems = $this->params['mainMenuItems'] ?? Section::getMainMenuItems();
$menuItemsCount = count($menuItems);

$tags = Tag::getListData();
?>

<div class="container">

    <div class="text_page">
        <div class="text_page_content">
            <header>
                <h1>Send me news</h1>
            </header>

            <div class="text_page_text">
                <div class="content">
                    <?= Html::beginForm('', 'post', ['class' => 'form', 'id' => 'validate_form']) ?>
                    <div class="name_mail">
                        <p>We kindly ask you to introduce yourself and enter your e-mail</p>
                        <div class="input-2">
                            <div>
                                <?= Html::activeTextInput($model, 'name', [
                                    'placeholder' => 'Name*', 'required' => 'required'])
                                ?>
                            </div>
                            <div>
                                <?= Html::activeTextInput($model, 'email', [
                                    'type' => 'email', 'placeholder' => 'E-mail*', 'required' => 'required'])
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="sections">
                        <div class="block_title">
                            <span>Section:</span>
                        </div>

                        <?php for ($i = 0; $i < $menuItemsCount; $i++) : ?>
                            <div>
                                <?php $slug = Inflector::slug($menuItems[$i]['title'], '_') ?>
                                <?php $id = $menuItems[$i]['id'] ?>
                                <?php $title = $menuItems[$i]['title'] ?>

                                <input type="checkbox" id="<?= $slug ?>" name="Subscribe[sectionList][]"
                                       value="<?= $id ?>">
                                <label for="<?= $slug ?>"><?= $title ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="tag">
                        <div class="block_title">
                            <span>Tag:</span>
                        </div>

                        <div class="tag_list">
                            <?php $tagOrder = 0; ?>
                            <?php foreach ($tags as $id => $title) : ?>

                                <div class="<?= Y::getSectionClassName($tagOrder++) ?>">
                                    <?php $slug = Inflector::slug($title, '_') ?>
                                    <input type="checkbox" id="<?= $slug ?>" name="Subscribe[tagList][]"
                                           value="<?= $id ?>">
                                    <label for="<?= $slug ?>"><?= $title ?></label>
                                </div>

                            <?php endforeach; ?>
                        </div>

                        <div class="border_button show_more">Show all</div>
                    </div>

                    <div class="btn_block">
                        <input class="btn_with_bg" type="submit" value="Subscribe">
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <?= \frontend\widgets\RightBarWidget::widget() ?>
    </div>

</div>
