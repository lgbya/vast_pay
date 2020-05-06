<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\UserLoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
$form = ActiveForm::begin([]);
?>


<?$this->render('/_form_error_alert',['formValidate'=>$formValidate])?>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">

                <?= $form->field($formValidate, 'username',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                );
                ?>

                <?= $form->field(
                    $formValidate,
                    'password',
                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                    ->passwordInput()
                ?>

                <?= $form
                    ->field($formValidate, 'verify_code')
                    ->widget(Captcha::className(), [
                        'captchaAction'=>Url::to('site/captcha'),
                        'imageOptions'=>[
                            'title'=>'换一个',
                            'alt'=>'换一个',
                        ],
                        'options' => ['placeholder' => $formValidate->getAttributeLabel('verify_code')],
                        'template' => "<div class=\"row\"><div class=\"col-lg-6\" >{input}</div>\n<div class=\"col-lg-3\" >{image}</div></div>",
                    ]) ?>
                <?= $form->field($formValidate, 'remember_me')->checkbox() ?>

                <?= Html::submitButton(
                   '登录',
                    ['class' => 'btn btn-primary btn-block', 'tabindex' => '4']
                ) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
<!--        <p class="text-center">-->
<!--            --><?//= Html::a( 'Didn\'t receive confirmation message?', ['/user/registration/resend']) ?>
<!--        </p>-->
        <p class="text-center">
            <?= Html::a( '没有账号，去注册一个', ['/site/register']) ?>
        </p>
    </div>
</div>


<!--<div class="site-login">-->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <p>Please fill out the following fields to login:</p>-->
<!---->
<!--    --><?php //$form = ActiveForm::begin([
//        'id' => 'login-form',
//        'layout' => 'horizontal',
//        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-lg-3\" >{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//            'labelOptions' => ['class' => 'col-lg-1 control-label'],
//        ],
//    ]); ?>
<!--    --><?php //echo $form->errorSummary($formValidate); ?>
<!---->
<!--        --><?//= $form->field($formValidate, 'username')->textInput(['autofocus' => true]) ?>
<!---->
<!--        --><?//= $form->field($formValidate, 'password')->passwordInput() ?>
<!---->
<!--        --><?//= $form
//            ->field($formValidate, 'verify_code')
//            ->label('验证码', ['class' => 'col-lg-1 control-label'])
//            ->widget(Captcha::className(), [
//                'captchaAction'=>Url::to('site/captcha'),
//                'imageOptions'=>[
//                    'title'=>'换一个',
//                    'alt'=>'换一个',
//                ],
//                'options' => ['placeholder' => $formValidate->getAttributeLabel('verify_code')],
//                'template' => "<div class=\"row\"><div class=\"col-lg-6\" >{input}</div>\n<div class=\"col-lg-3\" >{image}</div></div>",
//            ]) ?>
<!--        --><?//= $form->field($formValidate, 'remember_me')->checkbox([
//            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
//        ]) ?>
<!---->
<!--        <div class="form-group">-->
<!--            <div class="col-lg-offset-1 col-lg-11">-->
<!--                --><?//= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
<!---->
<!--                --><?//= Html::a('注册', ['register'], ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
<!---->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    --><?php //ActiveForm::end(); ?>
<!---->
<!--</div>-->
