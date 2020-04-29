<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\ChangeUserMoneyLog;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChangeUserMoneyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '用户资金日志');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body">
                <div class="box-tools">
                </div>

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
//                        'id',
                        'user_id',
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

<?php Pjax::end(); ?>
