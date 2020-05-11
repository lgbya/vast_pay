<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DrawMoneyOrder */

$this->title = Yii::t('app', 'Create Draw Money Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Draw Money Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draw-money-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
