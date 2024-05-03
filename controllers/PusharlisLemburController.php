<?php

namespace app\controllers;

use Yii;
use app\models\Pegawai;
use app\models\PusharlisLembur;
use app\models\PusharlisLemburSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

/**
 * PusharlisLemburController implements the CRUD actions for PusharlisLembur model.
 */
class PusharlisLemburController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "4"): 
                $action = ['index','update','index-app','generate-spkl'];
            elseif((Yii::$app->user->identity->JENIS == "10" || Yii::$app->user->identity->JENIS == "11")): 
                $action = ['index','update','index-app','generate-spkl','update-tolak'];
            endif;
        endif;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'update' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                // 'only' => ['index','update','index-app','index-report','update','print-to-excel','print-to-pdf'],
                'only' => ['index','update','index-app','generate-spkl','update-tolak'],
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
     * Lists all PusharlisLembur models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PusharlisLemburSearch();
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
     * Lists all PusharlisLembur models.
     * @return mixed
     */
    public function actionIndexApp()
    {
        $searchModel = new PusharlisLemburSearch();
        if(Yii::$app->user->identity->JENIS == "11"):
            $searchModel->STATUS_PENGAJUAN = "2";
        elseif(Yii::$app->user->identity->JENIS == "10"):
            $searchModel->STATUS_PENGAJUAN = "3";
        else:
            $searchModel->STATUS_APP = 1;
        endif;
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
    public function actionUpdate($id,$key)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) :

            $jamLembur = explode(' - ',$model->JAM_AWAL_LEMBUR);
            $model->JAM_AWAL_LEMBUR = $jamLembur[0];
            $model->JAM_AKHIR_LEMBUR = $jamLembur[1];
            $model->JUMLAH_JAM = $model->jumker;
            if($model->JENIS_LEMBUR == "Hari Kerja" AND $model->JUMLAH_JAM > 4):
                $model->JUMLAH_JAM = 4;
            endif;
            
            $model->TOTAL_UPAH_LEMBUR = 0;
            if($model->JENIS_LEMBUR == "Hari Kerja"):
                $model->TOTAL_UPAH_LEMBUR = $model->lemKer;
            elseif($model->JENIS_LEMBUR == "Hari Libur"):
                $model->TOTAL_UPAH_LEMBUR = $model->lemLibNam;
            elseif($model->JENIS_LEMBUR == "Hari Libur Nasional"):
                $model->TOTAL_UPAH_LEMBUR = $model->lemLibNasNam;
            endif;

            $model->UPDATED_AT = date('Y-m-d H:i:s');
            if($model->validate()):
                $model->save();
                Yii::$app->session->setFlash('info', "Perubahan data lembur dengan nomor ".$model->ID." berhasil.");
                return $this->redirect(['index-app']);
            else:
                Yii::$app->session->setFlash('error', "Perubahan data lembur tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->render('_form', [
                    'model' => $model,
                ]);
            endif;
        else:
            $model->STATUS_PENGAJUAN = $key;
            $model->JAM_AWAL_LEMBUR = $model->JAM_AWAL_LEMBUR.' - '.$model->JAM_AKHIR_LEMBUR;
            return $this->render('_form', [
                'model' => $model,
            ]);
        endif;
    }

    /**
     * Creates a new Akademis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdateTolak()
    {
        $modelLoad = new PusharlisLembur();
        if ($modelLoad->load(Yii::$app->request->post()) ) :
            $model = $this->findModel($modelLoad->ID);
            $model->ALASAN = $modelLoad->ALASAN;
            $model->STATUS_PENGAJUAN = '5';
            $model->UPDATED_AT = date('Y-m-d H:i:s');
            if($model->validate()):
                $model->save(false);
                Yii::$app->session->setFlash('info', "Pengajuan lembur berhasil ditolak.");
                return $this->redirect(['index']);
            else:
                Yii::$app->session->setFlash('error', "Pengajuan lembur tidak berhasil ditolak : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->redirect(['index']);
            endif;
        endif;
    }

    /**
     * Finds the PusharlisLembur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PusharlisLembur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PusharlisLembur::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Spkl model.
     * @param string $id
     * @return mixed
     */
    public function actionGenerateSpkl($id)
    {
        $model = PusharlisLembur::findOne($id);
        $spkl = str_replace("/","-",$id);
        $filename = $spkl.'.pdf';

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'filename'=> $filename,
            'marginTop'=>10,
            'marginBottom'=>10,
            'marginLeft'=>2,
            'marginRight'=>2,
            'destination'=>Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('template-spkl',['id'=>$id, 'model'=>$model]),
            'methods' => [
                'SetTitle' => 'Surat Perjanjian Kerja - hapindo.co.id',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => false,
                // 'SetHeader' => true,
                'SetFooter' => false,
                'SetAuthor' => 'Haleyora Powerindo',
                'SetCreator' => 'Haleyora Powerindo',
                'SetKeywords' => 'Haleyora, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);
        return $pdf->render();
    }

    /**
     * Displays a single Spkl model.
     * @param string $id
     * @return mixed
     */
    public static function actionGenerateSpklFromApi($id)
    {
        $model = PusharlisLembur::findOne($id);
        $spkl = str_replace("/","-",$id);
        $filename = '/var/www/html/sppdonln/web/files/pusharlis-spkl/'.$spkl.'.pdf';

        if(!file_exists($filename)):
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => Pdf::FORMAT_A4, 
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'filename'=> $filename,
                'marginTop'=>10,
                'marginBottom'=>10,
                'marginLeft'=>2,
                'marginRight'=>2,
                'destination'=>Pdf::DEST_FILE,
                'content' => yii::$app->controller->renderPartial('template-spkl',['id'=>$id, 'model'=>$model]),
                'methods' => [
                    'SetTitle' => 'Surat Perintah Lembur - hapindo.co.id',
                    'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                    'SetHeader' => false,
                    // 'SetHeader' => true,
                    'SetFooter' => false,
                    'SetAuthor' => 'Haleyora Powerindo',
                    'SetCreator' => 'Haleyora Powerindo',
                    'SetKeywords' => 'Haleyora, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
                ]
            ]);
            $pdf->render();
        endif;
        return 'https://sppd.hapindo.co.id/files/pusharlis-spkl/'.$spkl.'.pdf';
    }
}
