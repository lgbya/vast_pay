<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '提款申请');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draw-money-create">

    <h1><?= Html::encode($this->title) ?></h1>

        <div class="save-login-passwrd-form">
            <?php $form = ActiveForm::begin(); ?>
            <?php echo $form->errorSummary($model); ?>

            <?= $form->field($model, 'account_name')->textInput() ?>

            <?= $form->field($model, 'account_number')->textInput() ?>

            <?= $form->field($model, 'money')->label('金额(单位分)')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
</div>
