<?php
namespace backend\models\search;

use backend\models\Section;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SectionSearch extends Section
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ordering', 'status', 'pagetemplate_id'], 'integer'],
            [['title'], 'safe'],
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
        $query = Section::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'ordering', 'title', 'visibility', 'pagetemplate_id'
                ],
                'defaultOrder' => ['ordering' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['pagetemplate_id' => $this->pagetemplate_id]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
