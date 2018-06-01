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
 * Class UserUpdateEmailForm
 * @package powerkernel\yiicore\forms
 */
class UserUpdateEmailForm extends Model
{
    public $aid;
    public $code;
    public $email;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['aid', 'code', 'email'], 'required'],
            [['aid', 'code', 'email'], 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => 'powerkernel\yiicore\models\User', 'message' => \Yii::t('core', 'This email address has already been taken.')],
            ['code', 'checkAuth'],
        ];
    }

    /**
     * check auth
     * @param $attribute
     * @param $params
     */
    public function checkAuth($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $auth = Auth::verify($this->aid, $this->code);
            if (!$auth) {
                $this->addError($attribute, \Yii::t('core', 'We cannot process the request.'));
            } else {
                if ($this->email != $auth->identifier) {
                    $this->addError($attribute, \Yii::t('core', 'We cannot process the request.'));
                }
            }

        }
        unset($params, $validator);
    }
}