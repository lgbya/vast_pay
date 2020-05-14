<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\form\AdminLoginForm;

class SiteController extends BaseController
{

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

        $lAppInfo = [
            'ip地址'    => Yii::$app->request->userIP,
            '域名'      => Yii::$app->request->hostInfo,
            'php版本'   => PHP_VERSION,
            'ZEND版本'  => zend_version(),
            'MYSQL支持' => function_exists('mysqli_close') ? '是' : '否',
            '服务器操作系统' => PHP_OS,
            '服务器端信息'  => $_SERVER['SERVER_SOFTWARE'],
            '最大上传限制'  => get_cfg_var('upload_max_filesize') ?: '不允许上传附件',
            '最大执行时间'  => get_cfg_var("max_execution_time") . '秒',
        ];

        return $this->render('index',[
            'lAppInfo'=>$lAppInfo,
            'oqAdmin' => $this->_admin,
        ]);
    }

    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $ofAdminLogin = new AdminLoginForm();
        if ($ofAdminLogin->load(Yii::$app->request->post()) && $ofAdminLogin->login()) {
            return $this->goBack();
        }

        $ofAdminLogin->password = '';
        return $this->render('login', [
            'formValidate' => $ofAdminLogin,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
