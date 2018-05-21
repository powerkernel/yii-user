<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiicore\models;


use powerkernel\yiicommon\behaviors\UTCDateTimeBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for User
 *
 * @property mixed _id
 * @property string $name
 * @property string $auth_key
 * @property string $access_token
 * @property string $email
 * @property string $new_email
 * @property string $new_email_code
 * @property string $phone
 * @property string $new_phone
 * @property string $new_phone_code
 * @property string $role
 * @property string $language
 * @property string $timezone
 * @property string $status
 * @property \MongoDB\BSON\UTCDateTime $created_at
 * @property \MongoDB\BSON\UTCDateTime $updated_at
 *
 * @property mixed statusText
 *
 */
class User extends \yii\mongodb\ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 'STATUS_ACTIVE';//10;
    const STATUS_SUSPENDED = 'STATUS_SUSPENDED';//20;


    /**
     * @inheritdoc
     * @return null|object|\yii\mongodb\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return \Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'core_users';
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            '_id',
            'name',
            'auth_key',
            'access_token',
            'email',
            'new_email',
            'new_email_code',
            'phone',
            'new_phone',
            'new_phone_code',
            'role',
            'language',
            'timezone',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * get id
     * @return \MongoDB\BSON\ObjectID|string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'email'], 'filter', 'filter' => 'trim'],

            [['email', 'new_email'], 'email'],
            [['email'], 'filter', 'filter' => 'strtolower'],
            [['phone'], 'match', 'pattern' => '/^\+[1-9][0-9]{9,14}$/'],

            [['name', 'access_token', 'email', 'status'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['language'], 'string', 'max' => 5],

            [['timezone'], 'string', 'max' => 100],
            [['timezone'], 'in', 'range' => timezone_identifiers_list()],

            [['created_at', 'updated_at'], 'yii\mongodb\validators\MongoDateValidator'],

            /* update action */
            [['name', 'email', 'language', 'timezone'], 'required', 'on' => ['create', 'update']],
        ];

    }

    /**
     * @inheritdoc
     * @return array
     */
//    public function fields()
//    {
//        $fields = parent::fields();
//        // remove fields that contain sensitive information
//        //unset($fields['status']);
//        return $fields;
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'auth_key' => \Yii::t('app', 'Auth Key'),
            'email' => \Yii::t('app', 'Email'),
            'phone' => \Yii::t('app', 'Phone'),
            'role' => \Yii::t('app', 'Role'),
            'language' => \Yii::t('app', 'Language'),
            'timezone' => \Yii::t('app', 'Timezone'),
            'status' => \Yii::t('app', 'Status'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            UTCDateTimeBehavior::class,
        ];
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    /**
     * Generates new change email token
     */
    public function generateAccessToken()
    {
        $this->access_token = \Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        if (is_array($id)) {
            $id = array_values($id)[0];
        }
        return static::findOne(['_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

}