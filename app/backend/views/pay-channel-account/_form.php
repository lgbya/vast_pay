<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\PayChannel;
use common\models\PayChannelAccount;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannelAccount */
/* @var $form yii\widgets\ActiveForm */
$omPayChannel = new PayChannel();
?>
<?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
<?php echo $form->errorSummary($model); ?>
<div class="box-body">
    <div class="pay-channel-account-form">

        <?= $form->field($model, 'account')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'appid')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'md5_key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'private_key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'public_key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'weight')->Input('number') ?>

        <?= $form->field($model, 'status')->dropDownList(
            PayChannelAccount::enumState('status')
        ) ?>

    </div>
</div>

<div class="box-footer text-center">
    <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-primary']) ?>
    <span class="btn btn-white" onclick="history.go(-1)">返回</span>
</div>
<?php ActiveForm::end(); ?>

