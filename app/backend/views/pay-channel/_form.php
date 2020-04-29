<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\PayChannel;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannel */
/* @var $form yii\widgets\ActiveForm */
$omProduct = new Product();
?>

<?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
<?php echo $form->errorSummary($model); ?>

<div class="box-body">
    <div class="pay-channel-form">

        <?= $form->field($model, 'product_id')->dropDownList(
            ArrayHelper::merge([''=>'请选择'], $omProduct->getIdToNameList(Product::DEL_STATE_NO))
        ) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'profit_rate')->Input('number') ?>

        <?= $form->field($model, 'cost_rate')->Input('number') ?>

        <?= $form->field($model, 'weight')->Input('number') ?>

        <?= $form->field($model, 'request_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(
                PayChannel::enumState('status')
        ) ?>
    </div>
</div>

<div class="box-footer text-center">
    <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-primary']) ?>
    <span class="btn btn-white" onclick="history.go(-1)">返回</span>
</div>

<?php ActiveForm::end(); ?>

