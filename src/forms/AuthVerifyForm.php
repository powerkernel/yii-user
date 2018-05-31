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
 * Class AuthVerifyForm
 * @package powerkernel\yiicore\forms
 */
class AuthVerifyForm extends Model
{
    public $id;
    public $code;
    public $data;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'code'], 'required'],
            [['code'], 'checkCode'],
        ];
    }

    /**
     * check code
     * @param $attribute
     * @param $params
     */
    public function checkCode($attribute, $params)
    {
        $auth = Auth::find()->where([
            '_id' => $this->id,
            'status' => Auth::STATUS_NEW
        ])->one();

        if ($auth) {
            if ($this->code != $auth->code) {
                $auth->attempts++;
                $this->addError($attribute, \Yii::t('core', 'Wrong code. Please try again.'));
            } else {
                $auth->status = Auth::STATUS_USED;
                $this->data = $auth->getAuthenticatedUser();
            }
            $auth->save();
        } else {
            $this->addError($attribute, \Yii::t('core', 'We cannot process the request.'));
        }
        unset($params, $validator);
    }
}