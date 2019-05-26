<?php

namespace frontend\controllers;

use common\components\Y;
use frontend\models\Advertise;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * AdvertiseController implements the CRUD actions for Advertise model.
 */
class AdvertiseController extends Controller
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
     * @param bool $saved
     * @return string|\yii\web\Response
     */
    public function actionCreate($saved = false)
    {
        $model = new Advertise();

        if ($model->load(Yii::$app->request->post())) {
            $model->files = UploadedFile::getInstances($model, 'files');
            $model->img_file = UploadedFile::getInstance($model, 'img_file');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your message successfully saved');
                return $this->redirect(['advertise/create', 'saved' => true]);
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
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Advertise::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
