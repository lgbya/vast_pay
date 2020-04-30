<?php

return [
    'menuList'=>[
        [
            'label'=>'商户信息',
            'content'=>[
                ['name'=>'基本信息','url'=>'/user/base-info'],
                ['name'=>'修改登录密码','url'=>'/user/save-login-password'],
            ]
        ],
        [
            'label'=>'订单管理',
            'content'=>[
                ['name'=>'支付订单列表','url'=>'/pay-order/index'],
                ['name'=>'资金日志','url'=>'/change-user-money-log/index'],
            ]
        ],
        [
            'label'=>'支付产品',
            'content'=>[
                ['name'=>'产品列表','url'=>'/product/index'],
            ]
        ]
    ],
];
