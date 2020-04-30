<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\PayOrder;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PayOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '支付订单列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-order-index" >
    <h1 ><?= $this->title; ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'sys_order_id',
                'contentOptions' => ['style'=>'max-width: 100px; overflow: auto; word-wrap: break-word;'],
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute'=>'user_order_id',
                'contentOptions' => ['style'=>'max-width: 100px; overflow: auto; word-wrap: break-word;'],
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
                'attribute'=>'pay_money',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute'=>'user_money',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute'=>'cost_money',
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
                'attribute' => 'notify_time',
                'label'=>'支付时间',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'filterType' =>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
            ],
            [
                'header' => "操作",
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
