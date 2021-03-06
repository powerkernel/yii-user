<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiiuser\models;


use powerkernel\yiicommon\behaviors\UTCDateTimeBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for User
 *
 * @property mixed _id
 * @property string $name
 * @property string $auth_key
 * @property string $access_token
 * @property string $profile_image
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
    const STATUS_ACTIVE = 'STATUS_ACTIVE';
    const STATUS_SUSPENDED = 'STATUS_SUSPENDED';

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'user_db';
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
            'profile_picture',
            'email',
            'new_email',
            'phone',
            'new_phone',
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
            // required
            [['name'], 'required'],
            // Default
            ['language', 'default', 'value' => 'en-US'],
            ['timezone', 'default', 'value' => 'UTC'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            // Rules
            [['name', 'email', 'phone', 'new_phone'], 'filter', 'filter' => 'trim', 'skipOnEmpty' => true],
            // profile picture
            ['profile_picture', 'url'],
            // Name
            ['name', 'string', 'max' => 100],
            ['name', 'filter', 'filter' => 'ucwords'],
            // Email
            [['email', 'new_email'], 'email'],
            [['email', 'new_email'], 'filter', 'filter' => 'strtolower', 'skipOnEmpty' => true],
            // Phone
            [['phone', 'new_phone'], 'match', 'pattern' => '/^\+[1-9][0-9]{9,14}$/', 'skipOnEmpty' => true],
            // Others
            [['auth_key', 'access_token', 'status'], 'string', 'max' => 255],
            [['language'], 'in', 'range' => \Yii::$app->params['languages']],
            [['timezone'], 'in', 'range' => timezone_identifiers_list()],
            // Date
            [['created_at', 'updated_at'], 'yii\mongodb\validators\MongoDateValidator'],
        ];

    }


    /**
     * @inheritdoc
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        // remove fields that contain sensitive information
        unset($fields['auth_key']);
        unset($fields['access_token']);
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => \Yii::t('user', 'ID'),
            'name' => \Yii::t('user', 'Name'),
            'auth_key' => \Yii::t('user', 'Auth Key'),
            'profile_picture' => \Yii::t('user', 'Profile Picture'),
            'email' => \Yii::t('user', 'Email'),
            'phone' => \Yii::t('user', 'Phone'),
            'role' => \Yii::t('user', 'Role'),
            'language' => \Yii::t('user', 'Language'),
            'timezone' => \Yii::t('user', 'Timezone'),
            'status' => \Yii::t('user', 'Status'),
            'created_at' => \Yii::t('user', 'Created At'),
            'updated_at' => \Yii::t('user', 'Updated At'),
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

    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateAuthKey();
            $this->generateAccessToken();
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        if ($insert) {
            // admin
            if (\Yii::$app->params['account']['notification']['admin']['accountCreated']) {
                $subject = \Yii::t('user', 'Customer Sign Up at {APP}', ['APP' => \Yii::$app->name]);
                \Yii::$app->mailer
                    ->compose(
                        [
                            'html' => '@vendor/powerkernel/yii-user/src/mail/user-created-admin-html',
                            'text' => '@vendor/powerkernel/yii-user/src/mail/user-created-admin-text'
                        ],
                        [
                            'model' => $this,
                        ]
                    )
                    ->setFrom(\Yii::$app->params['mailer']['from'])
                    ->setTo(\Yii::$app->params['organization']['adminEmail'])
                    ->setSubject($subject)
                    ->send();
            }
            // user
            if (\Yii::$app->params['account']['notification']['user']['accountCreated']){
                $subject = \Yii::t('user', 'Registration Complete at {APP}', ['APP' => \Yii::$app->name]);
                \Yii::$app->mailer
                    ->compose(
                        [
                            'html' => '@vendor/powerkernel/yii-user/src/mail/user-created-html',
                            'text' => '@vendor/powerkernel/yii-user/src/mail/user-created-text'
                        ],
                        [
                            'model' => $this,
                        ]
                    )
                    ->setFrom(\Yii::$app->params['mailer']['from'])
                    ->setTo($this->email)
                    ->setSubject($subject)
                    ->send();
            }

        }
    }
}