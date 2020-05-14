<?php

namespace backend\controllers;

use common\models\search\PayOrderSearch;
/**
 * ChangeUserMoneyLogController implements the CRUD actions for ChangeUserMoneyLog model.
 */
class DataReportController extends BaseController
{
    public function actionProductAnalyze()
    {

        $osPayOrder = new PayOrderSearch();
        $oqlPayOrderSum = $osPayOrder->getProductGroupMoneySum();

        $lsProductMoneySum = [];
        foreach($oqlPayOrderSum as  $k => $v){
            $lsProductMoneySum['product_name'][] = $v->product->name;
            $lsProductMoneySum['pay_money'][] = $v->pay_money;
            $lsProductMoneySum['user_money'][] = $v->user_money;
            $lsProductMoneySum['cost_money'][] = $v->cost_money;
            $lsProductMoneySum['profit_money'][] = $v->pay_money - $v->user_money - $v->cost_money;
        }


        $oqlPayOrder = $osPayOrder->getBeforetimeOrder();
        $lsEverydayMoneySum = [];
        $lDate = [];
        foreach($oqlPayOrder as $k => $v){
            $date = date('Ymd',$v->notify_at);
            $lDate[$date] = date('Y-m-d',$v->notify_at);
            $lsEverydayMoneySum['pay_money'][$date] += $v->pay_money;
            $lsEverydayMoneySum['user_money'][$date] += $v->user_money;
            $lsEverydayMoneySum['cost_money'][$date] += $v->cost_money;
            $lsEverydayMoneySum['profit_money'][$date] += ($v->pay_money - $v->user_money - $v->cost_money);
        }

        return $this->render('product-analyze',[
            'lsProductMoneySum' => $lsProductMoneySum,
            'lDate' => $lDate,
            'lsEverydayMoneySum'=>$lsEverydayMoneySum,
        ]);
    }
}
