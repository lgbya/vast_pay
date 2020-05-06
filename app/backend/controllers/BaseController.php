<?php
namespace backend\controllers;

use common\models\Admin;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    protected $_admin = null;

    public function init()
    {
        if (!Yii::$app->user->isGuest) {
            $this->_admin = Admin::findOne(Yii::$app->user->getId());
        }
        parent::init();
    }
}