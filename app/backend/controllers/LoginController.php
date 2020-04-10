<?php
namespace backend\controllers;


class LoginController extends BaseController {

    public $layout = false;

    /**
     * {@inheritdoc}
     */
    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 登录页面
     *
     * @return string
     */
    public function actionIndex(){
        return $this->render('index',[]);
    }

    /**
     * ajax登录接口
     *
     * @return string
     */
    public function actionLogin(){

    }

    /**
     * ajax注销接口
     *
     * @return string
     */
    public function actionLogout(){

    }

}
