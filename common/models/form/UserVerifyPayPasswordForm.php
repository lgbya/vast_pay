<?php

namespace common\models\form;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use common\models\User;

class UserVerifyPayPasswordForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            [[ 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '验证支付密码(初次设置与登录密码一致)',
        ];
    }

    /**
     * 验证支付密码
     */
    public function validatePassword($attribute, $params)
    {
        $user = User::findOne(Yii::$app->user->getId());
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, '密码错误.');
        }
    }

    public function verify(callable $callback, $lsPost, Controller $controller)
    {
        if ($this->load($lsPost) && $this->validate()){
           return call_user_func($callback, $controller);
        }else{
            return $controller->render('@home/views/user/verify-pay-password', [
                'formValidate' => $this,
            ]);
        }
    }
}
