<?php

namespace app\controllers;

use Yii;
use app\models\PlnETarifSppdInter;
use app\models\PlnETarifSppdInterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * PlnETarifSppdInterController implements the CRUD actions for PlnETarifSppdInter model.
 */
class PlnETarifSppdInterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "14"):
                $action = ['index','create','update','delete'];
            else: 
                $action = ['none'];
            endif;
        endif;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','create','update','delete'],
                'rules' => [
                    // allow authenticated users
                    [
                        'actions' => $action,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                    [
                        'actions' => $action,
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PlnETarifSppdInter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlnETarifSppdInterSearch();
        $dataProvider =$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all PlnETarifSppdInter models.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlnETarifSppdInter();

        if ($model->load(Yii::$app->request->post()) ) :
            $model->ID = mt_rand(1000000, 9999999).'-'.uniqid().'-'.mt_rand(10000, 99999);
            if($model->save()):
                Yii::$app->session->setFlash('info', "Data berhasil ditambahkan.");
            else:
                Yii::$app->session->setFlash('error', "Penambahan Data tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            endif;
        endif;

        return $this->redirect(['index']);
    }

    /**
     * Lists all PlnETarifSppdInter models.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = PlnETarifSppdInter::findOne($id);

        if ($model->load(Yii::$app->request->post())) :
            if($model->save()):
                Yii::$app->session->setFlash('info', "Data berhasil diubah.");
                return $this->redirect(['index']);
            else:
                Yii::$app->session->setFlash('error', "Perubahan Data tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            endif;
        endif;

        return $this->render('update',[
            'model'=>$model
        ]);
    }

    /**
     * Lists all PlnETarifSppdInter models.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = PlnETarifSppdInter::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('info', "Data berhasil dihapus.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlnETarifSppdInter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlnETarifSppdInter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlnEVp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
