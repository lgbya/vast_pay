<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\search\ProductSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
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
        $osProduct = new ProductSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['ProductSearch']['is_del'] = Product::DEL_STATE_NO;
        $dataProvider = $osProduct->search($lsQueryParam);

        return $this->render('index', [
            'searchModel' => $osProduct,
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
        $omProduct = new Product();

        if ($omProduct->load(Yii::$app->request->post()) && $omProduct->save()) {
            return $this->redirect(['view', 'id' => $omProduct->id]);
        }

        return $this->render('create', [
            'model' => $omProduct,
        ]);
    }


    public function actionUpdate($id)
    {
        $oqProduct = $this->findModel($id);

        if ($oqProduct->load(Yii::$app->request->post()) && $oqProduct->save()) {
            return $this->redirect(['view', 'id' => $oqProduct->id]);
        }

        return $this->render('update', [
            'model' => $oqProduct,
        ]);
    }


    public function actionDelete($id)
    {
        $oqProduct = $this->findModel($id);
        $oqProduct->is_del = Product::DEL_STATE_YES;
        $oqProduct->save();
        return $this->redirect(['index']);
    }

    public function actionRecycleBin()
    {
        $osProduct = new ProductSearch();
        $lsQueryParam = Yii::$app->request->queryParams;
        $lsQueryParam['ProductSearch']['is_del'] = Product::DEL_STATE_YES;
        $dataProvider = $osProduct->search($lsQueryParam);

        return $this->render('recycle-bin', [
            'searchModel' => $osProduct,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRestore($id)
    {
        $oqProduct = $this->findModel($id);
        $oqProduct->is_del = Product::DEL_STATE_NO;
        $oqProduct->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($oqProduct = Product::findOne($id)) !== null) {
            return $oqProduct;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
