<?php

namespace app\controllers;

use Yii;
use app\models\Pegawai;
use app\models\Lembur;
use app\models\LemburSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

/**
 * LemburController implements the CRUD actions for Lembur model.
 */
class LemburController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->COMPANY == "HP"): 
                $action = ['index','update','index-app','generate-spkl'];
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
                'only' => ['index','update','index-app'],
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
     * Lists all Lembur models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LemburSearch();
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
     * Lists all Lembur models.
     * @return mixed
     */
    public function actionIndexApp()
    {
        $searchModel = new LemburSearch();
        $searchModel->STATUS_PENGAJUAN = "Pengajuan";
        $searchModel->APP = "APP";
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) :
            
            //jumlah hari
            $dt1 = new \DateTime($model->TGL_BERANGKAT);
            $dt2 = new \DateTime($model->TGL_KEMBALI);
            $interval = $dt1->diff($dt2);
            $hari = $interval->d + 1;
            $malam = $interval->d;
            $model->JUMLAH_HARI = $hari.' hari '.$malam.' malam';
            //nominal
            $akomodasi = $model->tarif->tarifNominal->TARIF_AKOMODASI??0;
            $menginap = $model->tarif->tarifNominal->TARIF_MENGINAP??0;
            $model->TOTAL = $akomodasi + ($menginap * $malam);

            if($model->validate()):
                $model->save();
                Yii::$app->session->setFlash('info', "Perubahan data perjalanan dinas dengan nomor ".$model->ID." berhasil.");
                return $this->redirect(['index-app']);
            else:
                Yii::$app->session->setFlash('error', "Pengajuan Lembur tidak berhasil di konfirmasi : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->render('_form', [
                    'model' => $model,
                ]);
            endif;
        else:
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
    public function actionUpdateApp($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) :
            
            // $model->JAM_AWAL_LEMBUR = $model->JAM_AWAL_LEMBUR.' - '.$model->JAM_AKHIR_LEMBUR;
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

            $model->TANGGAL_APPROVAL = date('Y-m-d H:i:s');
            $model->UPDATED_AT = date('Y-m-d H:i:s');
            if($model->validate()):
                $model->save();
                Yii::$app->session->setFlash('info', "Approved pengajuan lembur berhasil.");
                return $this->redirect(['index-app']);
            else:
                Yii::$app->session->setFlash('error', "Approved pengajuan lembur tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->render('_form', [
                    'model' => $model,
                ]);
            endif;
        endif;

        $model->JAM_AWAL_LEMBUR = $model->JAM_AWAL_LEMBUR.' - '.$model->JAM_AKHIR_LEMBUR;
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
        $model->STATUS_PENGAJUAN = 'Ditolak';
        $model->UPDATED_AT = date('Y-m-d H:i:s');
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
     * Finds the Lembur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Lembur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lembur::findOne($id)) !== null) {
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
        $model = Lembur::findOne($id);
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
        $model = Lembur::findOne($id);
        $spkl = str_replace("/","-",$id);
        $filename = '/var/www/html/sppdonln/web/files/spkl/'.$spkl.'.pdf';

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
        return 'https://sppd.hapindo.co.id/files/spkl/'.$spkl.'.pdf';
    }
}
