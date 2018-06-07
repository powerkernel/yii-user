<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/**
 * Class m150722_083432_rbac
 */
class m150722_083432_rbac extends \yii\mongodb\Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $authItem=Yii::$app->mongodb->getCollection('core_auth_item');
        $authItem->createIndexes([
            [
                'key'=>['name'],
                'unique'=>true,
            ]
        ]);

        $authRule=Yii::$app->mongodb->getCollection('core_auth_rule');
        $authRule->createIndexes([
            [
                'key'=>['name'],
                'unique'=>true,
            ]
        ]);

        $authAssignment=Yii::$app->mongodb->getCollection('core_auth_assignment');
        $authAssignment->createIndexes([
            [
                'key'=>['user_id', 'item_name'],
                'unique'=>true,
            ]
        ]);

        $this->addRbac();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        /* @var $authItem \yii\mongodb\Collection */
        $authItem=Yii::$app->mongodb->getCollection('core_auth_item');
        $authItem->drop();
        $authRule=Yii::$app->mongodb->getCollection('core_auth_rule');
        $authRule->drop();
        $authAssignment=Yii::$app->mongodb->getCollection('core_auth_assignment');
        $authAssignment->drop();
    }

    /**
     * add default RBAC
     * @throws \yii\base\Exception
     */
    protected function addRbac(){
        /* authManager */
        $auth = Yii::$app->authManager;
        /* admin */
        $admin = $auth->createRole('admin');
        $admin->description='Full access';
        $auth->add($admin);

        // add the owner rule
        $rule = new \powerkernel\yiicommon\rbac\OwnerRule();
        $auth->add($rule);

        // add the "updateOwnItem" permission and associate the rule with it.
        $updateOwnItem = $auth->createPermission('updateOwnItem');
        $updateOwnItem->description = 'Update own item';
        $updateOwnItem->ruleName = $rule->name;
        $auth->add($updateOwnItem);

        // allow "member" to update their own item
        $member = $auth->createRole('member');
        $auth->add($member);
        $auth->addChild($member, $updateOwnItem);
    }

}
