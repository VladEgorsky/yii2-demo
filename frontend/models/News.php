<?php
namespace frontend\models;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property string $cover_image
 * @property string $cover_video
 * @property string $author
 * @property int $comment_count
 * @property int $ordering
 * @property int $status
 * @property string $created_at
 *
 * @property Section[] $sections
 * @property \yii\db\ActiveQuery $seo
 * @property array $tagsList
 * @property null|string $seoUrl
 * @property Tag[] $tags
 */
class News extends \common\models\News
{
    const RIGHT_PANEL_WITH_PREVIEW_NEWS_NUMBER = 3;
    const RIGHT_PANEL_WITHOUT_PREVIEW_NEWS_NUMBER = 5;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsSection()
    {
        return $this->hasMany(NewsSection::class, ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTag()
    {
        return $this->hasMany(NewsTag::class, ['news_id' => 'id']);
    }

    /**
     * @param $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getLastActiveNews($limit, $offset = 0, $andWhere = [], $asArray = false)
    {
        return static::find()->orderBy(['id' => SORT_DESC])
            ->where(['status' => static::STATUS_VISIBLE])->andWhere($andWhere)
            ->limit($limit)->offset($offset)
            ->asArray($asArray)->all();
    }

    /**
     * @param $sectionId
     * @param $limit
     * @param int $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getActiveNewsJoinedWithSection($sectionId, $limit, $offset = 0, $asArray = false)
    {
        return static::find()->joinWith('newsSection')->orderBy(['id' => SORT_DESC])
            ->where(['news_section.section_id' => $sectionId, 'news.status' => static::STATUS_VISIBLE])
            ->limit($limit)->offset($offset)->asArray($asArray)->all();
    }

    /**
     * @param $sectionId
     * @param $limit
     * @param int $offset
     * @param bool $asArray
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getActiveNewsJoinedWithSectionPlusTag($sectionId, $limit, $offset = 0, $asArray = false)
    {
        return static::find()->joinWith('newsSection')->with('newsTag')->orderBy(['id' => SORT_DESC])
            ->where(['news_section.section_id' => $sectionId, 'news.status' => static::STATUS_VISIBLE])
            ->limit($limit)->offset($offset)->asArray($asArray)->all();
    }

    /**
     * @param $sectionId
     * @param $limit
     * @param int $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getActiveNewsJoinedWithTag($tagId, $limit, $offset = 0, $asArray = false)
    {
        return static::find()->joinWith('newsTag')->orderBy(['id' => SORT_DESC])
            ->where(['news_tag.tag_id' => $tagId, 'news.status' => static::STATUS_VISIBLE])
            ->limit($limit)->offset($offset)->asArray($asArray)->all();
    }
}
