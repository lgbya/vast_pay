<?php

namespace backend\controllers;

use Yii;
use common\models\ChangeUserMoneyLog;
use common\helper\Helper;
use common\models\PayChannel;
use common\models\Product;
use common\models\User;
use common\models\PayOrder;
use common\models\search\PayOrderSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayOrderController implements the CRUD actions for PayOrder model.
 */
class PayOrderController extends BaseController
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
     * 订单列表
     */
    public function actionIndex()
    {
        $osPayOrder = new PayOrderSearch();
        $dataProvider = $osPayOrder->search(Yii::$app->request->queryParams);

        $payMoneyCount = $dataProvider->query->sum('pay_money');
        $userMoneyCount = $dataProvider->query->sum('user_money');
        $costMoneyCount = $dataProvider->query->sum('cost_money');
//        $profitMoneyCount = $dataProvider->query->sum('profit_money');
        $profitMoneyCount = $payMoneyCount - $userMoneyCount - $costMoneyCount;
        $omProduct = new Product();
        $lProductIdToName = $omProduct->getIdToNameList();

        $omPayChannel = new PayChannel();
        $lChannelIdToName = $omPayChannel->getIdToNameList();


        return $this->render('index', [
            'searchModel' => $osPayOrder,
            'dataProvider' => $dataProvider,
            'lProductIdToName' => $lProductIdToName,
            'lChannelIdToName' => $lChannelIdToName,
            'payMoneyCount' => Helper::formatMoney($payMoneyCount),
            'userMoneyCount' => Helper::formatMoney($userMoneyCount),
            'costMoneyCount' => Helper::formatMoney($costMoneyCount),
            'profitMoneyCount'=>Helper::formatMoney($profitMoneyCount),
        ]);
    }

    /**
     * 订单详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 订单状态手动校正
     */
    public function actionCorrection($id)
    {
        $oqPayOrder = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        if (!$oqPayOrder->checkHaveAddMoney()){
            $oqUser = User::findOne($oqPayOrder->user_id);
            if(!$oqUser->addMoney($oqPayOrder->user_money, ChangeUserMoneyLog::TYPE_PAY_ORDER_CORRECTION, $oqPayOrder->sys_order_id)) {
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

    /**
     * 订单状态手动驳回
     */
    public function actionTurnDown($id)
    {
        $oqPayOrder = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        if ($oqPayOrder->checkHaveAddMoney()){
            $oqUser = User::findOne($oqPayOrder->user_id);
            if(!$oqUser->subMoney($id, $oqPayOrder->user_money, ChangeUserMoneyLog::TYPE_PAY_ORDER_TURN_DOWN, $oqPayOrder->sys_order_id)) {
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

    /**
     * 导出excel
     */
    public function actionExport()
    {
        header('Content-Type: application/vnd.ms-excel;');
        $osPayOrder = new PayOrderSearch();
        $osPayOrder->export(Yii::$app->request->queryParams);
    }

    protected function findModel($id)
    {
        if (($model = PayOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
