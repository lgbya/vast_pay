<?php

namespace app\commands;

use common\models\PayOrder;
use yii\console\ExitCode;

class PayOrderController extends BaseController
{

    public function actionNotifyUser()
    {
        $oqlPayOrder = PayOrder::find()
            ->andFilterWhere(['status'=>PayOrder::STATUS_HAVE_PAID])
            ->andFilterWhere(['between', 'inform_num', 1, 5 ])
            ->orderBy(['notify_at'=>'desc'])
            ->all();

        foreach($oqlPayOrder as $k => $v){
            $v->notifyUser();
        }
        return ExitCode::OK;
    }
}
