<?php

namespace frontend\controllers;

use common\components\CaptchaAction;
use common\components\Y;
use common\models\RateStatistic;
use frontend\models\Comment;
use Throwable;
use Yii;
use yii\filters\AjaxFilter;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['POST'],
                ],
            ],
            'isAjax' => [
                'class' => AjaxFilter::class,
                'only' => ['add', 'rate'],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAdd($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $model = new Comment(['news_id' => $id]);

            if (!$model->load(Yii::$app->request->post())) {
                return 'Error while loading data';
            } elseif (!$model->save()) {
                return Y::getModelErrorsAsStrings($model);
            }
            return 'ok';

        } catch (Throwable $t) {
            return $t->getMessage();
        }
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class'     => CaptchaAction::className(),
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }

    /**
     * @param $id
     * @param $rate
     * @return int
     * @throws NotFoundHttpException
     */
    public function actionRate($id, $rate)
    {
        $data = Yii::$app->session->get('comment_rate', []);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Comment::findOne($id);

        if (!$model)
            throw new NotFoundHttpException();

        if (($rate != 1 && $rate != -1) || in_array($id, $data))
            return $model->rate;

        $model->updateCounters(['rate' => $rate]);
        $model->refresh();

        //add rate stat
        $statModel = new RateStatistic([
            'created_at' => time(),
            'rate'       => $rate,
            'comment_id' => $id,
            'user_data'  => Json::encode($_SERVER),
        ]);
        $statModel->save();


        //add rated items
        $data[$id] = $id;
        Yii::$app->session->set('comment_rate', $data);

        return $model->rate;

    }
}