<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
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

        $omUser = new User();
        $omUser->username = $this->username;
        $omUser->auth_key = $omUser->generateAuthKey();
        $omUser->password_hash = $omUser->generatePassword($this->password);
        $omUser->password_reset_token = $omUser->generatePasswordResetToken();
        $omUser->email = $this->email;
        $omUser->account = $omUser->generateAccount();
        $omUser->pay_md5_key = $omUser->generatePayMd5Key();
        $omUser->status = User::STATUS_REGISTER_AUDIT;

        if ($omUser->save() === false){
            $this->addError('username', '注册失败，请联系管理员！！！');
            return false;
        }
        return true;
    }


}
