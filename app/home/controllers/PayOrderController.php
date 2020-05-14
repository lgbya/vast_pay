<?php

namespace home\controllers;

use common\models\Product;
use Yii;
use common\models\PayOrder;
use common\models\search\PayOrderSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PayOrderController extends BaseController
{
    /**
     * {@inheritdoc}
     */
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
     * 订单列表.
     */
    public function actionIndex()
    {
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['PayOrderSearch']['user_id'] = $this->user_id;

        $searchModel = new PayOrderSearch();
        $dataProvider = $searchModel->search($lsQueryParam);

        $omProduct = new Product();
        $lProductIdToName = $omProduct->getIdToNameList();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lProductIdToName' => $lProductIdToName,
        ]);
    }

    /**
     * 订单详情.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 导出excel
     */
    public function actionExport()
    {
        header('Content-Type: application/vnd.ms-excel;');

        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['PayOrderSearch']['user_id'] = $this->user_id;

        $osPayOrder = new PayOrderSearch();
        $osPayOrder->export($lsQueryParam);
    }

    protected function findModel($id)
    {
        if (($model = PayOrder::findOne(['id'=>$id, 'user_id'=> $this->user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
