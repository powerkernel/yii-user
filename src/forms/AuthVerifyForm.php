<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiicore\forms;

use yii\base\Model;

class AuthVerifyForm extends Model
{
    public $id;
    public $code;


    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'code'], 'required'],
        ];
    }
}