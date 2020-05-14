<?php

namespace common\models\form;

use Yii;
use yii\base\Model;
use common\models\User;

class UserRegisterForm extends Model
{
    public $username;
    public $password;
    public $confirm_password;
    public $email;
    public $verify_code;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirm_password', 'email'], 'required'],
            ['username', 'string', 'length'=>[4, 12], 'message'=>'用户名请输入长度为6-12个字符'],
            ['password', 'string', 'length'=>[6, 16], 'message'=>'用户名请输入长度为8-16个字符'],
            ['email', 'email'],
            ['confirm_password','compare','compareAttribute'=>'password','message'=>'两次输入密码不一致'],
            ['verify_code', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'confirm_password' => '确认密码',
            'email' => 'email',
            'verify_code' => '验证码',
        ];
    }

    /**
     * 用户注册操作
     */
    public function register()
    {
        if (!$this->validate()) {
            return  false;
        }
        $oqUser = User::find()
            ->orWhere(['username' => $this->username])
            ->orWhere(['email' => $this->email])
            ->one();
        if ($oqUser !== null){
            $this->addError('username', '用户名或邮箱已注册！！！');
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        $omUser = new User();
        $omUser->username = $this->username;
        $omUser->generateLoginPassword($this->password);
        $omUser->generatePayPassword($this->password);
        $omUser->email = $this->email;
        $omUser->account = $omUser->generateAccount();
        $omUser->pay_md5_key = $omUser->generatePayMd5Key();
        $omUser->status = User::STATUS_REGISTER_AUDIT;

        $omEmailCode = new EmailCode();
        if(!$omEmailCode->sendCode($this->email)){
            $transaction->rollBack();
            $this->addError('email', '邮箱发送失败！！！');
            return false;
        }

        if ($omUser->save() === false){
            $transaction->rollBack();
            $this->addError('username', '注册失败，请联系管理员！！！');
            return false;
        }

        $transaction->commit();
        return true;
    }


}
