<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PayOrder;

/* @var $this yii\web\View */
/* @var $model common\models\PayOrder */

$this->title = Yii::t('app', '订单: {sys_order_id}', [
    'sys_order_id' => $model->sys_order_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '支付订单列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pay-order-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'sys_order_id',
        'user_order_id',
        'product.name',
        'user_account',
        'pay_money',
        'user_money',
        'cost_money',
        [
            'attribute' =>  'profit_rate',
            'label' => '成本费率',
        ],
        'user_notify_url:url',
        'user_callback_url:url',
        'user_extra_field',
        [
            'attribute' =>  'status',
            'value'=>function($data){
                return PayOrder::enumState('status', $data->status);
            },
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
            'attribute' => 'notify_time',
            'label' => '支付时间',
            'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
    ],
]) ?>
</div>
