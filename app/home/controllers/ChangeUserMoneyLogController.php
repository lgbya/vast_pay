<?php

namespace home\controllers;

use Yii;
use common\models\ChangeUserMoneyLog;
use common\models\search\ChangeUserMoneyLogSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ChangeUserMoneyLogController extends BaseController
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
     * 资金更改日志
     */
    public function actionIndex()
    {
        $searchModel = new ChangeUserMoneyLogSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['ChangeUserMoneyLogSearch']['user_id'] = $this->user_id;
        $dataProvider = $searchModel->search($lsQueryParam);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 导出excel
     */
    public function actionExport()
    {
        header('Content-Type: application/vnd.ms-excel;');

        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['ChangeUserMoneyLogSearch']['user_id'] = $this->user_id;

        $osChangeUserMoneyLog = new ChangeUserMoneyLogSearch();
        $osChangeUserMoneyLog->export($lsQueryParam);
    }

    protected function findModel($id)
    {
        if (($model = ChangeUserMoneyLog::findOne(['id'=>$id, 'user_id'=> $this->user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
