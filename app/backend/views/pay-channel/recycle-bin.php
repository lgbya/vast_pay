<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\PayChannel;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '支付通道回收站';
$this->params['breadcrumbs'][] = $this->title;
$omProduct = new Product();
?>
<?php Pjax::begin(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body table-responsive">

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
                            'attribute' => 'product_id',
                            'headerOptions' => ['width' => '100'],
                            'value' => 'product.name'
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
                            'attribute'=>'profit_rate',
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute'=>'cost_rate',
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
                            'template' => '{restore}',
                            'buttons' => [
                                'restore' => function ($url, $model) {
                                    return Html::a(
                                            '<i class="fa fa-window-restore"></i>',
                                            Url::to([
                                                '/pay-channel/restore',
                                                'id'=>$model->id,
                                            ]),
                                            ['title' => '还原']
                                        ) . " ";
                                },
                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>

