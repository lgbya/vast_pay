<?php

namespace backend\controllers;

use Yii;
use common\models\PayChannelAccount;
use common\models\PayChannelAccountSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayChannelAccountController implements the CRUD actions for PayChannelAccount model.
 */
class PayChannelAccountController extends BaseController
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

    public function actionIndex()
    {
        $osPayChannelAccount = new PayChannelAccountSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $payChannelId = $lsQueryParam['pay_channel_id'];
        $payChannelName =  $lsQueryParam['pay_channel_name'];

        $lsQueryParam['PayChannelAccountSearch']['pay_channel_id'] = $payChannelId;
        $lsQueryParam['PayChannelAccountSearch']['is_del'] = PayChannelAccount::DEL_STATE_NO;
        $dataProvider = $osPayChannelAccount->search($lsQueryParam);
        return $this->render('index', [
            'payChannelId' => $payChannelId,
            'payChannelName' => $payChannelName,
            'searchModel' => $osPayChannelAccount,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $gPayChannelId = Yii::$app->request->get('pay_channel_id', '');
        $lPost = Yii::$app->request->post();
        if ($lPost !== []){
            $lPost['PayChannelAccountSearch']['pay_channel_id'] = $gPayChannelId;
        }
        $omPayChannelAccount = new PayChannelAccount();
        if ($omPayChannelAccount->load($lPost) && $omPayChannelAccount->save()) {
            return $this->redirect(['view', 'id' => $omPayChannelAccount->id]);
        }

        return $this->render('create', [
            'model' => $omPayChannelAccount,
        ]);
    }

    public function actionUpdate($id)
    {
        $oqPayChannelAccount = $this->findModel($id);

        if ($oqPayChannelAccount->load(Yii::$app->request->post()) && $oqPayChannelAccount->save()) {
            return $this->redirect(['view', 'id' => $oqPayChannelAccount->id]);
        }

        return $this->render('update', [
            'model' => $oqPayChannelAccount,
        ]);
    }

    public function actionDelete($id)
    {
        $oqPayChannelAccount = $this->findModel($id);
        $oqPayChannelAccount->is_del = PayChannelAccount::DEL_STATE_YES;
        $oqPayChannelAccount->save();
        return $this->redirect(['index']);
    }

    public function actionRecycleBin()
    {
        $osPayChannelAccount = new PayChannelAccountSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $payChannelId = $lsQueryParam['pay_channel_id'];
        $payChannelName =  $lsQueryParam['pay_channel_name'];

        $lsQueryParam['PayChannelAccountSearch']['pay_channel_id'] = $payChannelId;
        $lsQueryParam['PayChannelAccountSearch']['is_del'] = PayChannelAccount::DEL_STATE_YES;
        $dataProvider = $osPayChannelAccount->search($lsQueryParam);

        return $this->render('recycle-bin', [
            'payChannelId' => $payChannelId,
            'payChannelName' => $payChannelName,
            'searchModel' => $osPayChannelAccount,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRestore($id)
    {
        $oqPayChannelAccount = $this->findModel($id);
        $oqPayChannelAccount->is_del = PayChannelAccount::DEL_STATE_NO;
        $oqPayChannelAccount->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = PayChannelAccount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
