<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiicore\forms;

use powerkernel\yiicore\models\Auth;
use yii\base\Model;

/**
 * Class AuthGetTokenForm
 * @package powerkernel\yiicore\forms
 */
class AuthGetTokenForm extends Model
{
    public $identifier;
    public $auth_key;
    public $data;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['identifier', 'auth_key'], 'required'],
            ['identifier', 'email'],
            [['identifier', 'auth_key'], 'trim'],
            [['auth_key'], 'checkAuthKey'],
        ];
    }

    /**
     * check auth key
     * @param $attribute
     * @param $params
     */
    public function checkAuthKey($attribute, $params)
    {
        $auth = Auth::find()->where([
            'identifier' => $this->identifier,
            'status' => Auth::STATUS_VERIFIED
        ])->one();

        if ($auth) {
            if ($this->auth_key != $auth->auth_key) {
                $auth->attempts++;
                $this->addError($attribute, \Yii::t('core', 'Wrong auth key. Please try again.'));
            } else {
                $token=$auth->getAccessToken();
                if($token!==false){
                    $auth->status = Auth::STATUS_USED;
                    $this->data = ['token'=>$token];
                }
            }
            $auth->save();
        } else {
            $this->addError($attribute, \Yii::t('core', 'We cannot process the request.'));
        }
        unset($params, $validator);
    }
}