<?php
namespace frontend\controllers;

use common\components\Y;
use frontend\models\News;
use frontend\models\Section;
use frontend\models\StaticPage;
use frontend\models\Tag;
use frontend\models\Template;
use frontend\models\TemplateLocation;
use frontend\models\Subscribe;
use frontend\widgets\NewsBlockWidget;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only' => ['get-more-news']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@frontend/views/site/pages/404.php',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        // ItemClasses for Upper block
        $upperBlockItemsClasses = TemplateLocation::getItemsClasses(
            Template::LOCATION_MAINSECTION, Template::LOCATION_MAIN_UPPERBLOCK_ID);

        // TopNews for Upper block
        $limit = count($upperBlockItemsClasses);
        $section = Section::findOne(['pagetemplate_id' => Section::PAGE_TEMPLATE_UPPER_BLOCK]);
        $topNews = News::getActiveNewsJoinedWithSection($section->id, $limit);
        $upperBlock = [$section->id => [
            'title' => $section->title, 'itemClasses' => $upperBlockItemsClasses,
            'topNews' => $topNews, 'nextOffset' => $limit,
            'pagetemplate_id' => $section->pagetemplate_id,
        ]];

        // TopNews for all other Sections
        $mainSections = Section::find()
            ->where(['mainmenu' => 1, 'status' => Section::STATUS_VISIBLE])
            ->orderBy(['ordering' => SORT_ASC])
            ->indexBy('id')->asArray()->all();

        foreach ($mainSections as $id => $section) {
            // ItemClasses & TopNews for each Section
            // (except Pic of the Day & Video)
            $mainSections[$id]['itemClasses'] = TemplateLocation::getItemsClasses(
                Template::LOCATION_MAINSECTION, $id);
            $limit = count($mainSections[$id]['itemClasses']);

            // TopNews for Pic of the Day & Video
            if ($section['pagetemplate_id'] == \common\models\Section::PAGE_TEMPLATE_PICTUREOFTHEDAY) {
                $limit = Section::PICTUREOFTHEDAY_ITEMS_ON_SLIDER;
            } elseif ($section['pagetemplate_id'] == \common\models\Section::PAGE_TEMPLATE_VIDEO) {
                $limit = Section::VIDEO_ITEMS_ON_SLIDER;
            }

            $mainSections[$id]['topNews'] = News::getActiveNewsJoinedWithSectionPlusTag($id, $limit, 0);
            $mainSections[$id]['nextOffset'] = count($mainSections[$id]['topNews']);
            $mainSections[$id]['pagetemplate_id'] = $section['pagetemplate_id'];
        }

        $activeTagsListData = Tag::getListData();

        return $this->render('index', [
            'upperBlock' => $upperBlock,        // Title, itemsClasses, topNews & $limit For Upper Block
            'mainSections' => $mainSections,    // Title, itemsClasses, topNews & $limit For Other sections+
            'activeTagsListData' => $activeTagsListData]);
    }

    /**
     * @param $location_key     MAINSECTION, SECTION, TAG ...
     * @param $location_id
     * @param $offset
     * @return array
     * @throws \Exception
     */
    public function actionGetMoreNews($location_key, $location_id, $offset, $pagetemplate_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $itemClasses = TemplateLocation::getItemsClasses($location_key, $location_id);
        $limit = count($itemClasses);

        if ($location_key == Template::LOCATION_TAG) {
            $news = News::getActiveNewsJoinedWithTag($location_id, $limit, $offset);
        } else {
            $news = News::getActiveNewsJoinedWithSection($location_id, $limit, $offset);
        }

        if (count($news) == 0) {
            return ['message' => 'No more news'];
        }

        $data = [
            'title' => false, 'itemClasses' => $itemClasses,
            'topNews' => $news, 'nextOffset' => $limit,
            'pagetemplate_id' => $pagetemplate_id,
        ];

        $activeTagsListData = Tag::getListData();
        $html = NewsBlockWidget::widget([
            'section' => $data,
            'activeTagsListData' => $activeTagsListData
        ]);
        return ['html' => $html, 'nextOffset' => (int)$offset + $limit];
    }

    /**
     * @param $title
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPage($view)
    {
        $model = StaticPage::find()->where(['view' => $view])->one();
        if (is_null($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->updateCounters(['clicks' => 1]);
        return $this->render('page', ['model' => $model]);
    }

    /**
     * @return string|Response
     */
    public function actionSubscribe()
    {
        $model = new Subscribe();

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your have successfully subscribed');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', Y::getModelErrorsAsStrings($model));
        }

        return $this->render('subscribe', ['model' => $model]);
    }

    public function actionUnsubscribe($email)
    {
        $model = Subscribe::find()->where(['email' => $email])->one();
        if (is_null($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Your have successfully unsubscribed');
            return $this->redirect(['index']);
        }

        return $this->render('unsubscribe', ['model' => $model]);
    }

//    /**
//     * @return array|string
//     */
//    public function actionSubscribe()
//    {
//        \Yii::$app->response->format = Response::FORMAT_JSON;
//        $model = new Subscribe();
//
//        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
//            return 'ok';
//        }
//
//        return Y::getModelErrorsAsStrings($model);
//    }
//
//    /**
//     * @return array
//     */
//    public function actionSubscribeValidate()
//    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//
//        $model = new Subscribe();
//        $model->load(\Yii::$app->request->post());
//
//        return ActiveForm::validate($model);
//    }

    /**
     * @return string
     */
    public function actionContribute()
    {
        return $this->render('contribute');
    }

}
