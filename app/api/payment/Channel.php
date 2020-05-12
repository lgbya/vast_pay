<?php
namespace api\payment;

class Channel
{

    public $successShow;
    public $failShow = 'fail';
    public $supplier_order_id;

    public function notifySuccess($successShow, $supplier_order_id)
    {
        $this->successShow = $successShow;
        $this->supplier_order_id = $supplier_order_id;
        return true;
    }

    public function notifyFail($failShow)
    {
        $this->failShow = $failShow;
        return false;
    }
}