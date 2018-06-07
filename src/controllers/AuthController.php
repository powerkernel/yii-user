<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */


namespace powerkernel\yiicore\controllers;

use powerkernel\yiicore\forms\AuthGetTokenForm;
use powerkernel\yiicore\forms\AuthRequestForm;
use powerkernel\yiicore\models\Auth;


/**
 * Class AuthController
 */
class AuthController extends \powerkernel\yiicommon\controllers\RestController
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            '__class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'request' => ['POST'],
                'verify' => ['POST'],
                'get-access-token' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    /**
     * request for authentication
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\UnsupportedMediaTypeHttpException
     */
    public function actionRequest()
    {
        $form = new AuthRequestForm();
        $form->load(\Yii::$app->getRequest()->getParsedBody(), '');
        if ($form->validate()) {
            $auth = new Auth();
            $auth->identifier = $form->identifier;
            if ($auth->save()) {
                return [
                    'success' => true,
                    'data' => [
                        'aid' => (string)$auth->getId(),
                        'identifier' => $auth->identifier
                    ]
                ];
            }
        }
        return [
            'success' => false,
            'data' => [
                'errors' => $form->errors
            ]
        ];
    }

    /**
     * Get access token
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\UnsupportedMediaTypeHttpException
     */
    public function actionGetAccessToken()
    {
        $form = new AuthGetTokenForm();
        $form->load(\Yii::$app->getRequest()->getParsedBody(), '');
        if ($form->validate()) {
            return [
                'success' => true,
                'data' => [
                    'token' => $form->token
                ]
            ];
        }

        return [
            'success' => false,
            'data' => [
                'errors' => $form->errors
            ]
        ];
    }
}
