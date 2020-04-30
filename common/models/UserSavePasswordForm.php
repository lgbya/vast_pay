<?php

namespace common\models;

use Yii;
use yii\base\Model;

class UserSavePasswordForm extends Model
{
    public $password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
            ['password', 'string', 'length'=>[6, 16], 'message'=>'用户名请输入长度为8-16个字符'],
            ['confirm_password','compare','compareAttribute'=>'password','message'=>'两次输入密码不一致'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'confirm_password' => '确认密码',
        ];
    }


    public function saveLoginPassword($user_id)
    {
        if (!$this->validate()) {
            return  false;
        }
        $oqUser = User::findOne($user_id);
        $oqUser->auth_key = $oqUser->generateAuthKey();
        $oqUser->password_hash = $oqUser->generatePassword($this->password);
        $oqUser->password_reset_token = $oqUser->generatePasswordResetToken();

        if ($oqUser->save() === false){
            $this->addError('username', '修改密码失败，请联系管理员！！！');
            return false;
        }
        return true;
    }


}
