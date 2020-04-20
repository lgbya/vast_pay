<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannelAccount */

$this->title = Yii::t('app', '更改支付子账号: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '支付通道列表'), 'url' => Url::to(['/pay-channel/index'])];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '支付子账号列表: {pay_channel_name}', ['pay_channel_name'=>$model->payChannel->name]),
    'url' => ['index', 'pay_channel_id'=>$model->pay_channel_id],
];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '更改');
?>
<div class="pay-channel-account-create">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
