<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\ChangeUserMoneyLog;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChangeUserMoneyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '资金日志');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-user-money-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'change_money',
            'before_money',
            'after_money',
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

    <?php Pjax::end(); ?>

</div>
