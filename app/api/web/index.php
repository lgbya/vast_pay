<?php

require __DIR__ . '/../../../common/config/init.php';
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../../common/config/bootstrap.php';

$main = require __DIR__ . '/../config/main.php';
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../../common/config/web.php',
    $main
);
(new yii\web\Application($config))->run();
