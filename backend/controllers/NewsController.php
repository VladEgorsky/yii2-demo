<?php
namespace backend\controllers;

use backend\components\BaseController;
use backend\models\News;
use backend\models\search\NewsSearch;
use common\components\Y;
use richardfan\sortable\SortableAction;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class NewsController extends BaseController
{
    /**
     * @var $modelClass \yii\db\ActiveRecord
     * @var $searchModelClass \yii\db\ActiveRecord
     */
    public $modelClass = News::class;
    public $searchModelClass = NewsSearch::class;
    public $newModelDefaultAttributes = ['status' => News::STATUS_VISIBLE];

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => new \yii\helpers\ReplaceArrayValue([
                    'class' => AccessControl::class,
                    'only' => ['update', 'delete', 'create', 'ajax-update', 'ajax-delete', 'ajax-create'],
                    'rules' => [
                        [
                            'actions' => ['update', 'create', 'ajax-update', 'ajax-create'],
                            'allow' => true,
                            'roles' => ['manager'],
                        ],
                        [
                            'actions' => ['delete', 'ajax-delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ]),
            ]
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'sortItem' => [
                'class' => SortableAction::class,
                'activeRecordClassName' => News::class,
                'orderColumn' => 'ordering',
            ],
        ];
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->tagList = $model->tags;
        $model->sectionList = $model->sections;

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadedVideo = UploadedFile::getInstance($model, 'uploadedVideo');

            if ($model->save()) {
                return $this->redirect(Url::previous());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
