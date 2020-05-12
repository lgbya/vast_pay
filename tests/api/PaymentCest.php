<?php

use common\models\User;
use common\models\PayOrder;
use common\models\PayChannel;
use common\models\UserToPayChannel;
use common\helper\Sign;

class PaymentCest
{
    public $user_id = 1;
    public $order_id;
    public $_user;
    public $sign_type = 'md5';

    public function __construct()
    {
        $this->order_id = time();
    }

    public function _before(ApiTester $I)
    {

        $this->_user = User::findOne($this->user_id);
        if ($this->_user === null){
            codecept_debug('用户不存在');
        }
    }

    /**
     * 测试请求支付接口
     */
    public function tryToSuccessIndex(ApiTester $I)
    {
        $lPost = [
            'account' => $this->_user->account,
            'product_id' => $this->getProductId(),
            'order_id' => $this->order_id,
            'money' => 10000,
            'notify_url' => 'http://www.bbb.com',
            'callback_url' => 'http://www.bbb.com',
            'random_string' => 'abcdefghijklmnopqrstuvwxyz123456',
            'ip' => '127.0.0.1',
            'sign_type' => $this->sign_type,
        ];
        $lPost['sign'] = (new Sign($lPost['sign_type']))->encrypt($lPost, $this->_user);
        $I->sendPOST('payment/index', $lPost);
        $I->seeResponseContains('我是支付！');
    }

    /**
     * 测试支付回调接口
     */
    public function tryToSuccessNotify(ApiTester $I)
    {

        $oqPayOrder = PayOrder::findByUserOrder($this->_user->id, $this->order_id);
        if($oqPayOrder === null){
            codecept_debug('订单不存在');
        }
        $lPost = [
            'sys_order_id' => $oqPayOrder->sys_order_id,
            'supplier_order_id' =>  'test' . time(),
        ];
        $I->sendPOST('payment/notify/' . $oqPayOrder->sys_order_id, $lPost);
        $I->seeResponseContains('SUCCESS');
    }

    /**
     * 测试支付回调接口
     */
    public function tryToSuccessQueryOrder(ApiTester $I)
    {
        $lPost = [
            'account'  =>      $this->_user->account,
            'order_id' =>    $this->order_id,
            'random_string' => 'abcdefghijklmnopqrstuvwxyz123456',
            'sign_type'    =>  $this->sign_type,
        ];
        $lPost['sign'] = (new Sign($lPost['sign_type']))->encrypt($lPost, $this->_user);
        $I->sendPOST('payment/query-order', $lPost);
        $I->seeResponseContainsJson(['error' => '0', 'data'=>['status'=>'1']]);
    }

    /**
     * 获取产品id
     */
    protected function getProductId()
    {
        $oqlUserToPayChannel = UserToPayChannel::find()->andFilterWhere(['user_id'=>$this->_user->id])->all();

        if(count($oqlUserToPayChannel) == 0){
            codecept_debug('用户没有分配到通道');
        }

        $productId = 0;
        foreach($oqlUserToPayChannel as $k => $v){
            $oqPayChannel = $v->payChannel;
            if($oqPayChannel->status == PayChannel::STATUS_ON && $oqPayChannel->is_del == PayChannel::DEL_STATE_NO){
                $productId = $oqPayChannel->product_id;
                break;
            }
        }
        if($productId == 0){
            codecept_debug('用户分配到通道不可用');
        }
        return $productId;
    }
}
