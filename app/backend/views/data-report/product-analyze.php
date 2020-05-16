<?php
use Hisune\EchartsPHP\ECharts;
$this->title = Yii::t('app', '产品分析');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>

            <?php
            $chart = new ECharts();
            $options = [
                'title' => [
                    'text' => '产品总统计',
                ],
                'tooltip' => ['show' => true],
                'legend'  => ['data' => ['原支付金额', '用户获取金额', '利润', '成本']],
                'grid' => [
                    'left' => '3%',
                    'right' => '4%',
                    'bottom' => '3%',
                    'containLabel' => true,
                ],
                'xAxis'   => [
                    [
                        'type' => 'category',
                        'data' => $lsProductMoneySum['product_name']??'',
                    ]
                ],
                'yAxis'   => [
                    ['type' => 'value']
                ],
                'series'  => [
                    [
                        'name' => '原支付金额',
                        'type' => 'bar',
                        'data' => $lsProductMoneySum['pay_money']??0,
                    ],
                    [
                        'name' => '用户获取金额',
                        'type' => 'bar',
                        'data' => $lsProductMoneySum['user_money']??0,
                    ],
                    [
                        'name' => '成本',
                        'type' => 'bar',
                        'data' => $lsProductMoneySum['cost_money']??0,
                    ],
                    [
                        'name' => '利润',
                        'type' => 'bar',
                        'data' => $lsProductMoneySum['profit_money']??0,
                    ],
                ]
            ];
            $chart->setOption($options);
            echo $chart->render('simple-custom-id');
            $chart = new ECharts();
            $options = [
                'title' => [
                    'text' => '30天金额折线',
                ],
                'tooltip' => [
                    'trigger' => 'axis',
                ],
                'legend' => [
                    'data' => ['原支付金额', '用户获取金额', '利润', '成本']
                ],
                'grid' => [
                    'left' => '3%',
                    'right' => '4%',
                    'bottom' => '3%',
                    'containLabel' => true,
                ],
                'toolbox'   =>  [
                    'feature' => [
                        'saveAsImage' => [],
                    ],
                ],
                'xAxis' => [
                    'type' => 'category',
                    'boundaryGap' => false,
                    'data' => isset($lDate)?array_values($lDate):[],
                ],
                'yAxis' => [
                    'type' => 'value'
                ],
                'series' => [
                    [
                        'name' =>'原支付金额',
                        'type' => 'line',
                        'stack'=> '总量',
                        'data' => isset($lsEverydayMoneySum['pay_money'])?array_values($lsEverydayMoneySum['pay_money']):[],
                    ],
                    [
                        'name' =>'用户获取金额',
                        'type' => 'line',
                        'stack'=> '总量',
                        'data' => isset($lsEverydayMoneySum['user_money'])?array_values($lsEverydayMoneySum['user_money']):[],
                    ],
                    [
                        'name' =>'利润',
                        'type' => 'line',
                        'stack'=> '总量',
                        'data' => isset($lsEverydayMoneySum['profit_money'])?array_values($lsEverydayMoneySum['profit_money']):[],
                    ],
                    [
                        'name' =>'成本',
                        'type' => 'line',
                        'stack'=> '总量',
                        'data' => isset($lsEverydayMoneySum['cost_money'])?array_values($lsEverydayMoneySum['cost_money']):[],
                    ],
                ]
            ];
            $chart->setOption($options);
            echo $chart->render('simple-custom-id2');
        ?>
        </div>
    </div>
</div>
