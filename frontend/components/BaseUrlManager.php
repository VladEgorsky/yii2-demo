<?php
/**
 * Created by PhpStorm.
 * User: yurik
 */

namespace frontend\components;

use common\modules\seo\models\Seo;
use Exception;
use yii\web\UrlManager;

class BaseUrlManager extends UrlManager
{

    /**
     * @param \yii\web\Request $request
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function parseRequest($request)
    {

        $pathInfo = $request->getPathInfo();

//        if (substr($pathInfo, -1) == '/' && strlen($pathInfo) > 1) {
//            Yii::$app->response->redirect('/' . trim($pathInfo, '/'), 301);
//            Yii::$app->end();
//        }

        if ($pathInfo == '')
            $pathInfo = '/';

        try {
            $seo = Seo::getSEOData($pathInfo);
        } catch (Exception $e) {
            $seo = null;
        }

        if ($seo != null)
            return [$seo->internal_link, ['id' => $seo->model_id]];

        return parent::parseRequest($request);

    }
}