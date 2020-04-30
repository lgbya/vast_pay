<?php

return [
    'mdm.admin.configs' => [
        'userTable' => '{{%admin}}',
    ],
    'pagination'=>[
        'pageSize' => 20,
    ],
    'filterDateRangeOptions'=>[
        'pluginOptions'=>[
            'autoUpdateOnInit'=>false,
            'showWeekNumbers' => false,
            'useWithAddon'=>true,
            'convertFormat'=>true,
            'timePicker'=>false,
            'locale'=>[
                'format' => 'YYYY-MM-DD',
                'separator'=>' 到 ',
                'applyLabel' => '确定',
                'cancelLabel' => '取消',
                'fromLabel' => '起始时间',
                'toLabel' => '结束时间',
                'daysOfWeek'=>false,
            ],
            'opens'=>'left',
        ],
        'options' => [
            'placeholder' => '请选择...',
        ],
    ],
];
