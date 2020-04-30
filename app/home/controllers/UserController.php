<?php

namespace home\controllers;

use common\models\UserSavePasswordForm;
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

    public function actionSaveLoginPassword(){

        $successHint = false;
        $ofUserSavePassword = new UserSavePasswordForm();
        if ($ofUserSavePassword->load(Yii::$app->request->post()) && $ofUserSavePassword->saveLoginPassword($this->user_id)) {
            $successHint = '注册成功，等待管理员审核中!!!';
        }

        return $this->render('save-login-password', [
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
