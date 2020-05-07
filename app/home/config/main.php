<?php
$params = require __DIR__ . '/params.php';


return [
    'id' => 'home',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'home\controllers',
    'as access' => [
        'class' => 'common\components\AccessControl',
        'allowActions' => [
            'site/*',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/home/'.date('Ym').'/app.error.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/home/'.date('Ym').'/app.info.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],
            ],
        ],
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],

//        'user' => [
//            'class' => 'dektrium\user\Module',
//            'confirmWithin' => 21600,
//            'cost' => 12,
//            'admins' => ['admin']
//        ],
    ],
    'params' => $params,

];
