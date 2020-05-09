<?php
namespace api\payment\channel;

use api\payment\Channel;
use api\payment\Payment;


class DemoChannel extends Channel implements Payment
{
    public function index($oqPayOrder)
    {

        echo '我是支付';
//        return $this->responseJson('我是支付');
    }

    public function notify()
    {

        return $this->notifySuccess('SUCCESS', '1234567890');
    }

    public function callback()
    {
    }

    public function query()
    {
    }
}