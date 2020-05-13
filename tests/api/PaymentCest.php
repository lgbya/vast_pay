<?php

use common\models\User;
use common\models\PayOrder;
use common\models\ChangeUserMoneyLog;
use common\helper\Sign;
use common\helper\ErrorCode;
use \yii\web\NotFoundHttpException;

class PaymentCest extends BaseCest
{
    public $user_id = 1;
    public $success_order_id;
    public $fail_order_id;
    public $_user;
    public $sign_type = 'md5';
    public $money = 10000;

    public function __construct()
    {
        //初始化订单号
        $this->success_order_id = time();
        $this->fail_order_id = time() + 1;
    }

    public function _before(ApiTester $I)
    {
        $this->_user = User::findOne($this->user_id);
        if ($this->_user === null){
            codecept_debug('用户不存在');
        }
    }

    /**
     * 请求支付接口
     */
    public function tryToSuccessIndex(ApiTester $I)
    {
        $lData = $this->getIndexData($this->success_order_id);
        $I->sendPOST('payment/index', $lData);
        $I->seeResponseContains('我是支付！');
    }

    /**
     * 支付回调接口
     */
    public function tryToSuccessNotify(ApiTester $I)
    {

        $lData = $this->getNotifyData($this->success_order_id);
        $I->sendPOST('payment/notify/' . $lData['sys_order_id'],  $lData);
        $I->seeResponseContains('SUCCESS');
        $oqChangeUserMoneyLog = ChangeUserMoneyLog::findOne(['extra'=> $lData['sys_order_id']]);
        if ($oqChangeUserMoneyLog->after_money == ($this->_user->money + $this->money) ){
            throw new NotFoundHttpException('订单完成用户并没有增加金额');
        }
    }

    /**
     * 订单查询接口
     */
    public function tryToSuccessQueryOrder(ApiTester $I)
    {
        $I->sendPOST('payment/query-order',  $this->getQueryOrderData($this->success_order_id));
        $I->seeResponseContainsJson(['error' => '0', 'data'=>['status'=>'1']]);
    }

    /**
     * 请求支付接口验签失败
     */
    public function tryToFailIndex(ApiTester $I)
    {
        $lData = $this->getIndexData($this->fail_order_id);
        $lData['random_string'] = 'abcdefghijklmnopqrstuvwxyz123458';
        $I->sendPOST('payment/index', $lData);
        $I->seeResponseContainsJson(['error' => ErrorCode::PAYMENT_DATA_ERR, 'data'=>['sign'=>['签名错误！']]]);
    }

    /**
     * 支付回调接口失败
     */
    public function tryToFailNotify(ApiTester $I)
    {
        $lData = $this->getNotifyData($this->success_order_id);
        $I->sendPOST('payment/notify/' . $lData['sys_order_id'] . '1',  $lData);
        $I->cantSeeResponseContains('SUCCESS');
    }

    /**
     * 查询订单接口 验签失败和订单不存在
     */
    public function tryToFailQueryOrder(ApiTester $I)
    {
        $lData = $this->getQueryOrderData($this->fail_order_id);
        $I->sendPOST('payment/query-order', $lData);
        $I->seeResponseContainsJson(['error' => ErrorCode::CHANNEL_ORDER_NOT_FOUND_ERR]);

        $lData2 = $this->getQueryOrderData($this->success_order_id);
        $lData2['random_string'] = 'abcdefghijklmnopqrstuvwxyz123458';
        $I->sendPOST('payment/query-order', $lData2);
        $I->seeResponseContainsJson(['error' => ErrorCode::PAYMENT_DATA_ERR, 'data'=>['sign'=>['签名错误！']]]);
    }


    /**
     * 获取请求index的数据
     */
    protected function getIndexData($orderId)
    {
        $lData = [
            'account' => $this->_user->account,
            'product_id' => $this->getProductId(),
            'order_id' => $orderId,
            'money' => $this->money,
            'notify_url' => 'http://www.bbb.com',
            'callback_url' => 'http://www.bbb.com',
            'random_string' => 'abcdefghijklmnopqrstuvwxyz123456',
            'ip' => '127.0.0.1',
            'sign_type' => $this->sign_type,
        ];
        $lData['sign'] = (new Sign($lData['sign_type']))->encrypt($lData, $this->_user);
        return $lData;
    }

    /**
     * 获取回调接口的数据
     */
    protected function getNotifyData($orderId)
    {
        $oqPayOrder = PayOrder::findByUserOrder($this->_user->id, $orderId);
        if($oqPayOrder === null){
            throw new NotFoundHttpException('订单不存在');
        }
        return [
            'sys_order_id' => $oqPayOrder->sys_order_id,
            'supplier_order_id' =>  'test' . time(),
        ];
    }

    /**
     * 获取查询订单的数据
     */
    protected function getQueryOrderData($orderId)
    {
        $lData = [
            'account'  =>    $this->_user->account,
            'order_id' =>    $orderId,
            'random_string' => 'abcdefghijklmnopqrstuvwxyz123456',
            'sign_type'    =>  $this->sign_type,
        ];
        $lData['sign'] = (new Sign($lData['sign_type']))->encrypt($lData, $this->_user);
        return $lData;
    }
}
