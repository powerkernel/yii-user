<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/* @var $this yii\web\View */
/* @var $model \powerkernel\yiicore\models\Auth */

?>

<span class="preheader" style="margin: 0; box-sizing: border-box; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 1px; display: none; mso-hide: all; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; line-height: 1px;"><?= Yii::t('core', '{CODE} is your verification code.', ['CODE' => $model->code]) ?></span>
<table class="main" width="100%" cellpadding="0" cellspacing="0" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; background-color: #fff; border: 1px solid #e9e9e9; border-radius: 3px;" bgcolor="#fff">
    <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
        <td class="alert alert-primary" style="margin: 0; box-sizing: border-box; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; vertical-align: top; color: #fff; font-size: 16px; font-weight: 500; padding: 20px; text-align: center; border-radius: 3px 3px 0 0; background-color: #2196f3;" valign="top" align="center" bgcolor="#2196f3">
            <?= Yii::t('core', 'Verification') ?>
        </td>
    </tr>
    <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
        <td class="content-wrap" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; padding: 20px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                    <td class="content-block" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; padding: 0 0 20px;" valign="top">
                        <?= Yii::t('core', 'Hello,') ?>
                    </td>
                </tr>
                <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                    <td class="content-block" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; padding: 0 0 20px;" valign="top">
                        <?= Yii::t('core', 'Your verification code is: {CODE}', ['CODE' => $model->code]) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<style media="all" type="text/css">
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  h1, h2, h3, h4 {
    font-weight: 800 !important;
    margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    padding: 0 !important;
    width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
}
</style>