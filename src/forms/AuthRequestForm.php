<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiicore\forms;

use yii\base\Model;

/**
 * Class AuthRequestForm
 * @package powerkernel\yiicore\forms
 */
class AuthRequestForm extends Model
{
    public $identifier;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['identifier'], 'required'],
            [['identifier'], 'match', 'pattern' => '/^(\+[1-9][0-9]{9,14})|([a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?)$/', 'message' => \Yii::t('app', 'Email or phone number is invalid. Note that phone number should begin with a country prefix code.')],
        ];
    }
}