<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */


namespace powerkernel\yiicore\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;

/**
 * Class UserController
 */
class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'powerkernel\yiicore\models\User';
    public $serializer = [
        '__class' => \yii\rest\Serializer::class,
        'collectionEnvelope' => 'items',
    ];

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'roles' => ['admin'],
                    'allow' => true,
                ],
                [
                    'actions' => ['me', 'update-me'],
                    'roles' => ['@'],
                    'allow' => true,
                ],
            ],
        ];
        $behaviors['authenticator'] = [
            '__class' => HttpBasicAuth::class,
            //'only' => ['view'],
            //'except' => ['index'],
        ];
        return $behaviors;
    }


    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->request->isPost || \Yii::$app->request->isPatch) {
            \Yii::$app->request->setHeader('Content-Type', 'application/json');
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * get me
     * @return array
     */
    public function actionMe()
    {
        return [
            'success' => true,
            'data' => \Yii::$app->user->identity
        ];
    }

    /**
     * update me
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\UnsupportedMediaTypeHttpException
     */
    public function actionUpdateMe()
    {
        $me = \Yii::$app->user->identity;
        $me->load(\Yii::$app->getRequest()->getParsedBody(), '');
        if ($me->save(true, ['name', 'timezone', 'language'])) {
            return [
                'success' => true,
                //'data' => $me
            ];
        } else {
            return [
                'success' => false,
                'data' => [
                    'error' => $me->errors
                ]
            ];
        }

    }
}
