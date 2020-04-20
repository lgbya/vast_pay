<?php

namespace backend\controllers;

use Yii;
use common\models\PayChannelAccount;
use common\models\PayChannelAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayChannelAccountController implements the CRUD actions for PayChannelAccount model.
 */
class PayChannelAccountController extends Controller
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
     * Lists all PayChannelAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $osPayChannelAccount = new PayChannelAccountSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $payChannelId = $lsQueryParam['pay_channel_id'];
        $payChannelName =  $lsQueryParam['pay_channel_name'];

        $lsQueryParam['PayChannelAccount']['pay_channel_id'] = $payChannelId;
        $lsQueryParam['PayChannelAccount']['is_del'] = PayChannelAccount::DEL_STATE_NO;
        $dataProvider = $osPayChannelAccount->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'payChannelId' => $payChannelId,
            'payChannelName' => $payChannelName,
            'searchModel' => $osPayChannelAccount,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayChannelAccount model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PayChannelAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $gPayChannelId = Yii::$app->request->get('pay_channel_id', '');
        $lPost = Yii::$app->request->post();
        if ($lPost !== []){
            $lPost['PayChannelAccount']['pay_channel_id'] = $gPayChannelId;
        }
        $omPayChannelAccount = new PayChannelAccount();
        if ($omPayChannelAccount->load($lPost) && $omPayChannelAccount->save()) {
            return $this->redirect(['view', 'id' => $omPayChannelAccount->id]);
        }

        return $this->render('create', [
            'model' => $omPayChannelAccount,
        ]);
    }

    /**
     * Updates an existing PayChannelAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing PayChannelAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $oqPayChannelAccount = $this->findModel($id);
        $oqPayChannelAccount->is_del = PayChannelAccount::DEL_STATE_YES;
        $oqPayChannelAccount->save();
        return $this->redirect(['index']);
    }


    /**
     * Finds the PayChannelAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayChannelAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayChannelAccount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
