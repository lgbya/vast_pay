<?php

namespace backend\controllers;

use Yii;
use common\models\DrawMoneyOrder;
use common\models\search\DrawMoneyOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DrawMoneyOrderController implements the CRUD actions for DrawMoneyOrder model.
 */
class DrawMoneyOrderController extends Controller
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
     * 提款订单列表
     */
    public function actionIndex()
    {
        $osDrawMoneyOrder = new DrawMoneyOrderSearch();
        $dataProvider = $osDrawMoneyOrder->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $osDrawMoneyOrder,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 提款订单详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 修改提款订单
     */
    public function actionUpdate($id)
    {
        $oqDrawMoney = $this->findModel($id);
        if ($oqDrawMoney->load(Yii::$app->request->post()) && $oqDrawMoney->saveApply()) {
            return $this->redirect(['view', 'id' => $oqDrawMoney->id]);
        }

        return $this->render('update', [
            'model' => $oqDrawMoney,
        ]);
    }

    /**
     * 导出excel
     */
    public function actionExport()
    {
        header('Content-Type: application/vnd.ms-excel;');
        $osDrawMoneyOrder = new DrawMoneyOrderSearch();
        $osDrawMoneyOrder->export(Yii::$app->request->queryParams);
    }


    protected function findModel($id)
    {
        if (($oqDrawMoney = DrawMoneyOrder::findOne($id)) !== null) {
            return $oqDrawMoney;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
