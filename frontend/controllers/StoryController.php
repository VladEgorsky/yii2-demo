<?php

namespace frontend\controllers;

use common\components\Y;
use frontend\models\Story;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * StoryController implements the CRUD actions for Story model.
 */
class StoryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new Story model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($saved = false)
    {
        $model = new Story();

        if ($model->load(Yii::$app->request->post())) {
            $model->files = UploadedFile::getInstances($model, 'files');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your Story has been successfully added and will be published after moderation');
                return $this->redirect(['story/create', 'saved' => true]);
            }

            Yii::$app->session->setFlash('error', Y::getModelErrorsAsStrings($model));
        }

        return $this->render('create', [
            'model' => $model,
            'saved' => $saved,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
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
    protected function findModel($id)
    {
        if (($model = Story::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
