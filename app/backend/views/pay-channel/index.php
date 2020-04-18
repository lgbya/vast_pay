<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\PayChannel;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '支付通道列表';
$this->params['breadcrumbs'][] = $this->title;
$omProduct = new Product();
$lProductIdToName = $omProduct->getIdToNameList();
?>
<div class="pay-channel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增支付通道', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute'=>'product_id',
                'headerOptions' => ['width' => '100'],
                'value' => function($data) use ($lProductIdToName){
                    return $lProductIdToName[$data->product_id];
                },
                'filter' => $lProductIdToName,
            ],
            [
                'attribute'=>'name',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute'=>'code',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute'=>'rate',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute'=>'cost',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute'=>'weight',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute'=>'status',
                'value' => function($data){
                    return PayChannel::enumState('status', $data->status);
                },
                'filter' => PayChannel::enumState('status'),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'filterType' =>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'filterType' =>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
            ],
            [
                'header' => "操作",
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
