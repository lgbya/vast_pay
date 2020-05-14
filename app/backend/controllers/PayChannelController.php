<?php

namespace backend\controllers;

use Yii;
use common\models\PayChannel;
use common\models\search\PayChannelSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class PayChannelController extends BaseController
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
        $osPayChannel = new PayChannelSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['PayChannelSearch']['is_del'] = PayChannel::DEL_STATE_NO;
        $dataProvider = $osPayChannel->search($lsQueryParam);

        return $this->render('index', [
            'searchModel' => $osPayChannel,
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
        $oqPayChannel = new PayChannel();

        if ($oqPayChannel->load(Yii::$app->request->post()) && $oqPayChannel->save()) {
            return $this->redirect(['view', 'id' => $oqPayChannel->id]);
        }

        return $this->render('create', [
            'model' => $oqPayChannel,
        ]);
    }

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

    public function actionDelete($id)
    {
        $oqPayChannel = $this->findModel($id);
        $oqPayChannel->is_del = PayChannel::DEL_STATE_YES;
        $oqPayChannel->save();
        return $this->redirect(['index']);
    }

    public function actionRecycleBin()
    {
        $osPayChannel = new PayChannelSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['PayChannelSearch']['is_del'] = PayChannel::DEL_STATE_YES;
        $dataProvider = $osPayChannel->search($lsQueryParam);

        return $this->render('recycle-bin', [
            'searchModel' => $osPayChannel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRestore($id)
    {
        $oqPayChannel = $this->findModel($id);
        $oqPayChannel->is_del = PayChannel::DEL_STATE_NO;
        $oqPayChannel->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = PayChannel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
