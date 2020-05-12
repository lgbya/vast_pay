<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PayChannel;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '支付通道列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="pay-channel-view">
            <p>
                <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('子账号列表', [
                    '/pay-channel-account/index',
                    'pay_channel_id'=>$model->id,
                    'pay_channel_name'=>$model->name,
                ], ['class' => 'btn btn-success']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'product_id',
                        'value' => function($model){
                            return $model->product->name;
                        }
                    ],
                    'name',
                    'code',
                    'profit_rate',
                    'cost_rate',
                    'weight',
                    'request_url:url',
                    [
                        'attribute'=>'status',
                        'value' => function($data){
                            return PayChannel::enumState('status', $data->status);
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

