<?php
namespace api\controllers;

use common\helper\ErrorCode;
use common\helper\Helper;
use common\models\UserToPayChannel;
use Yii;
use common\models\PaymentForm;

class PaymentController extends BaseController
{

    public function actionIndex()
    {

        $ofPayment = new PaymentForm();
        if (!$ofPayment->load(Yii::$app->request->post(),'')){
            return Helper::showJsonError(ErrorCode::UNPROCESSABLE_ENTITY);
        }

        if (!$ofPayment->checkData()){
            return Helper::showJsonError(ErrorCode::UNAUTHORIZED, '', $ofPayment->errors);
        }

        $oqUser = $ofPayment->getUser();
        $omUserToPayChannel = new UserToPayChannel();
        echo '<pre>';
        var_dump($omUserToPayChannel->getNormalUserChannels($oqUser->id, $ofPayment->product_id));

        exit;
    }

    public function actionNotify()
    {

    }

    public function actionCallback()
    {

    }

    public function actionQueryOrder()
    {

    }

}