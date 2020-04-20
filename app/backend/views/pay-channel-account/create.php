<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannelAccount */

$this->title = Yii::t('app', '新增支付子账号');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '支付子账号列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
