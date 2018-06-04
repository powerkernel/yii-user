<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/* @var $this yii\web\View */
/* @var $model \powerkernel\yiicore\models\Auth */

?>

<span class="preheader"><?= $model->email ?></span>
<table class="main" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="alert alert-primary">
            <?= Yii::t('core', 'Customer Sign Up') ?>
        </td>
    </tr>
    <tr>
        <td class="content-wrap">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="content-block">
                        <?= Yii::t('core', 'Hello,') ?>
                    </td>
                </tr>
                <tr>
                    <td class="content-block">
                        <?= Yii::t('core', 'The following customer has signed up at your website:') ?>
                    </td>
                </tr>
                <tr>
                    <td class="content-block">
                        <?= Yii::t('core', 'Email: {EMAIL}', ['EMAIL'=>$model->email]) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<link href="src/styles.css" media="all" rel="stylesheet" type="text/css"/>