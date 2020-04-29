<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PayChannelAccount;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PayChannelAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '支付子账号列表:   {pay_channel_name}', [
        'pay_channel_name'=>$payChannelName,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '支付通道列表'), 'url' => Url::to(['/pay-channel/index'])];
$this->params['breadcrumbs'][] = $this->title;

//echo "<pre>";var_dump($this->params['breadcrumbs']);exit;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body">
                <div class="box-tools">
                    <?= Html::a(Yii::t('app', '新增支付子账号'),
                        Url::to(['create', 'pay_channel_id'=>$payChannelId]),
                        ['class' => 'btn btn-primary'])
                    ?>
                </div>

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'account',
                        'weight',
                        [
                            'attribute'=>'status',
                            'value' => function($data){
                                return PayChannelAccount::enumState('status', $data->status);
                            },
                            'filter' => PayChannelAccount::enumState('status'),
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

            </div>
        </div>
    </div>
</div>

