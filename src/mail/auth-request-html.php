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
<table class="body-wrap" style="background-color: #f6f6f6; width: 100%; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" width="100%" bgcolor="#f6f6f6">
    <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
        <td style="vertical-align: top; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" valign="top"></td>
        <td class="container" width="600" style="vertical-align: top; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0 auto !important; display: block !important; max-width: 600px !important; clear: both !important;" valign="top">
            <div class="content" style="max-width: 600px; display: block; padding: 20px; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" style="background-color: #fff; border: 1px solid #e9e9e9; border-radius: 3px; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" bgcolor="#fff">
                    <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                        <td class="alert alert-good" style="vertical-align: top; color: #fff; border-radius: 3px 3px 0 0; text-align: center; padding: 20px; font-weight: 500; background-color: #68B90F; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; box-sizing: border-box; margin: 0;" valign="top" align="center" bgcolor="#68B90F">
                            <?= $title ?>
                        </td>
                    </tr>
                    <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                        <td class="content-wrap" style="vertical-align: top; padding: 20px; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                                <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                                    <td class="content-block" style="vertical-align: top; padding: 0 0 20px; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" valign="top">
                                        <?= Yii::t('app', 'Hello,') ?>
                                    </td>
                                </tr>
                                <tr style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
                                    <td class="content-block" style="vertical-align: top; padding: 0 0 20px; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" valign="top">
                                        <?= Yii::t('app', 'Your verification code is: <strong>{CODE}', ['CODE' => $model->code]) ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="vertical-align: top; margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;" valign="top"></td>
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