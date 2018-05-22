<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

class DefaultController extends \yii\rest\Controller
{
    /**
     * index
     * @return array
     */
    public function actionIndex()
    {
        return [
            'success' => true,
            'coreVersion' => '1.0.0'
        ];
    }
}