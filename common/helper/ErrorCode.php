<?php
namespace common\helper;

class ErrorCode
{

    const NOT_FOUND = 405;
    const UNAUTHORIZED = 401;
    const UNPROCESSABLE_ENTITY = 422;


    public static function explain($code)
    {
        $lErrorCode = [
            self::UNAUTHORIZED => '数据验证失败',
            self::NOT_FOUND => '找不到对应的接口',
            self::UNPROCESSABLE_ENTITY =>'请求格式错误',
        ];
        return $lErrorCode[$code];
    }


}