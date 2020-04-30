<?php

namespace backend\controllers;

use common\models\Product;
use common\models\UserToPayChannel;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
        $osUser = new UserSearch();
        $dataProvider = $osUser->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $osUser,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider(['query' => UserToPayChannel::find()]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $omUser = new User();

        if ($omUser->load(Yii::$app->request->post()) && $omUser->save()) {
            return $this->redirect(['view', 'id' => $omUser->id]);
        }

        return $this->render('create', [
            'model' => $omUser,
        ]);
    }

    public function actionUpdate($id)
    {
        $oqUser = $this->findModel($id);

        if ($oqUser->load(Yii::$app->request->post()) && $oqUser->save()) {
            return $this->redirect(['view', 'id' => $oqUser->id]);
        }

        return $this->render('update', [
            'model' => $oqUser,
        ]);
    }

    //这个是公共的修改状态方法，但是不推荐使用，
    public function actionSaveStatus($id, $status)
    {
        if(is_array(User::enumState('status', $status))){
            throw new NotFoundHttpException(Yii::t('app', '不存在此状态.'));
        }

        $oqUser = $this->findModel($id);
        $oqUser->status = $status;
        $oqUser->save();
        return $this->redirect(['index']);
    }

    //每个状态修改都是单独的action，方便以后的需求的更改
    public function actionBanned($id)
    {
        $oqUser = $this->findModel($id);
        $oqUser->status = User::STATUS_INACTIVE;
        $oqUser->save();
        return $this->redirect(['index']);
    }

    public function actionLiftABan($id)
    {
        $oqUser = $this->findModel($id);
        $oqUser->status = User::STATUS_ACTIVE;
        $oqUser->save();
        return $this->redirect(['index']);
    }

    public function actionPayProductAllot($id)
    {
        $omUserToPayChannel = new UserToPayChannel();
        $oqUser = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $lsPost = Yii::$app->request->post('pay_channel_ids',[]);
            $lPayChannelId = [];
            foreach($lsPost as $k => $lv){
                $lPayChannelId = array_merge($lPayChannelId,$lv);
            }
            $result = $omUserToPayChannel->insertUserPayChannels($id, $lPayChannelId);
            if ($result){
                return $this->redirect(['view', 'id' => $oqUser->id]);
            }
        }

        $oqlProduct = Product::find()->andFilterWhere(['is_del'=>Product::DEL_STATE_NO, 'status'=>Product::STATUS_OFF])->all();
        $lsUserProductChannelId = $omUserToPayChannel->getNormalProductToChannelIds($id);
        return $this->render('pay-product-allot', [
            'model'         => $omUserToPayChannel,
            'oqUser'        => $oqUser,
            'oqlProduct'    => $oqlProduct,
            'lsUserProduct' => $lsUserProductChannelId,
        ]);
    }

    protected function findModel($id)
    {
        if (($oqUser = User::findOne($id)) !== null) {
            return $oqUser;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
