<?php

namespace backend\controllers;

use Yii;


/**
 * ChangeUserMoneyLogController implements the CRUD actions for ChangeUserMoneyLog model.
 */
class DataReportController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
