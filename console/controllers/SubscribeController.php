<?php
/**
 * Created by PhpStorm.
 */

namespace console\controllers;

use common\components\Y;
use common\models\News;
use frontend\models\Subscribe;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SubscribeController extends Controller
{
    public function actionOneDay($where = ['period' => Subscribe::SUBSCRIBE_PERIOD_ONE_DAY])
    {
        try {
            $subscribers = Subscribe::find()
                ->with('tags', 'sections')
                ->where($where)
                ->andWhere(['status' => Subscribe::STATUS_ACTIVE])
                ->all();

            if (!$subscribers) {
                return false;
            }

            $from = strtotime('-1 day');
            $to = time();
            $messages = [];

            foreach ($subscribers as $subscriber) {
                $tagIds = $sectionIds = [];

                foreach ($subscriber->tags as $tag) {
                    $tagIds[] = $tag->id;
                }
                foreach ($subscriber->sections as $section) {
                    $sectionIds[] = $section->id;
                }

                $newsByTag = $newsBySection = $news = [];

                if (!empty($tagIds)) {
                    $newsByTag = News::find()
                        ->with(['seo', 'sections'])
                        ->joinWith('tags')
                        ->where(['between', 'created_at', $from, $to])
                        ->andWhere(['news_tag.tag_id' => $tagIds])
                        ->andWhere(['news.status' => News::STATUS_VISIBLE])
                        ->indexBy('id')->asArray()->all();
                }
                if (!empty($sectionIds)) {
                    $newsBySection = News::find()
                        ->with(['seo', 'sections'])
                        ->joinWith('sections')
                        ->where(['between', 'created_at', $from, $to])
                        ->andWhere(['news_section.section_id' => $sectionIds])
                        ->andWhere(['news.status' => News::STATUS_VISIBLE])
                        ->indexBy('id')->asArray()->all();
                }

                $news = ArrayHelper::merge($newsByTag, $newsBySection);
                if (empty($news)) {
                    continue;
                }

                Yii::$app->mailer->htmlLayout = 'layouts/newsletter';
                $messages[] = Yii::$app->mailer->compose('newsletter', [
                    'news' => $news, 'sendingTimestamp' => $to,
                    'fb' => Yii::getAlias('@common/mail/layouts/images/facebook-circle-white-bordered.png'),
                    'inst' => Yii::getAlias('@common/mail/layouts/images/instagram-circle-white-bordered.png'),
                    'tel' => Yii::getAlias('@common/mail/layouts/images/telegram-circle-white-bordered.png'),
                    'twit' => Yii::getAlias('@common/mail/layouts/images/twitter-circle-white-bordered.png'),
                    'recipientEmail' => $subscriber->email,
                ])
                    ->setFrom('robot@test.com')
                    ->setTo($subscriber->email)
                    ->setSubject('Last news list');
            }
            Yii::$app->mailer->sendMultiple($messages);

            echo 'ok';
            return 0;

        } catch (\Throwable $e) {
            echo $e->getMessage();
            return $e->getCode();
        }

    }
//    public function actionOneDay()
//    {
//        $from = strtotime('-1 day');
//        $to = time();
//
//        $news = News::find()
//            ->with(['seo'])
//            ->where(['between', 'created_at', $from, $to])
//            ->asArray()
//            ->all();
//
//        if ($news) {
//            $message = '';
//            foreach ($news as $model)
//                $message .= Html::tag('p', Html::a($model['title'], [$model['seo']['external_link']]));
//
//            $subscribers = Subscribe::find()
//                ->where(['period' => Subscribe::SUBSCRIBE_PERIOD_ONE_DAY])
//                ->andWhere(['status' => Subscribe::STATUS_ACTIVE])
//                ->select('email')
//                ->column();
//
//            if ($subscribers) {
//                foreach ($subscribers as $email) {
//                    \Yii::$app->mailer->compose()
//                        ->setFrom('robot@test.com')
//                        ->setTo($email)
//                        ->setSubject('Last news list')
//                        ->setHtmlBody($message)
//                        ->send();
//                }
//            }
//        }
//
//    }


}