<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\UserLoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\" >{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?php echo $form->errorSummary($formValidate); ?>

        <?= $form->field($formValidate, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($formValidate, 'password')->passwordInput() ?>

        <?= $form
            ->field($formValidate, 'verify_code')
            ->label('验证码', ['class' => 'col-lg-1 control-label'])
            ->widget(Captcha::className(), [
                'captchaAction'=>Url::to('site/captcha'),
                'imageOptions'=>[
                    'title'=>'换一个',
                    'alt'=>'换一个',
                ],
                'options' => ['placeholder' => $formValidate->getAttributeLabel('verify_code')],
                'template' => "<div class=\"row\"><div class=\"col-lg-6\" >{input}</div>\n<div class=\"col-lg-3\" >{image}</div></div>",
            ]) ?>
        <?= $form->field($formValidate, 'remember_me')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                <?= Html::a('注册', ['register'], ['class' => 'btn btn-default', 'name' => 'login-button']) ?>

            </div>
        </div>

    <?php ActiveForm::end(); ?>

<!--    <div class="col-lg-offset-1" style="color:#999;">-->
<!--        ©2020 All Rights Reserved. <strong>--><?//= Yii::$app->name ?><!--</strong> is a <strong> php </strong>code. Privacy and Terms<br>-->
<!---->
<!--    </div>-->
</div>
