<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannel */

$this->title = '更新支付通道: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '支付通道列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="pay-channel-update">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
