<?php

namespace home\controllers;

use common\models\form\UserSavePasswordForm;
use common\models\form\UserVerifyPayPasswordForm;
use Yii;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class UserController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 用户基础信息
     */
    public function actionBaseInfo()
    {
        return $this->render('base-info', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * 用户支付信息
     */
    public function actionPayInfo()
    {
        $ofUserVerifyPayPassword = new UserVerifyPayPasswordForm();
        return $ofUserVerifyPayPassword->verify(function($controller){
            return $controller->render('pay-info', [
                'model' => $this->findModel(),
            ]);
        },Yii::$app->request->post(), $this);
    }

    /**
     * 修改登录密码
     */
    public function actionSaveLoginPassword()
    {
        $successHint = false;
        $ofUserSavePassword = new UserSavePasswordForm();
        if ($ofUserSavePassword->load(Yii::$app->request->post()) && $ofUserSavePassword->saveLoginPassword($this->user_id)) {
            $successHint = '登录密码修改成功!!!';
        }

        return $this->render('save-login-password', [
            'formValidate' => $ofUserSavePassword,
            'successHint'=>$successHint,
        ]);
    }

    /**
     * 修改支付密码
     */
    public function actionSavePayPassword()
    {

        $successHint = false;
        $ofUserSavePassword = new UserSavePasswordForm();
        if ($ofUserSavePassword->load(Yii::$app->request->post()) && $ofUserSavePassword->savePayPassword($this->user_id)) {
            $successHint = '支付密码修改成功!!!';
        }

        return $this->render('save-pay-password', [
            'formValidate' => $ofUserSavePassword,
            'successHint'=>$successHint,
        ]);
    }

    protected function findModel()
    {
        if (($model = User::findOne($this->user_id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
