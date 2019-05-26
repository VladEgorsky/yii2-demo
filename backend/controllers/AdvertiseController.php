<?php
namespace backend\controllers;

use backend\components\BaseController;
use backend\models\Advertise;
use backend\models\search\AdvertiseSearch;
use common\components\Y;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class AdvertiseController extends BaseController
{
    /**
     * @var $modelClass \yii\db\ActiveRecord
     * @var $searchModelClass \yii\db\ActiveRecord
     */
    public $modelClass = Advertise::class;
    public $searchModelClass = AdvertiseSearch::class;
    public $newModelDefaultAttributes = ['status' => Advertise::STATUS_PROCESSED];

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
            //$model->files = UploadedFile::getInstances($model, 'files');
            $model->img_file = UploadedFile::getInstance($model, 'img_file');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data successfully saved');
                return $this->redirect(Url::previous());
            }

            Yii::$app->session->setFlash('error', Y::getModelErrorsAsStrings($model));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}
