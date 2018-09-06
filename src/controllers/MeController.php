<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */


namespace powerkernel\yiiuser\controllers;

use powerkernel\yiiuser\forms\UserUpdateEmailForm;
use powerkernel\yiiuser\forms\UserUpdatePhoneForm;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;


/**
 * Class MeController
 */
class MeController extends \powerkernel\yiicommon\controllers\RestController
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            '__class' => AccessControl::class,
            'rules' => [
                [
                    'verbs' => ['OPTIONS'],
                    'allow' => true,
                ],
                [
                    'actions' => ['index', 'update', 'update-email', 'update-phone'],
                    'roles' => ['@'],
                    'allow' => true,
                ],
            ],
        ];
        $behaviors['authenticator'] = [
            '__class' => HttpBasicAuth::class,
            'except'=>['options'] // avoid authentication on CORS-pre-flight requests
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     * @return array
     */
    protected function verbs()
    {
        $parents = parent::verbs();
        return array_merge(
            $parents,
            [
                'index' => ['GET'],
                'update' => ['POST'],
                'update-phone' => ['POST'],
                'update-email' => ['POST'],
            ]
        );
    }

    /**
     * get me
     * @return array
     */
    public function actionIndex()
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
    public function actionUpdate()
    {
        $me = \Yii::$app->user->identity;
        $me->load(\Yii::$app->getRequest()->getParsedBody(), '');
        if ($me->save(true, ['name', 'timezone', 'language'])) {
            return [
                'success' => true,
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

    public function actionUpdateProfilePicture()
    {
        
    }

    public function actionRemoveProfilePicture()
    {

    }

    /**
     * user update email
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\UnsupportedMediaTypeHttpException
     */
    public function actionUpdateEmail()
    {
        $form = new UserUpdateEmailForm();
        $form->load(\Yii::$app->getRequest()->getParsedBody(), '');
        if ($form->validate()) {
            $me = \Yii::$app->user->identity;
            $me->email = $form->email;
            if ($me->save(true, ['email'])) {
                return [
                    'success' => true,
                    'data' => [
                        'email' => $form->email
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'data' => [
                        'error' => $me->errors
                    ]
                ];
            }
        } else {
            return [
                'success' => false,
                'data' => [
                    'error' => $form->errors
                ]
            ];
        }
    }

    /**
     * Update phone number
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\UnsupportedMediaTypeHttpException
     */
    public function actionUpdatePhone()
    {
        $form = new UserUpdatePhoneForm();
        $form->load(\Yii::$app->getRequest()->getParsedBody(), '');
        if ($form->validate()) {
            $me = \Yii::$app->user->identity;
            $me->phone = $form->phone;
            if ($me->save(true, ['phone'])) {
                return [
                    'success' => true,
                    'data' => [
                        'phone' => $form->phone
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'data' => [
                        'error' => $me->errors
                    ]
                ];
            }
        } else {
            return [
                'success' => false,
                'data' => [
                    'error' => $form->errors
                ]
            ];
        }
    }
}
