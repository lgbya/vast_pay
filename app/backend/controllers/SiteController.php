<?php
namespace backend\controllers;

use common\models\Helper;

class SiteController extends BaseController{

    public function actionIndex(){
        return Helper::showJsonSuccess();
    }

}
