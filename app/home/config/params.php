<?php

return [
    'menuList'=>[
        [
            'label'=>'商户信息',
            'content'=>[
                ['name'=>'基本信息','url'=>'/user/base-info'],
                ['name'=>'交易信息','url'=>'/user/pay-info'],
                ['name'=>'提款申请','url'=>'/draw-money-order/create'],
                ['name'=>'修改登录密码','url'=>'/user/save-login-password'],
                ['name'=>'修改支付密码','url'=>'/user/save-pay-password'],
            ],
        ],

        [
            'label'=>'订单管理',
            'content'=>[
                ['name'=>'支付订单列表','url'=>'/pay-order/index'],
                ['name'=>'提款订单列表','url'=>'/draw-money-order/index'],
                ['name'=>'资金日志','url'=>'/change-user-money-log/index'],
            ],
        ],

        [
            'label'=>'支付产品',
            'content'=>[
                ['name'=>'产品列表','url'=>'/product/index'],
            ],
        ],

        [
            'label'=>'数据分析',
            'content'=>[
                ['name'=>'产品报表','url'=>'/data-report/product-analyze'],
            ],
        ],
    ],
];
