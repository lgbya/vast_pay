<?php

namespace backend\controllers;

use Yii;
use common\models\PayChannel;
use common\models\PayChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayChannelController implements the CRUD actions for PayChannel model.
 */
class PayChannelController extends Controller
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
     * Lists all PayChannel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $osPayChannel = new PayChannelSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['PayChannel']['is_del'] = PayChannel::DEL_STATE_NO;
        $dataProvider = $osPayChannel->search($lsQueryParam);

        return $this->render('index', [
            'searchModel' => $osPayChannel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayChannel model.
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
     * Creates a new PayChannel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $oqPayChannel = new PayChannel();

        if ($oqPayChannel->load(Yii::$app->request->post()) && $oqPayChannel->save()) {
            return $this->redirect(['view', 'id' => $oqPayChannel->id]);
        }

        return $this->render('create', [
            'model' => $oqPayChannel,
        ]);
    }

    /**
     * Updates an existing PayChannel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $oqPayChannel = $this->findModel($id);

        if ($oqPayChannel->load(Yii::$app->request->post()) && $oqPayChannel->save()) {
            return $this->redirect(['view', 'id' => $oqPayChannel->id]);
        }

        return $this->render('update', [
            'model' => $oqPayChannel,
        ]);
    }

    /**
     * Deletes an existing PayChannel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $oqPayChannel = $this->findModel($id);
        $oqPayChannel->is_del = PayChannel::DEL_STATE_YES;
        $oqPayChannel->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the PayChannel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayChannel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayChannel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
