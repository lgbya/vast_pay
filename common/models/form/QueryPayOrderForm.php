<?php

namespace common\models\form;

use common\helper\Sign;
use yii\base\Model;
use common\models\User;

class QueryPayOrderForm extends Model
{
    public $account;        //用户账号
    public $order_id;       //订单号
    public $random_string;  //随机字符
    public $sign_type;      //签名方式：默认md5
    public $sign;           //签名
    protected $_user = false;


    public function rules()
    {
        return [
            [[ 'account', 'order_id', 'random_string', 'sign_type','sign'], 'required'],
            ['order_id', 'string', 'length'=>[10, 32], 'message'=>'订单长度10-32'],
            ['random_string', 'string', 'length'=>32, 'message'=>'随机字符32位'],
            ['sign_type', 'in', 'range' => ['md5']],
        ];
    }

    public function checkData()
    {
        if(!$this->validate()){
            return false;
        }

        if ($this->getUser() === null){
            $this->addError('account', '用户不存在或者用户禁止交易！');
            return false;
        }

        if(!$this->verifySign()){
            $this->addError('sign', '签名错误！');
            return false;
        }

        return true;
    }

    public function verifySign()
    {
        $oqUser = $this->getUser();
        $lData = [
            'account' => $this->account  ,
            'order_id' => $this->order_id  ,
            'random_string' => $this->random_string  ,
            'sign_type' => $this->sign_type ,
        ];
        return (new Sign( $this->sign_type))->verify($this->sign, $lData, $oqUser);
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByAccount($this->account);
        }

        return $this->_user;
    }
}
