<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\bootstrap\ActiveForm;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>

    <title>浩瀚支付</title>

    <!-- Bootstrap -->
    <link href="/style/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- PNotify -->
    <link href="/style/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="/style/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="/style/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/style/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login" >
<?php $this->beginBody() ?>

<div  class="container">
    <div class="login_wrapper" style="max-width: 533px;right: 1.15%;margin-top:8.6%">
        <div class="animate form login_form" style="background-color: #fff;border-radius:16px">
            <section class="login_content">
                <?php
                $form = ActiveForm::begin([
                    'id'=>'contact-form',
                    'layout' => 'horizontal',
                    'action'=>[Url::to('/login/login')],
                    'fieldConfig' => [
                        'labelOptions' => ['class' => 'col-lg-2 control-label'],
                        'template' => '{label}<div class="col-lg-9" >{input}</div> <div class="col-lg-12" >{error}</div>',
                    ],

                ]);
                ?>
                <h1>浩瀚支付 管理后台</h1>

                <?= $form->field($objectForm, 'login_name')->textInput() ?>

                <?= $form->field($objectForm, 'login_password')->passwordInput() ?>

                <?= $form->field($objectForm, 'verify_code')->widget(Captcha::className(), [
                    'captchaAction'=>Url::to('site/captcha'),
                    'imageOptions'=>[
                        'id'=>'captcha-img',
                        'title'=>'换一个',
                        'alt'=>'换一个',
                    ],
                    'template' => '<div class="row"><div class="col-lg-8" >{input}</div><div class="col-lg-4 " ">{image}</div></div>',
                ]) ?>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-12">
                        <?= Html::submitButton('登录/Login ☜(ˆ▽ˆ)', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="separator">
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <p>©2020 All Rights Reserved. 【Vast Pay】 is a PHP code. Privacy and Terms</p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

                <!--                </form>-->
            </section>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="/style/vendors/jquery/dist/jquery.min.js"></script>

<!-- Parsley -->
<script src="/style/vendors/parsleyjs/dist/parsley.min.js"></script>

<!-- Bootstrap -->
<script src="/style/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- PNotify -->
<script src="/style/vendors/pnotify/dist/pnotify.js"></script>
<script src="/style/vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="/style/vendors/pnotify/dist/pnotify.nonblock.js"></script>
<script src="/style/js/common.js"></script>
<script src="/style/js/captcha.js"></script>
<script>
    $(function(){
        $(document).on('beforeSubmit', 'form#contact-form', function () {
            return submitHref($(this));
        });
    });



</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
