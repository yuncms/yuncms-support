<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\support\frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yuncms\support\models\Support;

/**
 * 点赞通用接口
 * @package yuncms\support\frontend\controllers
 */
class SupportController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'store' => ['POST'],
                    'check' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['check', 'store'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new UnauthorizedHttpException(Yii::t('support', 'The request has not been applied because it lacks valid authentication credentials for the target resource.'));
                }
            ],
        ];
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionCheck()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Yii::$app->request->post('model');
        $model_id = Yii::$app->request->post('model_id');

        $source = null;
        if ($model === 'answer' && Yii::$app->hasModule('question')) {
            $source = \yuncms\question\models\QuestionAnswer::findOne($model_id);
        } else if ($model == 'live') {
            $source = \yuncms\live\models\Stream::findOne($model_id);
        } else if ($model == 'article' && Yii::$app->hasModule('article')) {
            $source = \yuncms\article\models\Article::findOne($model_id);
        }
        //etc..

        if (!$source) {
            throw new NotFoundHttpException ();
        }

        $support = Support::findOne(['user_id' => Yii::$app->user->id, 'model' => get_class($source), 'model_id' => $model_id]);
        if ($support) {
            return ['status' => 'failed'];
        }
        return ['status' => 'success'];
    }

    public function actionStore()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Yii::$app->request->post('model');
        $model_id = Yii::$app->request->post('model_id');
        /** @var null|\yii\db\ActiveRecord $source */
        $source = null;
        if ($model == 'user') {
            /** @var \yii\db\ActiveRecord $userClass */
            $userClass = Yii::$app->user->identityClass;
            $source = $userClass::findOne($model_id);
        } else if ($model == 'question' && Yii::$app->hasModule('question')) {
            $source = \yuncms\question\models\Question::findOne($model_id);
        } else if ($model == 'answer' && Yii::$app->hasModule('question')) {
            $source = \yuncms\question\models\QuestionAnswer::findOne($model_id);
        } else if ($model == 'article' && Yii::$app->hasModule('article')) {
            $source = \yuncms\article\models\Article::findOne($model_id);
        } else if ($model == 'live' && Yii::$app->hasModule('live')) {
            $source = \yuncms\live\models\Stream::findOne($model_id);
        }
        //etc..

        if (!$source) {
            throw new NotFoundHttpException ();
        }

        $support = Support::findOne(['user_id' => Yii::$app->user->id, 'model' => get_class($source), 'model_id' => $model_id]);
        if ($support) {
            return ['status' => 'supported'];
        }

        $data = [
            'user_id' => Yii::$app->user->id,
            'model_id' => $model_id,
            'model' => get_class($source),
        ];

        $support = new Support($data);
        if ($support->save(false)) {
            $source->updateCounters(['supports' => 1]);
        }
        return ['status' => 'success'];
    }
}