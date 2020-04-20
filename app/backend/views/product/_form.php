<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
<?php echo $form->errorSummary($model); ?>

<div class="box-body">
    <div class="product-form">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(Product::enumState('status')) ?>
    </div>
</div>
<div class="box-footer text-center">
    <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-primary']) ?>
    <span class="btn btn-white" onclick="history.go(-1)">返回</span>
</div>
<?php ActiveForm::end(); ?>
