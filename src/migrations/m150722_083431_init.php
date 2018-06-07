<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/**
 * Class m150722_083431_init
 */
class m150722_083431_init extends \yii\mongodb\Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $col = Yii::$app->mongodb->getCollection('core_users');
        $col->createIndexes([
            [
                'key' => ['email'],
                'unique' => true,
            ]
        ]);
        $col->createIndexes([
            [
                'key' => ['phone'],
                'unique' => true,
                'sparse' => true
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        /* @var $col \yii\mongodb\Collection */
        $col = Yii::$app->mongodb->getCollection('core_users');
        $col->drop();
    }

}
