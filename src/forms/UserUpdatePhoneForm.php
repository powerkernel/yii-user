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
 * Class UserUpdatePhoneForm
 * @package powerkernel\yiiuser\forms
 */
class UserUpdatePhoneForm extends Model
{
    public $aid;
    public $code;
    public $phone;
    // check exist

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['aid', 'code', 'phone'], 'required'],
            [['aid', 'code', 'phone'], 'trim'],
            ['phone', 'match', 'pattern' => '/^\+[1-9][0-9]{9,14}$/'],
            ['phone', 'unique', 'targetAttribute' => 'phone', 'targetClass' => 'powerkernel\yiiuser\models\User', 'message' => \Yii::t('user', 'This phone number has already been taken.')],
            ['code', 'checkAuth']
        ];
    }

    /**
     * check auth
     * @param $attribute
     * @param $params
     */
    public function checkAuth($attribute, $params)
    {
        if(!$this->hasErrors()){
            $auth = Auth::verify($this->aid, $this->code);
            if (!$auth) {
                $this->addError($attribute, \Yii::t('user', 'We cannot process the request.'));
            }
            else {
                if($this->phone != $auth->identifier){
                    $this->addError($attribute, \Yii::t('user', 'We cannot process the request.'));
                }
            }
        }
        unset($params, $validator);
    }
}