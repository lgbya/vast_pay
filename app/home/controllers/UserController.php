<?php

namespace home\controllers;

use common\models\UserSavePasswordForm;
use common\models\UserVerifyPayPasswordForm;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
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


    public function actionBaseInfo()
    {
        return $this->render('base-info', [
            'model' => $this->findModel(),
        ]);
    }

    public function actionPayInfo()
    {
        $ofUserVerifyPayPassword = new UserVerifyPayPasswordForm();
        return $ofUserVerifyPayPassword->verify(function($controller){
            return $controller->render('pay-info', [
                'model' => $this->findModel(),
            ]);
        },Yii::$app->request->post(), $this);
    }

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
