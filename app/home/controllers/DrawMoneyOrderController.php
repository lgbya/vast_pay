<?php

namespace home\controllers;

use Yii;
use common\models\DrawMoneyOrder;
use common\models\DrawMoneyOrderSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DrawMoneyOrderController implements the CRUD actions for DrawMoneyOrder model.
 */
class DrawMoneyOrderController extends BaseController
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
     * 提款申请列表
     */
    public function actionIndex()
    {
        $searchModel = new DrawMoneyOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 提款申请详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 提款申请
     */
    public function actionCreate()
    {
        $omDrawMoneyOrder = new DrawMoneyOrder();
        $lsPost = Yii::$app->request->post();
        if (Yii::$app->request->isPost){
            $lsPost['DrawMoneyOrder']['user_id'] = $this->user_id;
            $lsPost['DrawMoneyOrder']['sys_order_id'] = $omDrawMoneyOrder->generateSysOrderId($this->user_id);
        }
        if ($omDrawMoneyOrder->load($lsPost) && $omDrawMoneyOrder->addApplyAndWithhold()) {
            return $this->redirect(['view', 'id' => $omDrawMoneyOrder->id]);
        }

        return $this->render('create', [
            'model' => $omDrawMoneyOrder,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = DrawMoneyOrder::findOne(['id'=>$id, 'user_id'=>$this->user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
