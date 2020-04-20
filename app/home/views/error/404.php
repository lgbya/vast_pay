<?php

/* @var $code string */
/* @var $title string */
/* @var $content string */
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/style/images/favicon.ico" type="image/ico" />


    <title>浩瀚支付 </title>

    <!-- Bootstrap -->
    <link href="/style/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/style/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/style/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/style/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
            <div class="col-middle">
                <div class="text-center text-center">
                    <h1 class="error-number"><?= $code ?></h1>
                    <h2><?= $title  ?></h2>
                    <p><?= $content ?></p>
                    <p><a href="<?= Url::home()?>">点击这里?</a></p>

                    <div class="mid_center">
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>

<!-- jQuery -->
<script src="/style/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/style/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="/style/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/style/vendors/nprogress/nprogress.js"></script>

<!-- Custom Theme Scripts -->
<script src="/style/build/js/custom.min.js"></script>
</body>
</html>
