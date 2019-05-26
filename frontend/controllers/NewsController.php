<?php
/**
 * Created by PhpStorm.
 */

namespace frontend\controllers;

use frontend\models\News;
use frontend\models\Section;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NewsController extends Controller
{

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id, ['tags']);
        $model->updateCounters(['clicks' => 1]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id, $with = [])
    {
        if (($model = News::find()->where(['id' => $id])->with($with)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     */
    public function actionSearch()
    {
        $perPage = 15;
        $q = \Yii::$app->request->get('search');
        $page = \Yii::$app->request->get('page', 1);
        $selectedSection = \Yii::$app->request->get('section', []);

        $params = [
            'index' => 'news_index',
            'type'  => 'news_type',
            'body'  => [
                'from'  => $page < 0 ? 0 : $page - 1,
                'size'  => $perPage,
                'sort'  => '_score',
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'multi_match' => [
                                    'query'                               => $q,
                                    'fields'                              => [
                                        'title',
                                        'content',
                                    ],
                                    "analyzer"                            => "standard",
                                    "type"                                => "cross_fields",
                                    "minimum_should_match"                => "100%",
                                    "auto_generate_synonyms_phrase_query" => true
                                ],
                            ]
                        ],
                    ],
                ],
                'aggs'  => [
                    'sections' => [
                        'terms' => [
                            'field' => 'sections',
                            "order" => ["_count" => "asc"]
                        ]
                    ]
                ],
            ],
        ];

        try {
            $sectionResults = \Yii::$app->elastic->search($params);
        } catch (\Exception $e) {
            $sectionResults = null;
        }

        $total = isset($sectionResults['hits']['total']) ? $sectionResults['hits']['total'] : 0;
        $pages = ceil($total / $perPage);

        $sectionIds = null;
        $sections = [];
        if (isset($sectionResults['aggregations']['sections']['buckets'])) {
            foreach ($sectionResults['aggregations']['sections']['buckets'] as $bucket) {
                $sectionIds[] = $bucket['key'];
            }
            $sections = Section::find()->where(['id' => $sectionIds])->all();
        }

        $params['from'] = $page >= 1 ? $page - 1 : 0;
        $params['size'] = $perPage;

        if ($selectedSection) {
            $params['body']['query']['bool']['must'][]['bool']['should'][] = [
                'terms' => [
                    'sections' => $selectedSection,
                ],
            ];
        }

        try {
            $results = \Yii::$app->elastic->search($params);
        } catch (\Exception $e) {
            $results = null;
        }

        return $this->render('search', [
            'results'         => $results,
            'q'               => $q,
            'page'            => $page,
            'pages'           => $pages,
            'sections'        => $sections,
            'selectedSection' => $selectedSection,
        ]);
    }

}