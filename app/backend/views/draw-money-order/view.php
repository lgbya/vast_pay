<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\DrawMoneyOrder;

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
                    'id',
                    'user_id',
                    'sys_order_id',
                    'account_name',
                    'account_number',
                    'receipt_number',
                    'money',
                    'remark',
                    'status',
                    'created_at',
                    'updated_at',
                    'success_at',
                ],
            ]) ?>
        </div>
    </div>
</div>



