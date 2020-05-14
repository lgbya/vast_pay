<?php

namespace common\models\form;

use yii\base\Model;
use common\helper\Sign;
use common\models\PayOrder;
use common\models\User;

class PaymentForm extends Model
{
    public $account;        //用户账号
    public $product_id;     //产品id
    public $order_id;       //订单号
    public $money;          //金额 单位分
    public $notify_url;     //异步回调地址
    public $callback_url;   //同步回调地址
    public $random_string;  //随机字符
    public $ip;             //请求的ip
    public $extra = '';          //额外字段
    public $sign_type;      //签名方式：默认md5
    public $sign;           //签名
    protected $_user = false;


    public function rules()
    {
        return [
            [[ 'account', 'product_id', 'order_id', 'money', 'notify_url', 'callback_url','random_string', 'ip', 'sign_type','sign'], 'required'],
            [[ 'product_id',  'money',], 'number'],
            ['order_id', 'string', 'length'=>[10, 32], 'message'=>'订单长度10-32'],
            ['random_string', 'string', 'length'=>32, 'message'=>'随机字符32位'],
            ['notify_url', 'url', 'defaultScheme' => 'http'],
            ['callback_url', 'url', 'defaultScheme' => 'http'],
            ['sign_type', 'in', 'range' => ['md5']],
            [['ip'],'match','pattern'=>'/((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}/','message'=>'ip格式错误'],
        ];
    }

    /**
     * 检测数据
     */
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


        if(PayOrder::findByUserOrder($this->_user->id, $this->order_id) !== null){
            $this->addError('order_id', '重复订单号！');
            return false;
        }

        return true;
    }

    /**
     * 验证签名
     */
    protected function verifySign()
    {
        $oqUser = $this->getUser();
        $lData = [
            'account' => $this->account  ,
            'product_id' => $this->product_id  ,
            'order_id' => $this->order_id  ,
            'money' => $this->money  ,
            'notify_url' => $this->notify_url  ,
            'callback_url' => $this->callback_url  ,
            'random_string' => $this->random_string  ,
            'ip' => $this->ip  ,
            'extra' => $this->extra  ,
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
