<?php

namespace backend\controllers;

use common\models\ChangeUserMoneyLog;
use common\models\PayChannel;
use common\models\Product;
use common\models\User;
use phpDocumentor\Reflection\Types\Null_;
use Yii;
use common\models\PayOrder;
use common\models\PayOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayOrderController implements the CRUD actions for PayOrder model.
 */
class PayOrderController extends Controller
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

    public function actionIndex()
    {
        $osPayOrder = new PayOrderSearch();
        $dataProvider = $osPayOrder->search(Yii::$app->request->queryParams);

        $omProduct = new Product();
        $lProductIdToName = $omProduct->getIdToNameList();

        $omPayChannel = new PayChannel();
        $lChannelIdToName = $omPayChannel->getIdToNameList();

        return $this->render('index', [
            'searchModel' => $osPayOrder,
            'dataProvider' => $dataProvider,
            'lProductIdToName' => $lProductIdToName,
            'lChannelIdToName' => $lChannelIdToName,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCorrection($id)
    {
        $oqPayOrder = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        if (!$oqPayOrder->checkHaveAddMoney()){
            if(!User::addMoney($id, $oqPayOrder->user_money, ChangeUserMoneyLog::TYPE_PAY_ORDER_CORRECTION, $oqPayOrder->sys_order_id)) {
                $transaction->rollBack();
                throw new NotFoundHttpException(Yii::t('app', '订单校正失败！用户增加金额无效'));
            }
        }
        $oqPayOrder->status = PayOrder::STATUS_CORRECTION;
        if($oqPayOrder->save() === false){
            $transaction->rollBack();
            throw new NotFoundHttpException(Yii::t('app', '订单校正失败！修改状态无效'));
        }
        $transaction->commit();
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionTurnDown($id)
    {
        $oqPayOrder = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        if ($oqPayOrder->checkHaveAddMoney()){
            if(!User::subMoney($id, $oqPayOrder->user_money, ChangeUserMoneyLog::TYPE_PAY_ORDER_TURN_DOWN, $oqPayOrder->sys_order_id)) {
                $transaction->rollBack();
                throw new NotFoundHttpException(Yii::t('app', '订单校正失败！用户增加金额无效'));
            }
        }
        $oqPayOrder->status = PayOrder::STATUS_TURN_DOWN;
        if($oqPayOrder->save() === false){
            $transaction->rollBack();
            throw new NotFoundHttpException(Yii::t('app', '订单校正失败！修改状态无效'));
        }
        $transaction->commit();
        return $this->redirect(['view','id'=>$id]);
    }

    protected function findModel($id)
    {
        if (($model = PayOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
