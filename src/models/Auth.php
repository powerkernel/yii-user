<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

namespace powerkernel\yiicore\models;

use powerkernel\yiicommon\behaviors\UTCDateTimeBehavior;


/**
 * Class Auth
 * @package powerkernel\yiicore\models
 *
 * @property string $identifier
 * @property string $code
 * @property string $ip
 * @property integer $attempts
 * @property string $status
 * @property \MongoDB\BSON\UTCDateTime $created_at
 * @property \MongoDB\BSON\UTCDateTime $updated_at
 */
class Auth extends \yii\mongodb\ActiveRecord
{
    const STATUS_NEW = 'STATUS_NEW';
    const STATUS_UNVERIFIED = 'STATUS_UNVERIFIED';
    const STATUS_USED = 'STATUS_USED';

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'core_auth';
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            '_id',
            'identifier',
            'code',
            'ip',
            'attempts',
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
    public function behaviors()
    {
        return [
            UTCDateTimeBehavior::class,
        ];
    }

    /**
     * @return int timestamp
     */
    public function getUpdatedAt()
    {
        return $this->updated_at->toDateTime()->format('U');
    }

    /**
     * @return int timestamp
     */
    public function getCreatedAt()
    {
        return $this->created_at->toDateTime()->format('U');
    }


    /**
     * get status list
     * @param null $e
     * @return array
     */
    public static function getStatusOption($e = null)
    {
        $option = [
            self::STATUS_NEW => Yii::t('app', 'New'),
            self::STATUS_USED => Yii::t('app', 'Used'),
        ];
        if (is_array($e))
            foreach ($e as $i)
                unset($option[$i]);
        return $option;
    }

    /**
     * get status text
     * @return string
     */
    public function getStatusText()
    {
        $status = $this->status;
        $list = self::getStatusOption();
        if (!empty($status) && in_array($status, array_keys($list))) {
            return $list[$status];
        }
        return Yii::t('app', 'Unknown');
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {


        $default = [
            [['identifier'], 'match', 'pattern' => '/^(\+[1-9][0-9]{9,14})|([a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?)$/', 'message' => \Yii::t('app', 'Email or phone number is invalid. Note that phone number should begin with a country prefix code.')],
            [['attempts'], 'default', 'value' => 0],

            [['identifier'], 'required'],
            [['code'], 'string', 'length' => 6],

            [['identifier'], 'trim'],
            [['code'], 'match', 'pattern' => '/^[0-9]{6}$/'],

            [['status'], 'string', 'max' => 20],
            [['created_at', 'updated_at'], 'yii\mongodb\validators\MongoDateValidator'],
            //['captcha', ReCaptchaValidator::class, 'message' => Yii::t('app', 'Prove you are NOT a robot')]
        ];

        return $default;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {

        $default = [
            'identifier' => \Yii::t('core', 'Identifier'),
            'code' => \Yii::t('core', 'Verification code'),
            'status' => Yii::t('core', 'Status'),
            'created_at' => Yii::t('core', 'Created At'),
            'updated_at' => Yii::t('core', 'Updated At'),
        ];


        return array_merge($default, $identifier);
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = self::STATUS_NEW;
            $this->ip = \Yii::$app->request->userIP;
            /* demo account */
            if ($this->identifier == \Yii::$app->params['demo_account']) {
                $this->code = Yii::$app->params['demo_pass'];
                return true;
            }
            /* not demo */
            $this->code = (string)rand(100000, 999999);
            /* send code */
            if ($this->getType() == 'phone') {
                return $this->sendSMS();
            }
            if ($this->getType() == 'email') {
                return $this->sendEmail();
            }
            /* cannot send code ? */
            return false;
        } else {
            if ($this->attempts >= 3) {
                $this->status = self::STATUS_UNVERIFIED;
            }
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    /**
     * get identifier type
     * @return bool|string
     */
    public function getType()
    {
        $patterns = [
            'phone' => '/^\+[1-9][0-9]{9,14}$/',
            'email' => '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/'
        ];
        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $this->identifier)) {
                return $type;
            }
        }
        return false;
    }

    /**
     * send SMS code
     * @return bool
     */
    protected function sendSMS()
    {
        return (new AwsSMS())->send(
            $this->identifier,
            Yii::t('app', '{APP}: Your verification code is {CODE}', ['CODE' => $this->code, 'APP' => Yii::$app->name]
            ));
    }

    /**
     * send email code
     * @return bool
     */
    protected function sendEmail()
    {
        $subject = \Yii::t('core', 'Verification code for {APP}', ['APP' => \Yii::$app->name]);
        return \Yii::$app->mailer
            ->compose(
                [
                    'html' => '@vendor/powerkernel/yii-core-api/src/mail/auth-request-html',
                    'text' => '@vendor/powerkernel/yii-core-api/src/mail/auth-request-text'
                ],
                [
                    'model' => $this,
                ]
            )
            ->setFrom(\Yii::$app->params['mailer']['from'])
            ->setTo($this->identifier)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @return array
     */
    public function getAuthenticatedUser()
    {
        $user = User::find()
            ->where(['email' => $this->identifier])
            //->orWhere(['phone'=>$this->identifier])
            ->one();
        if (!$user) {
            $user = new User();
            $user->name = $this->identifier;
            $user->email = $this->identifier;
            $user->save();
        }
        return [
            'identifier' => $user->email,
            'token' => $user->access_token
        ];
    }
}