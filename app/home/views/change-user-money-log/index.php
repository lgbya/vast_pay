<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\ChangeUserMoneyLog;
use common\helper\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChangeUserMoneyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '资金日志');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-user-money-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box-tools">
        <?= Html::a('导出订单excel', ['export',Yii::$app->request->queryParams], ['class' => 'btn btn-primary']) ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'change_money',
                'value' => function($data) {
                    return Helper::formatMoney($data->change_money);
                },
            ],
            [
                'attribute'=>'before_money',
                'value' => function($data) {
                    return Helper::formatMoney($data->before_money);
                },
            ],
            [
                'attribute'=>'after_money',
                'value' => function($data) {
                    return Helper::formatMoney($data->after_money);
                },
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
        ],
    ]); ?>
</div>
