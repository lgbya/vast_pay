<?php

namespace home\controllers;

use Yii;
use common\models\ChangeUserMoneyLog;
use common\models\ChangeUserMoneyLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChangeUserMoneyLogController implements the CRUD actions for ChangeUserMoneyLog model.
 */
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
     * Lists all ChangeUserMoneyLog models.
     * @return mixed
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


    protected function findModel($id)
    {
        if (($model = ChangeUserMoneyLog::findOne(['id'=>$id, 'user_id'=> $this->user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
