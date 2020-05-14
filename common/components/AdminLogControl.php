<?php

namespace common\components;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use yii\helpers\Url;
use common\models\AdminLog;

class AdminLogControl
{
    public static function write($event)
    {
        if(!Yii::$app->user->isGuest) {

            $omAdminLog = new AdminLog();
            $omAdminLog->admin_id = Yii::$app->user->identity->id;
            $omAdminLog->admin_name = Yii::$app->user->identity->username;

            $omAdminLog->route = Url::to();
            $omAdminLog->admin_ip = Yii::$app->request->userIP;
            $headers = Yii::$app->request->headers;
            if ($headers->has('User-Agent')) {
                $omAdminLog->admin_agent =  $headers->get('User-Agent');
            }
            $omAdminLog->created_at = time();
            if (!strpos($omAdminLog->route, 'admin-log') &&
                !strpos($omAdminLog->route, 'assets') &&
                !strpos($omAdminLog->route, 'debug')){
                $omAdminLog->save();
            }
        }
    }
}