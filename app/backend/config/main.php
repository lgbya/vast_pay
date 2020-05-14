<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
        ],

    ],
    'aliases' => [
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'mainLayout' => '@backend/views/layouts/main.php',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
        ],
        'treemanager' => [
            'class' => '\kartik\tree\Module',
        ]

    ],
    'on beforeRequest' => function($event) {
        common\components\AdminLogControl::write($event);
    },
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/captcha',
        ]
    ],
];
