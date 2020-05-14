<?php

namespace home\controllers;


use common\models\UserToPayChannel;
use Yii;
use common\models\Product;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProductController extends BaseController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 用户开通产品的基本信息
     */
    public function actionIndex()
    {
        $omUserToPayChannel = new UserToPayChannel();
        $lsUserChannel = $omUserToPayChannel->getNormalUserChannels($this->user_id);
        $omProduct = new Product();
        $oqlProduct = $omProduct->getAllNormalProducts();

        $lsProduct = [];
        foreach ($oqlProduct as $k => $v){
            foreach($lsUserChannel as $k2 => $v2){
                $lsProduct[$v2['product_id']]['name'] = $v->name;

                $isMin = $lsProduct[$v2['product_id']]['min_cost_rate'] > $v2['cost_rate'];
                $hasMin = isset($lsProduct[$v2['product_id']]['min_cost_rate']);
                if ($hasMin == false || $isMin){
                    $lsProduct[$v2['product_id']]['min_cost_rate'] = $v2['cost_rate'];
                }

                $isMax = $lsProduct[$v2['product_id']]['max_cost_rate'] < $v2['cost_rate'];
                $hasMax = isset($lsProduct[$v2['product_id']]['max_cost_rate']);
                if ($hasMax == false || $isMax){
                    $lsProduct[$v2['product_id']]['max_cost_rate'] = $v2['cost_rate'];
                }
            }
        }

        return $this->render('index', [
            'lsProduct' => $lsProduct,
            'omProduct' =>$omProduct,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
