<?php
namespace common\helper;

class ErrorCode
{
    const SYSTEM_ERR = 400;
    const NOT_FOUND_ERR = 404;
    const PAYMENT_FORM_ERR = 405;
    const PAYMENT_DATA_ERR = 406;
    const CHANNEL_NOT_FOUND = 407;
    const CHANNEL_ACCOUNT_NOT_FOUNT = 408;
    const GENERATE_ORDER_ERR = 409;
    const CHANNEL_FILE_ERR = 410;
    const CHANNEL_ORDER_NOT_FOUND_ERR = 411;


    public static function explain($code)
    {
        $lErrorCode = [
            self::SYSTEM_ERR => '系统错误！！！',
            self::NOT_FOUND_ERR => '找不到对应的接口',
            self::PAYMENT_FORM_ERR =>'请求格式错误',
            self::PAYMENT_DATA_ERR => '数据验证失败',
            self::CHANNEL_NOT_FOUND => '没有开通支付模式',
            self::CHANNEL_ACCOUNT_NOT_FOUNT => '支付账号错误',
            self::GENERATE_ORDER_ERR => '生成订单错误！！！',
            self::CHANNEL_FILE_ERR => '接口文件不存在',
            self::CHANNEL_ORDER_NOT_FOUND_ERR => '订单不存在',
        ];
        return isset($lErrorCode[$code]) ? $lErrorCode[$code]:'';
    }
}