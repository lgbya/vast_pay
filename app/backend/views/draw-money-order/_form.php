<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\DrawMoneyOrder;
use common\helper\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\DrawMoneyOrder */
/* @var $form yii\widgets\ActiveForm */
$lsStatus = DrawMoneyOrder::enumState('status');
unset($lsStatus[DrawMoneyOrder::STATUS_UNTREATED]);
$lsStatus[''] = '请设置';
ksort($lsStatus);
?>
<?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
<?php echo $form->errorSummary($model); ?>
<div class="box-body">
    <div class="draw-money-order-form">


        <?= $form->field($model, 'user_id')->textInput(['disabled'=>true]) ?>

        <?= $form->field($model, 'sys_order_id')->textInput(['disabled'=>true]) ?>

        <?= $form->field($model, 'account_name')->textInput(['disabled'=>true]) ?>

        <?= $form->field($model, 'account_number')->textInput(['disabled'=>true]) ?>

        <?= $form->field($model, 'money')->textInput(['value'=>Helper::formatMoney($model->money),'disabled'=>true]) ?>

        <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList($lsStatus) ?>

    </div>
</div>
<div class="box-footer text-center">
    <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-primary']) ?>
    <span class="btn btn-white" onclick="history.go(-1)">返回</span>
</div>
<?php ActiveForm::end(); ?>


