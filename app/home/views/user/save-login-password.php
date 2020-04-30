<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '修改登录密码: {name}', [
    'name' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="save-login-passwrd-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($formValidate, 'password')->textInput(['maxlength' => true]) ?>

        <?= $form->field($formValidate, 'confirm_password')->textInput(['maxlength' => true]) ?>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
