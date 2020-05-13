<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\DrawMoneyOrder;
use common\helper\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\DrawMoneyOrder */

$this->title = Yii::t('app', '提款订单:{sys_order_id}', [
        'sys_order_id' => $model->sys_order_id
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '提款订单列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="draw-money-order-view">
            <p>
                <? if($model->status !== DrawMoneyOrder::STATUS_SEND_BACK):?>
                    <?= Html::a(Yii::t('app', '更改提款订单'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <? endif; ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'user_id',
                    'sys_order_id',
                    'account_name',
                    'account_number',
                    [
                        'attribute' => 'receipt_number',
                        'value' => function($data) {
                            return $data->receipt_number == '' ? null :$data->receipt_number;
                        },
                    ],
                    [
                        'attribute'=>'money',
                        'value' => function($data) {
                            return Helper::formatMoney($data->money);
                        },
                    ],
                    [
                        'attribute' => 'remark',
                        'value' => function($data) {
                            return $data->remark == '' ? null :$data->remark;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($data) {
                            return DrawMoneyOrder::enumState('status', $data->status) ;
                        },
                    ],
                    [
                        'attribute' => 'success_at',
                        'value' => function($data) {
                            return $data->success_at == 0 ? null :date('Y-m-d H:i:s', $data->success_at);
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
                ],
            ]) ?>
        </div>
    </div>
</div>



