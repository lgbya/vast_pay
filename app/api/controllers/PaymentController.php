<?php
namespace api\controllers;

use Yii;
use api\payment\Payment;
use common\helper\ErrorCode;
use common\helper\Helper;
use common\models\ChangeUserMoneyLog;
use common\models\PayChannelAccount;
use common\models\PayOrder;
use common\models\form\QueryPayOrderForm;
use common\models\User;
use common\models\UserToPayChannel;
use common\models\form\PaymentForm;

class PaymentController extends BaseController
{

    /**
     *  支付接口
     */
    public function actionIndex()
    {
        try{
            $ofPayment = new PaymentForm();
            if (!$ofPayment->load(Yii::$app->request->post(),'')){
                return Helper::showJsonError(ErrorCode::PAYMENT_FORM_ERR);
            }

            if (!$ofPayment->checkData()){
                return Helper::showJsonError(ErrorCode::PAYMENT_DATA_ERR, '', $ofPayment->errors);
            }

            $oqUser = $ofPayment->getUser();
            $omUserToPayChannel = new UserToPayChannel();
            $lsUserChannel = $omUserToPayChannel->getNormalUserChannels($oqUser->id, $ofPayment->product_id);
            if (count($lsUserChannel) == 0){
                return Helper::showJsonError(ErrorCode::CHANNEL_NOT_FOUND);
            }
            $lChannel = Helper::countWeight($lsUserChannel);

            $lsAccount = PayChannelAccount::find()->andFilterWhere(['pay_channel_id'=>$lChannel['id']])->asArray()->all();
            if (count($lsAccount) == 0){
                return Helper::showJsonError(ErrorCode::CHANNEL_ACCOUNT_NOT_FOUNT);
            }
            $lAccount = Helper::countWeight($lsAccount);

            $oqPayOrder = (new PayOrder())->generateOrder($oqUser, $ofPayment, $lChannel, $lAccount);
            if ($oqPayOrder === false){
                return Helper::showJsonError(ErrorCode::CHANNEL_NOT_FOUND);
            }

            $channelObject = $this->newChannelObject($oqPayOrder->pay_channel_code);
            if ($channelObject == false){
                return Helper::showJsonError(ErrorCode::CHANNEL_NOT_FOUND);
            }

            return $channelObject->index($oqPayOrder);
        }catch (\Error $e){
            Yii::error($e);
            return Helper::showJsonError(ErrorCode::SYSTEM_ERR);
        }

    }

    /**
     *  回调接口
     */
    public function actionNotify($sysOrderId)
    {
        try{
            if (($oqPayOrder = PayOrder::findBySysOrderId($sysOrderId)) === null  ){
                Yii::warning(['message'=>'订单不存在','sys_order_id'=>$sysOrderId,]);
                return false;
            }

            if ($oqPayOrder->status != PayOrder::STATUS_NON_PAYMENT){
                return false;
            }

            $lWarningLog = [
                'sys_order_id' => $sysOrderId ,
                'channel_file' => $oqPayOrder->pay_channel_code,
                'request' => Yii::$app->request,
            ];

            if (($channelObject = $this->newChannelObject($oqPayOrder->pay_channel_code)) === false){
                Yii::warning($lWarningLog['message']='接口文件不存在！！！');
                return $channelObject->failShow;
            }

            if (!$channelObject->notify($oqPayOrder)){
                Yii::warning($lWarningLog['message']='验签失败！！！');
                return $channelObject->failShow;
            }


            $transaction = Yii::$app->db->beginTransaction();
            $oqPayOrder->status = PayOrder::STATUS_HAVE_PAID;
            $oqPayOrder->supplier_order_id = $channelObject->supplier_order_id;
            $oqPayOrder->notify_at = time();
            if (!$oqPayOrder->save()){
                Yii::warning(['message' =>'订单修改状态失败！！！','sys_order_id' => $sysOrderId , 'errors'=> $oqPayOrder->errors]);
                $transaction->rollBack();
                return $channelObject->failShow;
            }
            $oqUser = User::findOne($oqPayOrder->user_id);
            if(!$oqUser->addMoney( $oqPayOrder->user_money, ChangeUserMoneyLog::TYPE_PAY_ORDER_SUCCESS, $oqPayOrder->sys_order_id)) {
                $transaction->rollBack();
                return $channelObject->failShow;
            }
            $transaction->commit();

            $oqPayOrder->notifyUser();

            return $channelObject->successShow;
        }catch (\Error $e){
            Yii::error($e);
            return Helper::showJsonError(ErrorCode::SYSTEM_ERR);
        }
    }

    /**
     *  同步接口
     */
    public function actionCallback($sysOrderId)
    {
        try{
            if (($oqPayOrder = PayOrder::findBySysOrderId($sysOrderId)) === null  ){
                Yii::warning(['message'=>'订单不存在','sys_order_id'=>$sysOrderId,]);
                return false;
            }

            if ($oqPayOrder->status != PayOrder::STATUS_NON_PAYMENT){
                return false;
            }

            $lWarningLog = [
                'sys_order_id' => $sysOrderId ,
                'channel_file' => $oqPayOrder->pay_channel_code,
                'request' => Yii::$app->request,
            ];

            if (($channelObject = $this->newChannelObject($oqPayOrder->pay_channel_code)) === false){
                Yii::warning($lWarningLog['message']='接口文件不存在！！！');
                return false;
            }

            if (!$channelObject->callback($oqPayOrder)){
                Yii::warning($lWarningLog['message']='验签失败！！！');
                return false;
            }

            return $oqPayOrder->callbackUser();
        }catch (\Error $e){
            Yii::error($e);
            return Helper::showJsonError(ErrorCode::SYSTEM_ERR);
        }
    }

    /**
     *  查询订单接口
     */
    public function actionQueryOrder()
    {
        try{
            $ofQueryPayOrder = new QueryPayOrderForm();
            if (!$ofQueryPayOrder->load(Yii::$app->request->post(),'')){
                return Helper::showJsonError(ErrorCode::PAYMENT_FORM_ERR);
            }

            if (!$ofQueryPayOrder->checkData()){
                return Helper::showJsonError(ErrorCode::PAYMENT_DATA_ERR, '', $ofQueryPayOrder->errors);
            }

            if(($oqPayOrder = PayOrder::findByUserOrder($ofQueryPayOrder->getUser()->id, $ofQueryPayOrder->order_id)) === null){
                return Helper::showJsonError(ErrorCode::CHANNEL_ORDER_NOT_FOUND_ERR);
            }

            return Helper::showJsonSuccess($oqPayOrder->notifyUserParams($ofQueryPayOrder->sign_type));
        }catch (\Error  $e){
            Yii::error($e);
            return Helper::showJsonError(ErrorCode::SYSTEM_ERR);
        }
    }

    /**
     *  new 支付通道类
     */
    protected function newChannelObject($code)
    {
        $code = 'api\payment\channel\\' . $code . 'Channel';
        if (class_exists($code)){
            $channelObject = new $code;
            if( $channelObject instanceof Payment ) {
                return $channelObject;
            }
        }
        return false;
    }
}