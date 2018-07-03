<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/* @var $this yii\web\View */
/* @var $model \powerkernel\yiiuser\models\User */
/* @var $title string */

?>


<?= Yii::t('user', 'Hello,') ?>


<?= Yii::t('user', 'The following customer has signed up at your website:') ?>

<?= Yii::t('user', 'Email: {EMAIL}', ['EMAIL'=>$model->email]) ?>
