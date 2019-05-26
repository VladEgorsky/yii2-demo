<?php

namespace frontend\controllers;

use frontend\models\News;
use frontend\models\Section;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PictureController extends Controller
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        /** @var \frontend\models\Section $model */
        $sectionModel = Section::findOne($id);
        $newsForSlider = $newsForPage = [];

        $limit = Section::PICTUREOFTHEDAY_ITEMS_ON_INDEX_PAGE + Section::PICTUREOFTHEDAY_ITEMS_ON_SLIDER;
        $news = News::getActiveNewsJoinedWithSection($id, $limit);

        $newsForSlider = array_slice($news, 0, Section::PICTUREOFTHEDAY_ITEMS_ON_SLIDER);
        $newsForPage = array_slice($news, Section::PICTUREOFTHEDAY_ITEMS_ON_SLIDER);

        return $this->render('index', [
            'sectionModel' => $sectionModel,
            'newsForSlider' => $newsForSlider,
            'newsForPage' => $newsForPage,
            'nextOffset' => $limit,
        ]);
    }

//    public function actionIndexGetMore($id, $offset)
//    {
//        $limit = Section::PICTUREOFTHEDAY_ITEMS_ON_INDEX_PAGE;
//        $newsForPage = News::getLastActiveNews($limit, $offset, ['section_id' => $id]);
//        return $this->renderAjax('_index', ['newsForPage' => $newsForPage]);
//    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id, $section_id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model, 'section_id' => $section_id,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}