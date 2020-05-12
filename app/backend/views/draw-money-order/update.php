<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DrawMoneyOrder */

$this->title = Yii::t('app', '修改提款订单: {name}', [
    'name' => $model->sys_order_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '提款订单列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sys_order_id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '更改订单');
?>
<div class="draw-money-order-update">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>