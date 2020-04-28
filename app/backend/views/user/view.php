<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use yii\web\YiiAsset;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '用户列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
echo Dialog::widget();
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="user-view">
            <p>
                <?= Html::a(Yii::t('app', '更改'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php
                    switch ($model->status){
                        case User::STATUS_ACTIVE:
                            echo Html::a(Yii::t('app', '封禁'), ['banned', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', '你确定要封禁此用户吗?'),
                                    'method' => 'post',
                                ],
                            ]);
                            break;
                        case User::STATUS_INACTIVE:
                            echo Html::a(Yii::t('app', '解禁'), ['lift-a-ban', 'id' => $model->id], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => Yii::t('app', '你确定要解禁此用户吗?'),
                                    'method' => 'post',
                                ],
                            ]);
                            break;
                        default:
                            echo '';
                            break;
                    }
                ?>
                <?= Html::a(Yii::t('app', '分配支付产品'), ['pay-product-allot', 'id' => $model->id], ['class' => 'btn btn-info']) ?>

            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'email:email',
                    'account',
                    [
                        'attribute'=>'money',
                        'value' => function($data){
                            return  sprintf('%.2f',$data->money / 100);
                        },
                    ],
                    [
                        'attribute'=>'status',
                        'value' => function($data){
                            return User::enumState('status', $data->status);
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                ],
            ]) ?>
            <h3 class="box-title">支付产品分配列表</h3>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'payChannel.product.name',
                        'value' => 'payChannel.product.name'
                    ],
                    [
                        'attribute' => 'payChannel.name',
                        'value' => 'payChannel.name'
                    ],
                    [
                        'attribute' => 'payChannel.profit_rate',
                        'value' => 'payChannel.profit_rate'
                    ],
                    [
                        'attribute' => 'payChannel.cost_rate',
                        'value' => 'payChannel.cost_rate'
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
