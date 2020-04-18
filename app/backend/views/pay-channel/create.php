<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannel */

$this->title = '新增支付通道';
$this->params['breadcrumbs'][] = ['label' => '支付通道列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-channel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
