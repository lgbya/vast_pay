<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helper\Helper;
use common\models\ChangeUserMoneyLog;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChangeUserMoneyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '用户资金日志');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body">
                <div class="box-tools">
                    <?= Html::a('导出订单excel', ['export',Yii::$app->request->queryParams], ['class' => 'btn btn-primary']) ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
//                        'id',
                        'user_id',
                        [
                            'attribute'=>'change_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->change_money);
                            },
                            'filter' => ChangeUserMoneyLog::enumState('type'),
                        ],
                        [
                            'attribute'=>'before_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->before_money);
                            },
                            'filter' => ChangeUserMoneyLog::enumState('type'),
                        ],
                        [
                            'attribute'=>'after_money',
                            'value' => function($data) {
                                return Helper::formatMoney($data->after_money);
                            },
                            'filter' => ChangeUserMoneyLog::enumState('type'),
                        ],
                        [
                            'attribute'=>'type',
                            'value' => function($data){
                                return ChangeUserMoneyLog::enumState('type', $data->type);
                            },
                            'filter' => ChangeUserMoneyLog::enumState('type'),
                        ],
                        'extra',
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
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>

