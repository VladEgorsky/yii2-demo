<?php
/**
 * @var $section array
 * For Upper Block and all other Sections also
 *
 * [id1 => [
 *      title1,
 *      topNews1 => [
 *          // frontend\models\News
 *          Model1, Model2, Model3, Model4, Model5,
 *      ],
 *      itemClasses1 => [
 *          // For each model
 *          'news big-news', 'news', 'news-tall', 'news', 'news'
 *      ],
 *      nextOffset1,
 *      pagetemplate_id1
 * ]]
 *
 *
 * @var $activeTagsListData array
 *      [id1 => name1, id2 => name2]
 */

use common\models\News;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>

<?php foreach ($section['topNews'] as $i => $news) : ?>
    <?php
    $containerClass = $section['itemClasses'][$i];

    // Default values for $containerClass in common\models\News
    $tile = News::$tiles[$containerClass];
    $titleMaxLength = $tile['titleMaxLength'];
    $shortDescriptionMaxLength = $tile['shortDescriptionMaxLength'];
    //$imgSize = $tile['img'] ? $tile['img']['size'] : false;
    $imgSize = $tile['img'] ? 'x' . $tile['img']['height'] : false;
    $newsLink = Url::to(['news/view', 'id' => $news['id']]);

    // Cover image
    $bgStyle = '';
    if ($news->cover_image && $imgSize) {
        $img = $news->getImage();

        if ($img) {
            $bgStyle = 'background-image: url(' . $img->getUrl($imgSize) . ')';
        }
    }

    // News Label (Tag title for MainSectionBlock)
    $newsLabelPosition = $tile['newsLabel']['position'] ?? false;
    if ($newsLabelPosition) {
        $newsTagId = $news->newsTag[0]->tag_id ?? null;
        $newsLabel = $newsTagId ? $activeTagsListData[$newsTagId] : null;
        $newsLabel = $newsLabel ?? $section['title'];
    }

    // $containerClass. Add Section class to every title in Last Top News block
    if ($section['pagetemplate_id'] == \frontend\models\Section::PAGE_TEMPLATE_UPPER_BLOCK) {
        $additional_class = $section['title'];
        $containerClass .= ' ' . Inflector::slug($additional_class, '_');
    }
    ?>

    <div class="<?= $containerClass ?>">
        <a href="<?= $newsLink ?>">
            <?php if ($newsLabelPosition == 'beforeDivClassDescription') : ?>
                <span class="news-label"><?= Html::encode($newsLabel) ?></span>
            <?php endif; ?>

            <div class="description">
                <?php
                if ($titleMaxLength > 0) {
                    //$newsTitle = StringHelper::truncate(strip_tags($news['title']), $titleMaxLength);
                    $newsTitle = strip_tags($news['title']);
                    echo Html::tag('h2', $newsTitle, ['class' => 'title']);
                }

                if ($shortDescriptionMaxLength > 0) {
//                    $newsShortContent = StringHelper::truncate(strip_tags($news['short_content']),
//                        $shortDescriptionMaxLength);
                    $newsShortContent = strip_tags($news['short_content']);
                    echo Html::tag('p', $newsShortContent);
                }
                ?>
            </div>

            <?php if ($imgSize) : ?>
                <div class="bg" style="">
                    <?php if ($newsLabelPosition == 'afterDivClassBg') : ?>
                        <span class="news-label"><?= Html::encode($newsLabel) ?></span>
                    <?php endif; ?>

                    <div class="image" style="<?= $bgStyle ?>"></div>
                </div>
            <?php endif; ?>
        </a>
    </div>
<?php endforeach; ?>
