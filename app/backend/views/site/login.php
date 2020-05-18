<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $formValidate \common\models\AdminLoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?= Yii::$app->name;?></b>后台</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($formValidate, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $formValidate->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($formValidate, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $formValidate->getAttributeLabel('password')]) ?>

        <?= $form
            ->field($formValidate, 'verify_code')
            ->label(false)
            ->widget(Captcha::className(), [
            'captchaAction'=>Url::to('site/captcha'),
            'imageOptions'=>[
                'title'=>'换一个',
                'alt'=>'换一个',
            ],
            'options' => ['placeholder' => $formValidate->getAttributeLabel('verify_code')],
            'template' => '<div class="row"><div class="col-lg-8" >{input}</div><div>{image}</div></div>',
        ]) ?>
        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($formValidate, 'remember_me')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>


<!--        <a href="#">I forgot my password</a><br>-->
        <a href="#" class="text-center"> For learning only, no business activities</a>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
