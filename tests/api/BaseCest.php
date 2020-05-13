<?php

use common\models\PayChannel;
use common\models\UserToPayChannel;

class BaseCest {

    /**
     * 获取产品id
     */
    protected function getProductId()
    {
        $oqlUserToPayChannel = UserToPayChannel::find()->andFilterWhere(['user_id'=>$this->_user->id])->all();

        if(count($oqlUserToPayChannel) == 0){
            codecept_debug('用户没有分配到通道');
        }

        $productId = 0;
        foreach($oqlUserToPayChannel as $k => $v){
            $oqPayChannel = $v->payChannel;
            if($oqPayChannel->status == PayChannel::STATUS_ON && $oqPayChannel->is_del == PayChannel::DEL_STATE_NO){
                $productId = $oqPayChannel->product_id;
                break;
            }
        }
        if($productId == 0){
            codecept_debug('用户分配到通道不可用');
        }
        return $productId;
    }
}