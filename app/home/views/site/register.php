<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\UserLoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\alert\Alert;

$this->title = '用户注册';
$this->params['breadcrumbs'][] = $this->title;
$form = ActiveForm::begin([]);

?>

<? if( $registerHint === false ):?>
    <?$this->render('/_form_error_alert',['formValidate'=>$formValidate])?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>

                <div class="panel-body">

                    <?= $form->field($formValidate, 'email') ?>

                    <?= $form->field($formValidate, 'username') ?>

                    <?= $form->field($formValidate, 'password')->passwordInput() ?>

                    <?= $form->field($formValidate, 'confirm_password')->passwordInput() ?>
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
                    <?= Html::submitButton( '注册', ['class' => 'btn btn-success btn-block']) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <p class="text-center">
                <?= Html::a('已经注册?立即登录!', ['/site/login']) ?>
            </p>
        </div>
    </div>
<? else: ?>
    <?= Alert::widget([
        'options' => ['class' => 'alert-dismissible alert-success'],
        'body' => $registerHint
    ]) ?>

<? endif; ?>

