<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PayOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'pay_channel_id')->textInput() ?>

    <?= $form->field($model, 'channel_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel_account_extra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'md5_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'public_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'private_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'user_account')->textInput() ?>

    <?= $form->field($model, 'sys_order_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_order_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplier_order_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_money')->textInput() ?>

    <?= $form->field($model, 'access_rate')->textInput() ?>

    <?= $form->field($model, 'cost_rate')->textInput() ?>

    <?= $form->field($model, 'access_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profit_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inform_num')->textInput() ?>

    <?= $form->field($model, 'user_notify_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_callback_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_extra_field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'notify_time')->textInput() ?>

    <?= $form->field($model, 'success_time')->textInput() ?>

    <?= $form->field($model, 'complete_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
