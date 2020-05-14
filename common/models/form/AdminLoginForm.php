<?php

namespace common\models\form;

use Yii;
use yii\base\Model;
use common\models\Admin;

class AdminLoginForm extends Model
{
    public $username;
    public $password;
    public $remember_me = true;
    public $verify_code;

    private $_admin = false;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'verify_code'], 'required'],
            // rememberMe must be a boolean value
            ['remember_me', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verify_code', 'captcha'],

        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $oqAdmin = $this->getAdmin();

            if (!$oqAdmin || !$oqAdmin->validateLoginPassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()
    {
        $oqAdmin = $this->getAdmin();
        if ($this->validate()) {
            $result = Yii::$app->user->login($oqAdmin, $this->remember_me ? 3600*24*30 : 0);
            $oqAdmin->pre_login_at = time();
            $oqAdmin->pre_login_ip = Yii::$app->request->userIP;
            $oqAdmin->save();
            return $result;
        }
        return false;
    }

    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = Admin::findByLoginName($this->username);
        }

        return $this->_admin;
    }
}
