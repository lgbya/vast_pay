<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

<body class="login">
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['id'=>'login-form']); ?>
                <form id="reportForm"  method="post"  data-parsley-validate  >
                    <h1>浩瀚支付 管理后台</h1>
                    <div>
                        <input type="text" name="name" class="form-control" value="admin" placeholder="登录名称" required="required" />
                    </div>
                    <div>
                        <input type="password" name="password" class="form-control" value="123" placeholder="登录密码" required="required" />
                    </div>
                    <div>
                        <input type="text" name="captcha" class="form-control" placeholder="验证码" value="" required="required" style="float:left;width: 205px;" />
                        <?= Captcha::widget([
                                'name'=>'captchaimg',
                                'captchaAction'=>'login/captcha',
                                'imageOptions'=>[
                                        'id'=>'captchaimg',
                                        'title'=>'换一个',
                                        'alt'=>'换一个',
                                        'style'=>'cursor:pointer;margin-left:25px;'
                                ],
                                'template'=>'{image}'
                        ]);?>

                    </div>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-default submit">登录</button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <h1> Vast Pay </h1>
                            <p>©2020 All Rights Reserved. Vast Pay! is a PHP code. Privacy and Terms</p>
                        </div>
                    </div>
                </form>
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
<script >
    $('#reportForm').on('submit', function(){
        submitHref("#reportForm", "/manage/index/check_login", "/manage/index/index");
        event.preventDefault(); //阻止form表单默认提交
    })
</script>
</body>
</html>
