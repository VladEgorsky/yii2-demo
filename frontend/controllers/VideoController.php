<?php

namespace frontend\controllers;

use frontend\models\TemplateLocation;
use frontend\models\News;
use frontend\models\Section;
use frontend\models\Template;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class VideoController extends Controller
{

    public function actionIndex($id)
    {
        /** @var \frontend\models\Section $model */
        $sectionModel = Section::findOne($id);
        $newsForSlider = $newsForPage = [];

        $tileClasses = TemplateLocation::getItemsClasses(Template::LOCATION_SECTION, $id);
        $limit = count($tileClasses) + Section::VIDEO_ITEMS_ON_SLIDER;
        $news = News::getActiveNewsJoinedWithSection($id, $limit);

        $newsForSlider = array_slice($news, 0, Section::VIDEO_ITEMS_ON_SLIDER);
        $newsForPage = array_slice($news, Section::VIDEO_ITEMS_ON_SLIDER);

        return $this->render('index', [
            'sectionModel' => $sectionModel,
            'newsForSlider' => $newsForSlider,
            'newsForPage' => $newsForPage,
            'tileClasses' => $tileClasses,
            'nextOffset' => $limit,
        ]);
    }


//    /**
//     * @param $id
//     * @return string
//     * @throws NotFoundHttpException
//     */
//    public function actionView($id)
//    {
//        $model = $this->findModel($id);
//
//        return $this->render('view', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * @param $id
//     * @return mixed
//     * @throws NotFoundHttpException
//     */
//    protected function findModel($id)
//    {
//        if (($model = News::findOne($id)) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }
}