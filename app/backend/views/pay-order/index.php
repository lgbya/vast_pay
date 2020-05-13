<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\PayOrder;
use common\helper\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PayOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '支付订单列表');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>

            <div class="login-info-box">
                <div class="login-info-box1">
                    <h4>
                        <span style="padding-left: 10px"><b>原金额总额</b>：<?= $payMoneyCount; ?></span>
                        <span style="color:red;"><b>-</b></span>
                        <span style="padding-left: 10px"><b>用户获取总额</b>：<?= $userMoneyCount; ?></span>
                        <span style="color:red;"><b>-</b></span>
                        <span style="padding-left: 10px"><b>成本总额</b>：<?= $costMoneyCount; ?></span>
                        <span style="color:red;"><b>=</b></span>
                        <span style="padding-left: 10px"><b>利润总额</b>：<?= $profitMoneyCount; ?></span>
                    </h4>

                </div>
            </div>

            <div class="box-body ">
                <div class="box-tools">
                    <?= Html::a('导出订单excel', ['export',Yii::$app->request->queryParams], ['class' => 'btn btn-primary']) ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,

                    'columns' => [
                        [
                            'attribute'=>'sys_order_id',
                            'contentOptions' => ['style'=>'max-width: 115px; overflow: auto; word-wrap: break-word;'],
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'user_order_id',
                            'contentOptions' => ['style'=>'max-width: 115px; overflow: auto; word-wrap: break-word;'],
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'supplier_order_id',
                            'contentOptions' => ['style'=>'max-width: 115px; overflow: auto; word-wrap: break-word;'],
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'user_id',
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'product_id',
                            'value' => function($data) use ($lProductIdToName){
                                return $lProductIdToName[$data->product_id];
                            },
                            'filter' => $lProductIdToName,
                            'headerOptions' => ['width' => '100'],

                        ],
                        [
                            'attribute'=>'pay_channel_id',
                            'value' => function($data) use ($lChannelIdToName){
                                return $lChannelIdToName[$data->pay_channel_id];
                            },
                            'filter' => $lChannelIdToName,
                            'headerOptions' => ['width' => '100'],

                        ],
                        [
                            'attribute'=>'pay_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->pay_money);
                            },
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'user_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->user_money);
                            },
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'cost_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->cost_money);
                            },
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'profit_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->profit_money);
                            },
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute'=>'status',
                            'value' => function($data){
                                return PayOrder::enumState('status', $data->status);
                            },
                            'filter' => PayOrder::enumState('status'),
                            'headerOptions' => ['width' => '80'],
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                            'filterType' =>GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                            'filterType' =>GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
                        ],
//                        [
//                            'attribute' => 'notify_time',
//                            'format' => ['date', 'php:Y-m-d H:i:s'],
//                            'filterType' =>GridView::FILTER_DATE_RANGE,
//                            'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
//                        ],
//                        [
//                            'attribute' => 'success_time',
//                            'format' => ['date', 'php:Y-m-d H:i:s'],
//                            'filterType' =>GridView::FILTER_DATE_RANGE,
//                            'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
//                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {correction} {turn_down}',
                            'buttons' => [
                                'correction' => function ($url, $model) {
                                    if ($model->status != PayOrder::STATUS_CORRECTION){
                                        return Html::a(
                                                '<i class="fa fa-check" aria-hidden="true"></i>',
                                                Url::to([
                                                    '/pay-order/correction',
                                                    'id'=>$model->id,
                                                ]),
                                                [
                                                    'title' => '校正',
                                                    'data' => [
                                                        'confirm' => '您确定要校正该订单吗?',
                                                        'method' => 'post'
                                                    ],
                                                ]
                                            ) ;
                                    }
                                    return '';
                                },
                                'turn_down' => function ($url, $model) {
                                     if ($model->status != PayOrder::STATUS_TURN_DOWN){
                                         return Html::a(
                                                 '<i class="fa fa-close" aria-hidden="true"></i>',
                                                 Url::to([
                                                     '/pay-order/turn-down',
                                                     'id'=>$model->id,
                                                 ]),
                                                 [
                                                     'title' => '驳回',
                                                     'data' => [
                                                         'confirm' => '您确定要驳回该订单吗?',
                                                         'method' => 'post'
                                                     ],
                                                 ]
                                             ) ;
                                     }
                                     return '';
                                },
                            ],
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>


