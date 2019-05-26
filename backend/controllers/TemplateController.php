<?php

namespace backend\controllers;

use backend\components\BaseController;
use backend\models\search\TemplateSearch;
use backend\models\Template;
use common\components\Y;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TemplateController extends BaseController
{
    /**
     * @var $modelClass \yii\db\ActiveRecord
     * @var $searchModelClass \yii\db\ActiveRecord
     */
    public $modelClass = Template::class;
    public $searchModelClass = TemplateSearch::class;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => new \yii\helpers\ReplaceArrayValue([
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ]),
            ]
        );
    }

    /**
     * @inheritdoc
     */
//    public function actions()
//    {
//        $actions = parent::actions();
//        $actions['ajax-delete'] = [
//            'class' => 'backend\components\actions\AjaxDeleteAction',
//            'modelClass' => Template::class,
//        ];
//
//        return $actions;
//    }
//
//    /**
//     * @return string
//     */
//    public function actionIndex()
//    {
//        $searchModel = new TemplateSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * @param bool $isAdvert
     * @return string|\yii\web\Response
     */
    public function actionCreate($scenario = Template::SCENARIO_DEFAULT, $isMainPageUpperBlock = false)
    {

        Y::dump($this->behaviors());

        $model = new Template(['scenario' => $scenario, 'status' => Template::STATUS_VISIBLE]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->updateModelWithJunctionTable()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model, 'isMainPageUpperBlock' => $isMainPageUpperBlock]);
    }

    /**
     * @param $id integer
     * @param $copy bool
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id, $copy = false)
    {
        $model = Template::find()->where(['id' => $id])
            ->with(['sections', 'mainSections', 'tags'])->one();
        $model->fillLocationIds();      // sectionIds, mainSectionIds, tagIds, advertIds
        $model->setScenarioByLocationIds();
        if ($copy) {
            $attr = array_merge($model->attributes, ['id' => null, 'scenario' => $model->scenario]);
            $model = new Template($attr);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->updateModelWithJunctionTable()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model, 'isMainPageUpperBlock' => $model->isMainPageUpperBlock]);
    }

}
