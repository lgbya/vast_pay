<?php
namespace home\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{

    public $user_id = null;

    public function init()
    {
        $this->user_id = Yii::$app->user->getId();
        parent::init();
    }
}