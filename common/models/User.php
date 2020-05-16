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
 * @property string $pay_password_hash
 * @property string|null $pay_password_reset_token
 * @property string $email
 * @property string $account
 * @property string $pay_md5_key
 * @property int $money 现金,单位:分
 * @property int $status
 * @property int $pre_login_at
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    const TABLE_NAME = 'user';

    const STATUS_INACTIVE = 0;
    const STATUS_REGISTER_AUDIT = 1;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%'. self::TABLE_NAME . '}}';
    }

    public function rules()
    {
        return [
            [['username'], 'required'],
            [['money'], 'number'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 256],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'            =>  'ID',
            'username'      =>  '用户名',
            'email'         =>  '邮箱',
            'money'         =>  '余额',
            'status'        =>  '状态',
            'account'       =>  '交易账号',
            'pay_md5_key'   =>  '支付md5秘钥',
            'pre_login_at'  =>  '上次登录时间',
            'created_at'    =>  '创建时间',
            'updated_at'    =>  '修改时间',
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

    public function generateLoginPassword($password)
    {
        $this->auth_key = $this->generateAuthKey();
        $this->password_hash = $this->generatePassword($password);
        $this->password_reset_token = $this->generatePasswordResetToken();
        return $this;
    }

    public function generatePayPassword($password)
    {
        $this->pay_password_hash = $this->generatePassword($password);
        $this->pay_password_reset_token = $this->generatePasswordResetToken();
        return $this;
    }

    public function generateAccount()
    {
        $prefix = Yii::$app->getSecurity()->generateRandomString(5);
        $suffix = date('YmdHis') + self::find()->count() + 1;
        return $prefix . $suffix;
    }

    public function generatePayMd5Key()
    {
        return md5( Yii::$app->getSecurity()->generateRandomString() );
    }


    public function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }

    public function generatePassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    public static function enumState($type = null, $field = null)
    {
        $lsEnum =  [
            'status'=>[
                self::STATUS_INACTIVE=>'封禁',
                self::STATUS_ACTIVE=>'正常',
                self::STATUS_REGISTER_AUDIT =>'账号未激活',
            ],
        ];

        if (isset($lsEnum[$type])){
            return $lsEnum[$type][$field] ?? $lsEnum[$type] ;
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


    public function addMoney( $money, $type, $extra='')
    {
        return $this->changeMoney( abs($money), $type, $extra);
    }

    public function subMoney(  $money, $type, $extra='')
    {
        if ($this->money >= abs($money)){
            return $this->changeMoney( -abs($money), $type, $extra);
        }else{
            $this->addError('money', '扣除金额不能高于用户拥有的金额');
            return false;
        }
    }

    protected  function changeMoney($money, $type, $extra)
    {
        //判断调用方法是否开启事务
        $transaction = Yii::$app->db->getTransaction();

        if ($transaction === null){
            $transaction = Yii::$app->db->beginTransaction();
        }


        $omChangeUserMoneyLog = new ChangeUserMoneyLog();
        $omChangeUserMoneyLog->user_id = $this->id;
        $omChangeUserMoneyLog->change_money = $money;
        $omChangeUserMoneyLog->before_money = $this->money;
        $omChangeUserMoneyLog->after_money = $this->money + $money;
        $omChangeUserMoneyLog->type = $type;
        $omChangeUserMoneyLog->extra = $extra;
        if ($omChangeUserMoneyLog->save() === false){
            Yii::warning([
                'message' =>'用户金额更改日志失败！！！',
                'type'=>$type,
                'extra'=>$extra,
                'errors'=> $omChangeUserMoneyLog->errors
            ]);
            $transaction->rollBack();
            return false;
        }

        $result = $this->updateCounters(['money' => $money]);
        if (!$result){
            Yii::warning([
                'message' =>'用户金额添加失败！！！',
                'type'=>$type,
                'extra'=>$extra,
                'errors'=> $this->errors
            ]);
            $transaction->rollBack();
            return false;
        }

        if ($transaction === null){
            $transaction->commit();
        }
        return true;
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
        return static::findOne(['username' => $username]);
    }

    public static function findByAccount($account)
    {
        return static::findOne(['account' => $account, 'status'=>self::STATUS_ACTIVE]);
    }
}
