<?php
namespace backend\controllers;

use common\models\Helper;

class SiteController extends BaseController{
    /**
     * {@inheritdoc}
     */
    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0xf7f7f7,
                'maxLength' => 4,
                'minLength' => 4,
                'height' => 40,
                'width' => 115,
                'offset'=>6,        //设置字符偏移量 有效果
            ],
        ];
    }

    public function actionIndex(){
        return Helper::showJsonSuccess();
    }

}
