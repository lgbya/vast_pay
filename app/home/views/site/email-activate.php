<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\UserLoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\alert\Alert;

$this->title = '账号激活成功';
$this->params['breadcrumbs'][] = $this->title;
$form = ActiveForm::begin([]);

?>


<div class="site-login">
    <div class="jumbotron" style="background: #f5f5f5">
        <h2 style="color: #0f7b9f">账号激活成功</h2>
        <p>
        <div class=" text-center" >
            <a href="<?= Url::to('/site/login')?>"><span class="btn btn-lg btn-success" style="font-size: 16px">立即登录</span></a>
            <a href="<?= Url::to('/site/index')?>"><span class="btn btn-lg btn-primary" style="font-size: 16px"> 返回主页</span></a>
        </div>
        </p>
    </div>
</div>