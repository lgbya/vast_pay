<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PayOrder;
use kartik\dialog\Dialog;
/* @var $this yii\web\View */
/* @var $model common\models\PayOrder */

$this->title = Yii::t('app', '订单: {sys_order_id}', [
        'sys_order_id' => $model->sys_order_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '支付订单列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
echo Dialog::widget();
?>


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="pay-order-view">
            <p>
                <? if($model->status !== PayOrder::STATUS_CORRECTION):?>
                <?= Html::a(Yii::t('app', '校正'), ['correction', 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => Yii::t('app', '您确定要校正该订单吗?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <? endif; ?>

                <? if($model->status !== PayOrder::STATUS_TURN_DOWN):?>
                <?= Html::a(Yii::t('app', '驳回'), ['turn-down', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', '您确定要驳回该订单吗?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <? endif; ?>

            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'sys_order_id',
                    'user_order_id',
                    'supplier_order_id',
                    'user_id',
                    'user_account',
                    'pay_money',
                    'profit_rate',
                    'cost_rate',
                    'user_money',
                    'cost_money',
                    'profit_money',
                    'product.name',
                    'payChannel.name',
                    'pay_channel_code',
                    'pay_channel_account',
                    'pay_channel_account_extra',

                    'inform_num',
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
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                    [
                        'attribute' => 'notify_time',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                    [
                        'attribute' => 'success_time',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                    [
                        'attribute' => 'query_time',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>
