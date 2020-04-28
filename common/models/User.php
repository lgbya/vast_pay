<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $money 现金,单位:分
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username'], 'required'],
            [['money', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 256],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'username'  => '用户名',
            'email'     => '邮箱',
            'money'     => '余额',
            'status'    => '状态',
            'account'   =>'交易账号',
            'created_at'=> '创建时间',
            'updated_at'=> '修改时间',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }



    public static function enumState($type = null, $field = null)
    {
        $lsEnum =  [
            'status'=>[
                self::STATUS_INACTIVE=>'封禁',
                self::STATUS_ACTIVE=>'正常',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ? : $lsEnum[$type] ;
        }

        return $lsEnum;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

}
