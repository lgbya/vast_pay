<?php

namespace home\controllers;

use common\models\EmailCode;
use common\models\User;
use common\models\form\UserRegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\form\UserLoginForm;

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


    /**
     * 首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * 注册
     */
    public function actionRegister()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $registerHint = false;
        $ofUserRegister = new UserRegisterForm();
        if ($ofUserRegister->load(Yii::$app->request->post()) && $ofUserRegister->register()) {
            $registerHint = '注册成功, 激活邮件已发送注册邮箱, 请到邮箱激活账号以正常使用本系统!!!';
        }

        $ofUserRegister->password = '';
        return $this->render('register', [
            'formValidate' => $ofUserRegister,
            'registerHint'=>$registerHint,
        ]);
    }

    /**
     * 登录
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $ofUserLogin = new UserLoginForm();
        if ($ofUserLogin->load(Yii::$app->request->post()) && $ofUserLogin->login()) {
            return $this->redirect('/user/base-info');
        }

        $ofUserLogin->password = '';
        return $this->render('login', [
            'formValidate' => $ofUserLogin,
        ]);
    }

    /**
     * 注销
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionEmailActivate($code)
    {

        if(($oqEmailCode = EmailCode::findOne(['code' => $code])) === null){
            throw new NotFoundHttpException(Yii::t('app', '请点击有效的激活码'));
        }

        if(($oqUser = User::findOne(['email' => $oqEmailCode->email])) === null){
            throw new NotFoundHttpException(Yii::t('app', '该邮箱未注册用户'));
        }


        $transaction = Yii::$app->db->beginTransaction();
        $oqUser->status = User::STATUS_ACTIVE;
        if ($oqUser->save() && $oqEmailCode->delete()){
            $transaction->commit();
            return $this->render('email-activate');
        }

        $transaction->rollBack();
        throw new NotFoundHttpException(Yii::t('app', '激活失败'));

    }
}
