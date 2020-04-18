<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
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

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $oqProduct = $this->findModel($id);
        $oqProduct->is_del = Product::DEL_STATE_YES;
        $oqProduct->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($oqProduct = Product::findOne($id)) !== null) {
            return $oqProduct;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
