<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */

$this->title = Yii::t('app', '支付产品分配: {name}', [
    'name' => $oqUser->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '用户列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $oqUser->username, 'url' => ['view', 'id' => $oqUser->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '支付产品分配');
?>
<div class="user-update">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>

        <?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
        <?php echo $form->errorSummary($model); ?>

        <div class="box-body">
            <div class="pay-product-allot-form">
               <? foreach ($oqlProduct as $k => $v):?>
                   <div class="form-group ">
                       <label class="control-label col-sm-3" ><?= $v->name;?>:</label>
                       <div class="col-sm-6">
                           <?= Select2::widget([
                               'name' => 'pay_channel_ids['.$v->id . '][]',
                               'value'=>$lsUserProduct[$v->id],
                               'data' =>  ArrayHelper::map($v->payChannels,'id', 'name'),
                               'options' => ['multiple' => true,'placeholder' => '请选择 ...'],
                               'pluginOptions' => ['allowClear'=>true],
                           ]);?>
                       </div>
                   </div>
               <? endforeach;?>
            </div>
        </div>
        <div class="box-footer text-center">
            <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-primary']) ?>
            <span class="btn btn-white" onclick="history.go(-1)">返回</span>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>