<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Admin;
/**
 * AdminLoginForm is the model behind the login form.
 *
 * @property Admin|null $user This property is read-only.
 *
 */
class AdminLoginForm extends Model
{
    public $username;
    public $password;
    public $remember_me = true;
    public $verify_code;

    private $_admin = false;


    /**
     * @return array the validation rules.
     */
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

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $oqAdmin = $this->getAdmin();

            if (!$oqAdmin || !$oqAdmin->validateLoginPassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->remember_me ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Admin|null
     */
    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = Admin::findByLoginName($this->username);
        }

        return $this->_admin;
    }
}
