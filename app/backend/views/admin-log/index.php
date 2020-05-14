<?php

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '用户操作日志');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'admin_name',
                        'admin_id',
                        'admin_ip',
                        'route',
                        'admin_agent',
                        [
                            'attribute' => 'created_at',
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
