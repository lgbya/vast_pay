<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChangeUserMoneyLog */

$this->title = Yii::t('app', 'Create Change User Money Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Change User Money Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-user-money-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
