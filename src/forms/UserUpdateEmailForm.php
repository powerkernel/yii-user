<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiiuser\forms;

use powerkernel\yiiauth\models\Auth;
use yii\base\Model;

/**
 * Class UserUpdateEmailForm
 * @package powerkernel\yiiuser\forms
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
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => 'powerkernel\yiiuser\models\User', 'message' => \Yii::t('user', 'This email address has already been taken.')],
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
                $this->addError($attribute, \Yii::t('user', 'We cannot process the request.'));
            } else {
                if ($this->email != $auth->identifier) {
                    $this->addError($attribute, \Yii::t('user', 'We cannot process the request.'));
                }
            }

        }
        unset($params, $validator);
    }
}