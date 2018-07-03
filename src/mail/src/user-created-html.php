<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/* @var $this yii\web\View */
/* @var $model \powerkernel\yiiuser\models\User */

?>

<span class="preheader"><?= $model->email ?></span>
<table class="main" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="alert alert-primary">
            <?= Yii::t('user', 'Registration Complete') ?>
        </td>
    </tr>
    <tr>
        <td class="content-wrap">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="content-block">
                        <?= Yii::t('user', 'Hello,') ?>
                    </td>
                </tr>
                <tr>
                    <td class="content-block">
                        <?= Yii::t('user', 'You\'ve created a new account at {APP}.', ['APP'=>Yii::$app->name]) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<link href="src/styles.css" media="all" rel="stylesheet" type="text/css"/>