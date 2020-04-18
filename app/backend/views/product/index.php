<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use \common\models\Product;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增产品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'attribute'=>'status',
                'value' => function($data){
                    return Product::enumState('status', $data->status);
                },
                'filter' => Product::enumState('status'),
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
