<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '用户列表');
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
                        [
                            'attribute'=>'id',
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute'=>'username',
                            'headerOptions' => ['width' => '150'],
                        ],
                        [
                            'attribute'=>'email',
                            'headerOptions' => ['width' => '200'],
                        ],
                        [
                            'attribute'=>'account',
                            'headerOptions' => ['width' => '100'],
                        ],
                        [
                            'attribute'=>'money',
                            'headerOptions' => ['width' => '100'],
                            'value' => function($data){
                                return  sprintf('%.2f',$data->money / 100);
                            },
                        ],
                        [
                            'attribute'=>'status',
                            'value' => function($data){
                                return User::enumState('status', $data->status);
                            },
                            'filter' => User::enumState('status'),
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
                            'template' => '{pay_product_list} {view} {update} {banned} {refresh}',
                            'buttons' => [
                                'pay_product_list' => function($url, $model){
                                    return Html::a(
                                            '<i class="fa fa-product-hunt"  aria-hidden="true"></i>',
                                            Url::to(['/user/pay-product-allot', 'id'=>$model->id,]),
                                            ['title' => '支付产品',]
                                        );
                                },
                                'banned' => function ($url, $model) {
                                    if ($model->status == User::STATUS_INACTIVE){
                                        return Html::a(
                                                '<i class="fa fa-refresh"  aria-hidden="true"></i>',
                                                Url::to(['/user/lift-a-ban', 'id'=>$model->id,]),
                                                [
                                                    'title' => '解禁账户',
                                                    'data' => [
                                                        'confirm' => '您确定要解封该用户吗?',
                                                        'method' => 'post'
                                                    ],
                                                ]
                                            );
                                    }
                                    return '';
                                },
                                'refresh' => function ($url, $model) {
                                    if ($model->status == User::STATUS_ACTIVE){
                                        return Html::a(
                                                '<i class="fa fa-ban" style="color:red" aria-hidden="true"></i>',
                                                Url::to(['/user/banned', 'id'=>$model->id,]),
                                                [
                                                    'title' => '封禁账户',
                                                    'data' => [
                                                        'confirm' => '您确定要封禁该用户吗?',
                                                        'method' => 'post'
                                                    ],
                                                ]
                                            );
                                    }
                                    return '';
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

