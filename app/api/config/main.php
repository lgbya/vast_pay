<?php
return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/api/'.date('Ym').'/app.error.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/api/'.date('Ym').'/app.info.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],
            ],
        ],
    ]
];
