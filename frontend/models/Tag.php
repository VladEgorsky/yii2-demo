<?php

namespace frontend\models;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property News[] $news
 * @property Section[] $section
 */
class Tag extends \common\models\Tag
{
    public function getNews()
    {
        return $this->hasMany(News::class, ['id' => 'news_id'])->viaTable('news_tag', ['tag_id' => 'id']);
    }
}

