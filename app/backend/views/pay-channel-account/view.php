<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PayChannelAccount;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannelAccount */

$this->title = $model->account;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '支付通道列表'), 'url' => Url::to(['/pay-channel/index'])];
$this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', '{pay_channel_name} 子账号列表', ['pay_channel_name'=>$model->payChannel->name]),
        'url' => ['index', 'pay_channel_id'=>$model->pay_channel_id],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">支付子账号列表:<?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="pay-channel-account-view">
            <p>
                <?= Html::a(Yii::t('app', '更新'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'pay_channel_id',
                        'value' => function($model){
                            return $model->payChannel->name;
                        }
                    ],
                    'account',
                    'appid',
                    'md5_key',
                    'private_key',
                    'public_key',
                    'weight',
                    [
                        'attribute'=>'status',
                        'value' => function($data){
                            return PayChannelAccount::enumState('status', $data->status);
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
