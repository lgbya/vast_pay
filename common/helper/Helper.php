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
        $message = $message != ''? $message : ErrorCode::explain($error);
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

     public static function  formatMoney($money, $len=3, $sign='￥'){
         $money = $money/100;
         $negative = $money >= 0 ? '' : '-';
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

    public static function countWeight($lsData){
        $lsTemp = [];
        foreach($lsData as $v){
            for($i = 0; $i < $v['weight']; $i++){
                $lsTemp[] = $v;//放大数组
            }
        }
        if ($lsTemp == []){
            return [];
        }
        $int=mt_rand(0, count($lsTemp)-1);
        return $lsTemp[$int];
    }

    public static function createForm($url, $lData = [])
    {
        $formStr = '<form action="' . $url . '" method="post">';
        foreach ($lData as $k => $v){
            $formStr .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $formStr .= '</form>';
        return $formStr;
    }

    public static function joinToUppercase($str, $symbol = '-')
    {
        $lsStr = preg_split('/(?=[A-Z])/',$str);
        $string = '';
        foreach($lsStr as $v){
            $string .= strtolower($v) . $symbol;
        }
        return trim($string, $symbol);
    }

    public static function restoreUppercase($str, $symbol = '-')
    {
        $lsStr = explode($symbol, $str);

        $string = '';
        foreach($lsStr as $v){
            $string .= ucfirst($v) ;
        }
        return $string;
    }

    public static function randomStr($n = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public static function sendEmail($email, $subject='', $htmlBody='')
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($email);
        $mail->setSubject($subject);
        $mail->setHtmlBody($htmlBody);    //发布可以带html标签的文本
        return $mail->send();
    }
}