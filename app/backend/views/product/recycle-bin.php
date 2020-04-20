<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use \common\models\Product;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品回收站';
$this->params['breadcrumbs'][] = $this->title;
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
                            'template' => '{restore}',
                            'buttons' => [
                                'restore' => function ($url, $model) {
                                    return Html::a(
                                            '<i class="fa fa-window-restore"></i>',
                                            Url::to([
                                                '/product/restore',
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


