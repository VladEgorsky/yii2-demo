<?php

namespace backend\components\rbac\controllers\base;

use Yii;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2mod\rbac\models\AuthItemModel;
use yii2mod\rbac\models\search\AuthItemSearch;

/**
 * Class ItemController
 *
 * @package yii2mod\rbac\base
 */
class ItemController extends Controller
{
    /**
     * @var string search class name for auth items search
     */
    public $searchClass = [
        'class' => AuthItemSearch::class,
    ];

    /**
     * @var int Type of Auth Item
     */
    protected $type;

    /**
     * @var array labels use in view
     */
    protected $labels;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * Lists of all auth items
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $searchModel->type = $this->type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     * @return mixed
     */
    public function actionView(string $id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param null $id
     * @return string
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     *
     * Action is using for Creating Items also (if empty $id)
     */
    public function actionAjaxUpdate($id = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }

        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new AuthItemModel();
            $model->type = $this->type;
        }

        // Action must return JSON if all is ok, HTML otherwise
        if (!$model) {
            $model->addError('type', "Item $id not found");
        }

        if ($model && $model->load(Yii::$app->request->post())) {
            try {
                $model->save();
            } catch (\Exception $e) {
                $model->addError('type', $e->getMessage());
            }

            if (!$model->errors) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return 'ok';
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws \Throwable
     */
    public function actionAjaxDelete()
    {
        if (!Yii::$app->request->isAjax || !Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }

        // Action must return "ok" if all is ok, any other string otherwise
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        if (empty($id)) {
            return 'Incorrect incoming parameters';
        }

        $auth = Yii::$app->getAuthManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
        if (empty($item)) {
            return "Item $id not found";
        }

        try {
            $auth->remove($item);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return 'ok';
    }






//    /**
//     * Creates a new AuthItem model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     *
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new AuthItemModel();
//        $model->type = $this->type;
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            Yii::$app->session->setFlash('success', Yii::t('yii2mod.rbac', 'Item has been saved.'));
//            return $this->redirect(['view', 'id' => $model->name]);
//        }
//
//        return $this->render('create', ['model' => $model]);
//    }
//
//    /**
//     * Updates an existing AuthItem model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     *
//     * @param string $id
//     * @return mixed
//     */
//    public function actionUpdate(string $id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            Yii::$app->session->setFlash('success', Yii::t('yii2mod.rbac', 'Item has been saved.'));
//            return $this->redirect(['view', 'id' => $model->name]);
//        }
//
//        return $this->render('update', ['model' => $model]);
//    }
//
//    /**
//     * Deletes an existing AuthItem model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     *
//     * @param string $id
//     * @return mixed
//     */
//    public function actionDelete(string $id)
//    {
//        $model = $this->findModel($id);
//        Yii::$app->getAuthManager()->remove($model->item);
//        Yii::$app->session->setFlash('success', Yii::t('yii2mod.rbac', 'Item has been removed.'));
//
//        return $this->redirect(['index']);
//    }

    /**
     * Assign items
     *
     * @param string $id
     * @return array
     */
    public function actionAssign(string $id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $model->addChildren($items);

        return array_merge($model->getItems());
    }

    /**
     * Remove items
     *
     * @param string $id
     * @return array
     */
    public function actionRemove(string $id): array
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $model->removeChildren($items);

        return array_merge($model->getItems());
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(): string
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'item';
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     *
     * @param string $id
     * @return AuthItemModel
     */
    protected function findModel(string $id)
    {
        $auth = Yii::$app->getAuthManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
        return empty($item) ? null : new AuthItemModel($item);
    }
}