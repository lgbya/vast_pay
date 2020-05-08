<?php
namespace common\helper;

use Yii;
use yii\web\Response;

class Helper
{
    public static function showJsonSuccess($data = [])
    {
        return self::showJsonError(0, 'success', $data);
    }

    public static function showJsonError($error ,  $message = '', $data = [])
    {
        $message = $message != ''?:ErrorCode::explain($error);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'error'     =>  $error,
            'message'   =>  $message,
            'data'      =>  $data,
        ];
    }

    public static  function cuttingDateRange($dateString, $delimiter ='到' ){
        $lDate = explode($delimiter, $dateString);
        if (count($lDate) != 2){
            return [];
        }

        return [strtotime($lDate[0]), strtotime($lDate[1])];
    }

     public static function  formatMoney($money, $len=2, $sign='￥'){
         $money = $money/100;
         $negative = $money > 0 ? '' : '-';
         $intMoney = intval(abs($money));
         $len = intval(abs($len));
         $decimal = '';//小数
         if ($len > 0) {
             $decimal = '.'.substr(sprintf('%01.'.$len.'f', $money),-$len);
         }
         $tmpMoney = strrev($intMoney);
         $strLen = strlen($tmpMoney);
         $formatMoney = '';
         for ($i = 3; $i < $strLen; $i += 3) {
             $formatMoney .= substr($tmpMoney,0,3).',';
             $tmpMoney = substr($tmpMoney,3);
         }
         $formatMoney .= $tmpMoney;
         $formatMoney = strrev($formatMoney);
         return $sign.$negative.$formatMoney.$decimal;
     }
}