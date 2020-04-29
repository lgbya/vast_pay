<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayOrder */

$this->title = Yii::t('app', 'Create Pay Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
