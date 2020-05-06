<?php

namespace home\controllers;

use common\models\UserRegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\models\UserLoginForm;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0xf7f7f7,
                'maxLength' => 4,
                'minLength' => 4,
                'height' => 36,
                'width' => 102,
                'offset'=>6,        //设置字符偏移量 有效果
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionRegister()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $registerHint = false;
        $ofUserRegister = new UserRegisterForm();
        if ($ofUserRegister->load(Yii::$app->request->post()) && $ofUserRegister->register()) {
            $registerHint = '注册成功，等待管理员审核中!!!';
        }

        $ofUserRegister->password = '';
        return $this->render('register', [
            'formValidate' => $ofUserRegister,
            'registerHint'=>$registerHint,
        ]);
    }

    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $ofUserLogin = new UserLoginForm();
        if ($ofUserLogin->load(Yii::$app->request->post()) && $ofUserLogin->login()) {
            return $this->goBack();
        }

        $ofUserLogin->password = '';
        return $this->render('login', [
            'formValidate' => $ofUserLogin,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
