<?php
namespace common\models;

use Yii;
use yii\web\Response;

class Helper
{
    static public function showJsonSuccess($data = [])
    {
        return self::showJsonError(0, "success", $data);
    }

    static public function showJsonError($error ,  $message = "", $data = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'error'     =>  $error,
            'message'   =>  $message,
            'data'      =>  $data,
        ];
    }

    static public function cuttingDateRange($dateString, $delimiter ='到' ){
        $lDate = explode($delimiter, $dateString);
        if (count($lDate) != 2){
            return [];
        }

        return [strtotime($lDate[0]), strtotime($lDate[1])];
    }
}