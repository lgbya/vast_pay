<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '产品列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <table  class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th>产品名称</th>
            <th>费率(单位:千分之一)</th>
        </tr>
        <? foreach ($lsProduct as $k => $v):?>

        <tr>
            <td><?= $v['name'];?></td>
            <td><?= $v['min_cost_rate'];?>~<?= $v['max_cost_rate'];?></td>
        </tr>
        <? endforeach; ?>
        </tbody>
    </table>

    <?php Pjax::end(); ?>

</div>
