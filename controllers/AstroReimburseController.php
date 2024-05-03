<?php

namespace app\controllers;

use Yii;
use app\models\Pegawai;
use app\models\AstroReimburse;
use app\models\AstroReimburseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

/**
 * AstroReimburseController implements the CRUD actions for AstroReimburse model.
 */
class AstroReimburseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->COMPANY == "ASTRO"): 
                $action = ['index','index-app','update-app','update-rej'];
            endif;
        endif;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','index-app','update-app','update-rej'],
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
     * Lists all AstroReimburse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AstroReimburseSearch();
        $tglAwal = date('Y-m-01');
        $tglAkhir = date('Y-m-t');
        $searchModel->CREATED_AT = $tglAwal.' - '.$tglAkhir;
        $dataProvider =$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all AstroReimburse models.
     * @return mixed
     */
    public function actionIndexApp()
    {
        $searchModel = new AstroReimburseSearch();
        $searchModel->STATUS_PENGAJUAN = "0";
        $dataProvider =$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-app', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Akademis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdateApp($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) :

            $model->TGL_APPROVED = date('Y-m-d H:i:s',strtotime( '+7 hour' , strtotime ( date('Y-m-d H:i:s') )));
            $model->UPDATED_AT = date('Y-m-d H:i:s',strtotime( '+7 hour' , strtotime ( date('Y-m-d H:i:s') )));
            if($model->validate()):
                $model->save();
                Yii::$app->session->setFlash('info', "Pengajuan Reimburse berhasil disetujui.");
                return $this->redirect(['index-app']);
            else:
                Yii::$app->session->setFlash('error', "Pengajuan Reimburse tidak berhasil disetujui : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->render('_form', [
                    'model' => $model,
                ]);
            endif;
        endif;

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Akademis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdateRej($id)
    {
        $model = $this->findModel($id);
        $model->STATUS_PENGAJUAN = '2';
        $model->UPDATED_AT = date('Y-m-d H:i:s',strtotime( '+7 hour' , strtotime ( date('Y-m-d H:i:s') )));
        $model->TGL_REJECTED = date('Y-m-d H:i:s',strtotime( '+7 hour' , strtotime ( date('Y-m-d H:i:s') )));
        if($model->validate()):
            $model->save();
            Yii::$app->session->setFlash('info', "Pengajuan Reimburse berhasil ditolak.");
            return $this->redirect(['index']);
        else:
            Yii::$app->session->setFlash('error', "Pengajuan Reimburse tidak berhasil ditolak : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            return $this->redirect(['index-app']);
        endif;
    }

    /**
     * Finds the AstroReimburse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AstroReimburse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AstroReimburse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
