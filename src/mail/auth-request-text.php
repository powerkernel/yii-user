<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/* @var $this yii\web\View */
/* @var $model \powerkernel\yiicore\models\Auth */
/* @var $title string */

?>


<?= Yii::t('core', 'Hello,') ?>


<?= Yii::t('core', 'Your verification code is: {CODE}', ['CODE' => $model->code]) ?>