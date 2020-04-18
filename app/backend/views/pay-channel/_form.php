<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\PayChannel;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $model common\models\PayChannel */
/* @var $form yii\widgets\ActiveForm */
$omProduct = new Product();
?>

<div class="pay-channel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList(
        ArrayHelper::merge([''=>'请选择'],$omProduct->getIdToNameList())
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rate')->Input('number') ?>

    <?= $form->field($model, 'cost')->Input('number') ?>

    <?= $form->field($model, 'weight')->Input('number') ?>

    <?= $form->field($model, 'request_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
            PayChannel::enumState('status')
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
