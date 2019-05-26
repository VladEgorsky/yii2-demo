<?php
namespace backend\models\search;

use backend\models\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NewsSearch extends News
{
    public $section_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comment_count', 'ordering', 'status'], 'integer'],
            [['title', 'short_content', 'content', 'cover_image', 'cover_video', 'author', 'created_at', 'section_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find()->with(['sections', 'tags'])->joinWith('sections');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'news.id'            => $this->id,
            'news.comment_count' => $this->comment_count,
            'news.ordering'      => $this->ordering,
            'news.status'        => $this->status,
            'news_section.section_id' => $this->section_id,
        ]);

        if ($this->created_at) {
            $d = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'news.created_at', $d, $d + 86399]);
        }

        $query->andFilterWhere(['like', 'news.title', $this->title])
            ->andFilterWhere(['like', 'news.short_content', $this->short_content])
            ->andFilterWhere(['like', 'news.content', $this->content])
            ->andFilterWhere(['like', 'news.cover_image', $this->cover_image])
            ->andFilterWhere(['like', 'news.cover_video', $this->cover_video])
            ->andFilterWhere(['like', 'news.author', $this->author]);

        return $dataProvider;
    }
}
