<?php

namespace home\controllers;

use common\models\Product;
use Yii;
use common\models\PayOrder;
use common\models\PayOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayOrderController implements the CRUD actions for PayOrder model.
 */
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
     * Lists all PayOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['PayOrderSearch']['user_id'] = $this->user_id;

        $searchModel = new PayOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $omProduct = new Product();
        $lProductIdToName = $omProduct->getIdToNameList();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lProductIdToName' => $lProductIdToName,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    protected function findModel($id)
    {
        if (($model = PayOrder::findOne(['id'=>$id, 'user_id'=> $this->user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
