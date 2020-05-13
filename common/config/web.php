<?php

require __DIR__ . '/const.php';
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$logPrefix = function ($message) {
    $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
    $userID = $user ? $user->getId(false) : '-';
    return "[$userID]";
};
$config = [
    'id' => 'basic',
    'name' => '浩瀚支付',
    'runtimePath' => dirname(dirname(__DIR__)). '/runtime',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ZSM3MiT4l-ID7oxObcSJUfPmE_vxJK3H',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false, //这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.aliyun.com', //每种邮箱的host配置不一样
                'username' => 'xxx@aliyun.com',
                'password' => 'xxxx',
                'port' => '25',
                 'encryption' => 'tls',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['xxx@aliyun.com' => 'admin'],
            ],
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@runtime/logs/'. $main['id']. '/'.date('Ymd').'/app.warning.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@runtime/logs/'.$main['id'].'/'.date('Ymd').'/app.error.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/'. $main['id']. '/'.date('Ymd').'/app.info.log',
                    'logVars' => [],
                    'prefix' => $logPrefix,
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'enableStrictParsing' => true,
            'rules' => [
                '/' => 'site/index',
                'payment/notify/<sysOrderId:\w+>'=>'payment/notify',
                'site/email-activate/<code:\w+>' => 'site/email-activate',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>/<code:\w+>'=>'<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
            ],
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
