<?php

namespace common\models\form;

use yii\base\Model;
use common\models\User;

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
            'password' => '新密码',
            'confirm_password' => '确认密码',
        ];
    }

    /**
     * 修改登录密码
     */
    public function saveLoginPassword($userId)
    {
        if (!$this->validate()) {
            return  false;
        }
        $oqUser = User::findOne($userId);
        $oqUser->generateLoginPassword($this->password);
        if ($oqUser->save() === false){
            $this->addError('username', '修改密码失败，请联系管理员！！！');
            return false;
        }
        return true;
    }

    /**
     * 修改支付密码
     */
    public function savePayPassword($userId)
    {
        if (!$this->validate()) {
            return  false;
        }
        $oqUser = User::findOne($userId);
        $oqUser->generatePayPassword($this->password);
        if ($oqUser->save() === false){
            $this->addError('username', '修改密码失败，请联系管理员！！！');
            return false;
        }
        return true;
    }

}
