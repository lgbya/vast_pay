<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PayOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'pay_channel_id') ?>

    <?= $form->field($model, 'channel_code') ?>

    <?= $form->field($model, 'channel_account') ?>

    <?php // echo $form->field($model, 'channel_account_extra') ?>

    <?php // echo $form->field($model, 'md5_key') ?>

    <?php // echo $form->field($model, 'public_key') ?>

    <?php // echo $form->field($model, 'private_key') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'user_account') ?>

    <?php // echo $form->field($model, 'sys_order_id') ?>

    <?php // echo $form->field($model, 'user_order_id') ?>

    <?php // echo $form->field($model, 'supplier_order_id') ?>

    <?php // echo $form->field($model, 'pay_money') ?>

    <?php // echo $form->field($model, 'access_rate') ?>

    <?php // echo $form->field($model, 'cost_rate') ?>

    <?php // echo $form->field($model, 'access_money') ?>

    <?php // echo $form->field($model, 'cost_money') ?>

    <?php // echo $form->field($model, 'profit_money') ?>

    <?php // echo $form->field($model, 'inform_num') ?>

    <?php // echo $form->field($model, 'user_notify_url') ?>

    <?php // echo $form->field($model, 'user_callback_url') ?>

    <?php // echo $form->field($model, 'user_extra_field') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'notify_time') ?>

    <?php // echo $form->field($model, 'success_time') ?>

    <?php // echo $form->field($model, 'complete_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
