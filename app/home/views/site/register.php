<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\UserLoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '用户注册';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <? if( $registerHint === false ):?>
        <p>Please fill out the following fields to register:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\" >{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>
        <?php echo $form->errorSummary($formValidate); ?>

        <?= $form->field($formValidate, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($formValidate, 'password')->passwordInput() ?>

        <?= $form->field($formValidate, 'confirm_password')->passwordInput() ?>

        <?= $form->field($formValidate, 'email')->textInput() ?>

        <?= $form
            ->field($formValidate, 'verify_code')
            ->label(null, ['class' => 'col-lg-1 control-label'])
            ->widget(Captcha::className(), [
                'captchaAction'=>Url::to('site/captcha'),
                'imageOptions'=>[
                    'title'=>'换一个',
                    'alt'=>'换一个',
                ],
                'options' => ['placeholder' => $formValidate->getAttributeLabel('verify_code')],
                'template' => "<div class=\"row\"><div class=\"col-lg-6\" >{input}</div>\n<div class=\"col-lg-3\" >{image}</div></div>",
            ]) ?>


        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                <?= Html::a('登录', ['login'], ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    <? else: ?>
        <div class="jumbotron" style="background: #f5f5f5">
            <h2 style="color: #0f7b9f"><?= $registerHint; ?></h2>
            <p>
            <div class=" text-center" >
                <a href="<?= Url::to('site/login')?>"><span class="btn btn-lg btn-success" style="font-size: 16px">已审核，立即登录</span></a>
                <a href="<?= Url::to('site/index')?>"><span class="btn btn-lg btn-primary" style="font-size: 16px">未审核，返回主页</span></a>
            </div>
            </p>
        </div>

    <? endif; ?>
<!--    <div class="col-lg-offset-1" style="color:#999;">-->
<!--        ©2020 All Rights Reserved. <strong>--><?//= Yii::$app->name ?><!--</strong> is a <strong> php </strong>code. Privacy and Terms<br>-->
<!---->
<!--    </div>-->
</div>
