<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helper\Helper;
use common\models\DrawMoneyOrder;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '提款申请:{sys_order_id}',[
    'sys_order_id' => $model->sys_order_id,
]);
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
