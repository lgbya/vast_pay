<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '验证支付登录密码');
$this->params['breadcrumbs'][] = Yii::t('app', '验证支付登录密码');
?>
<div class="user-update">
        <div class="save-login-passwrd-form">
            <?php $form = ActiveForm::begin(['layout'=> 'horizontal']); ?>
            <?php echo $form->errorSummary($formValidate); ?>

            <?= $form->field($formValidate, 'password')->passwordInput() ?>
            <div class="box-footer text-center">
                <?= Html::submitButton(Yii::t('app', '验证'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

</div>
