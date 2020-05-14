<?php

namespace common\models\form;

use Yii;
use yii\base\Model;
use common\models\User;

class UserLoginForm extends Model
{
    public $username;
    public $password;
    public $remember_me = true;
    public $verify_code;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['remember_me', 'boolean'],
            ['password', 'validatePassword'],
            ['verify_code', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verify_code' => '验证码',
            'remember_me' => '记住我',
        ];
    }

    /**
     * 验证登录密码
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || $user->status === User::STATUS_REGISTER_AUDIT){
                $this->addError($attribute, User::enumState('status', $user->status));
                return false;
            }

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误.');
                return false;
            }
        }
        return true;
    }

    /**
     * 用户登录操作
     */
    public function login()
    {
        if ($this->validate()) {
            $result =  Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600*24*30 : 0);
            if ($result){
                $this->_user->pre_login_at = time();
                $this->_user->save();
            }
            return $result;
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
