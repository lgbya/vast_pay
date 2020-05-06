<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '修改支付密码: {name}', [
    'name' => $model->username,
]);
$this->params['breadcrumbs'][] = Yii::t('app', '商户信息');
$this->params['breadcrumbs'][] = Yii::t('app', '修改支付密码');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <? if( $successHint === false ):?>

        <div class="save-pay-passwrd-form">
            <?php $form = ActiveForm::begin(); ?>
            <?php echo $form->errorSummary($formValidate); ?>

            <?= $form->field($formValidate, 'password')->passwordInput() ?>

            <?= $form->field($formValidate, 'confirm_password')->passwordInput() ?>


            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    <? else: ?>
        <div class="jumbotron" style="background: #f5f5f5">
            <h2 style="color: #0f7b9f"><?= $successHint; ?></h2>
            <p>
            <div class=" text-center" >
                <a href="<?= Url::to('/user/save-pay-password')?>"><span class="btn btn-lg btn-primary" style="font-size: 16px">返回</span></a>
            </div>
            </p>
        </div>
    <? endif; ?>
</div>
