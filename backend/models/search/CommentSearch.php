<?php
namespace backend\models\search;

use backend\models\Comment;
use common\components\Y;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CommentSearch extends Comment
{
    public $newsTitle;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'news_id', 'rate', 'status'], 'integer'],
            [['user_name', 'user_address', 'comment', 'created_at', 'newsTitle'], 'safe'],
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
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\ExitException
     */
    public function search($params)
    {
        $query = Comment::find()->with(['news'])->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'rate'       => $this->rate,
            'status'     => $this->status,
        ]);

        if ($this->created_at) {
            $d = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $d, $d + 86399]);
        }

        // Search newsId by title
        if ($this->newsTitle) {
            $params = [
                'index' => 'news_index',
                'type' => 'news_type',
                'body' => [
                    'query' => [
                        'bool' => [
                            'should' => [
                                [
                                    'multi_match' => [
                                        'query' => $this->newsTitle,
                                        'fields' => [
                                            'title',
                                            'content',
                                        ],
                                        "analyzer" => "standard",
                                        "type" => "cross_fields",
                                        "minimum_should_match" => "100%",
                                        "auto_generate_synonyms_phrase_query" => true
                                    ],
                                ]
                            ],
                        ],
                    ],
                ],
            ];

            try {
                $results = \Yii::$app->elastic->search($params);
            } catch (\Exception $e) {
                $results = null;
            }

            $items = isset($results['hits']['hits']) ? $results['hits']['hits'] : null;

            if ($items) {
                $newsIds = [];

                foreach ($items as $item) {
                    $newsIds[] = $item['_id'];
                }

                $query->andFilterWhere([
                    'news_id' => $newsIds,
                ]);
            }
        }

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_address', $this->user_address])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
