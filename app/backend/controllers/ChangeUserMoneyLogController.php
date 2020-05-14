<?php

namespace backend\controllers;

use Yii;
use common\models\ChangeUserMoneyLog;
use common\models\search\ChangeUserMoneyLogSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChangeUserMoneyLogController implements the CRUD actions for ChangeUserMoneyLog model.
 */
class ChangeUserMoneyLogController extends BaseController
{

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
        $searchModel = new ChangeUserMoneyLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $lsQueryParam = Yii::$app->request->queryParams;

        header('Content-Type: application/vnd.ms-excel;');
        $osChangeUserMoneyLog = new ChangeUserMoneyLogSearch();
        $osChangeUserMoneyLog->export($lsQueryParam);
    }

    protected function findModel($id)
    {
        if (($model = ChangeUserMoneyLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
