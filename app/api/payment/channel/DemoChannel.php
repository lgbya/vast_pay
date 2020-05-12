<?php
namespace api\payment\channel;

use Yii;
use api\payment\Channel;
use api\payment\Payment;


class DemoChannel extends Channel implements Payment
{
    public function index($oqPayOrder)
    {

        echo '我是支付！';
    }

    public function notify()
    {
        $lPost = Yii::$app->request->post();
        return $this->notifySuccess('SUCCESS', $lPost['supplier_order_id']);
    }

    public function callback()
    {
    }

    public function query()
    {
    }
}