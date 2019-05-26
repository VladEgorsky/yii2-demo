<?php

namespace frontend\controllers;

use frontend\models\News;
use frontend\models\Section;
use frontend\models\Tag;
use frontend\models\Template;
use frontend\models\TemplateLocation;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SectionController extends Controller
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($id)
    {
        $model = $this->findModel($id);
        $itemsClasses = TemplateLocation::getItemsClasses(Template::LOCATION_SECTION, $id);
        $limit = count($itemsClasses);
        $topNews = News::getActiveNewsJoinedWithSection($id, $limit, 0);

        $data = [
            'title' => $model->title, 'itemClasses' => $itemsClasses,
            'topNews' => $topNews, 'nextOffset' => $limit,
            'pagetemplate_id' => $model->pagetemplate_id,
        ];

        $activeTagsListData = Tag::getListData();

        return $this->render('index', [
            'model' => $model,
            'data' => $data,
            'activeTagsListData' => $activeTagsListData,
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
        $query = $model->getNews();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Section::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}