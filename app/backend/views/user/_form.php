<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
<?php echo $form->errorSummary($model); ?>

<div class="box-body">
    <div class="user-form">

        <?= $form->field($model, 'username')->textInput(['maxlength' => true,'readonly'=>'true']) ?>

        <?= $form->field($model, 'status')->dropDownList(User::enumState('status')) ?>

    </div>
</div>
<div class="box-footer text-center">
    <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-primary']) ?>
    <span class="btn btn-white" onclick="history.go(-1)">返回</span>
</div>
<?php ActiveForm::end(); ?>
