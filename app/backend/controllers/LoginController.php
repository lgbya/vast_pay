<?php
namespace backend\controllers;


use common\models\AdminLoginForm;

class LoginController extends BaseController {

    public $layout = false;


    /**
     * 登录页面
     *
     * @return string
     */
    public function actionIndex(){
        $ofAdminLogin = new AdminLoginForm();
        return $this->render('index',[
            'objectForm' => $ofAdminLogin,
        ]);
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
