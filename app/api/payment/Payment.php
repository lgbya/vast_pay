<?php
namespace api\payment;

interface  Payment
{
    public function index($oqPayOrder);
    public function notify();
    public function callback();
    public function query();

}