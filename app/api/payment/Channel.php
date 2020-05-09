<?php
namespace api\payment;

class Channel
{

    public $show;
    public $supplier_order_id;

    public function notifySuccess($show, $supplier_order_id)
    {
        $this->show = $show;
        $this->supplier_order_id = $supplier_order_id;
        return true;
    }

}