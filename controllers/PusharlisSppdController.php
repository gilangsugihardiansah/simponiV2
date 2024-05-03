<?php

namespace app\controllers;

use Yii;
use app\models\Pegawai;
use app\models\PusharlisSppd;
use app\models\PusharlisSppdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xls;

/**
 * PusharlisSppdController implements the CRUD actions for PusharlisSppd model.
 */
class PusharlisSppdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "4"): 
                $action = ['index','update','index-app','update','index-report','print-to-excel','print-to-pdf'];
            elseif((Yii::$app->user->identity->JENIS == "10" || Yii::$app->user->identity->JENIS == "11")): 
                $action = ['index','update','index-app','update-tolak'];
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
                'only' => ['index','update','index-app','index-report','update','print-to-excel','print-to-pdf','update-tolak'],
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
     * Lists all PusharlisSppd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PusharlisSppdSearch();
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
     * Lists all PusharlisSppd models.
     * @return mixed
     */
    public function actionIndexApp()
    {
        $searchModel = new PusharlisSppdSearch();
        if(Yii::$app->user->identity->JENIS == "11"):
            $searchModel->STATUS_PENGAJUAN = "1";
        elseif(Yii::$app->user->identity->JENIS == "10"):
            $searchModel->STATUS_PENGAJUAN = "2";
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
     * Lists all PusharlisSppd models.
     * @return mixed
     */
    public function actionIndexReport()
    {
        $model=new PusharlisSppd();
        $searchModel = new PusharlisSppdSearch();
        $tglAwal = date('Y-m-01');
        $tglAkhir = date('Y-m-t');
        $searchModel->CREATED_AT = $tglAwal.' - '.$tglAkhir;
        $searchModel->PERIODE=date('Y-m');
        $searchModel->PENEMPATAN = 'PT PLN (PERSERO) UNIT INDUK DISTRIBUSI JAWA TENGAH DAN D.I YOGYAKARTA';
        $dataProvider =$searchModel->searchRekap(Yii::$app->request->queryParams);
            
        if(isset($_POST['excel'])):
            $searchModel->load(Yii::$app->request->post());
            $searchModel->penagihan=false;
            $dataProvider =$searchModel->searchRekap(Yii::$app->request->queryParams);
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename = rekap-PusharlisSppd-export.xls");
            echo $this->renderAjax('template', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tglAwal'=>$tglAwal,
                'tglAkhir'=>$tglAkhir
            ]);
        elseif(isset($_POST['pdf'])):
            $searchModel->load(Yii::$app->request->post());
            $searchModel->penagihan=false;
            $dataProvider =$searchModel->searchRekap(Yii::$app->request->queryParams);
            return $this->actionPrint($searchModel,$dataProvider,$tglAwal,$tglAkhir);
        elseif(isset($_POST['excel-penagihan'])):
            $searchModel->load(Yii::$app->request->post());
            $arr=['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
            $bulan=((int) substr($searchModel->PERIODE,5,2)-1);
            $bulan= $arr[$bulan];
            $tgl=$bulan.' '.substr($searchModel->PERIODE,0,4);
            $searchModel->CREATED_AT==null;
            $searchModel->penagihan=true;
            $dataProvider =$searchModel->searchRekap(Yii::$app->request->queryParams);
            $searchModelDetail= new PusharlisSppdDetailSearch();
            $searchModelDetail->TGL=$searchModel->PERIODE;
            $searchModelDetail->PENEMPATAN=$searchModel->PENEMPATAN;
            $dataProviderDetail = $searchModelDetail->search(Yii::$app->request->queryParams);

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename = rekap-penagihan-export.xls");
            echo $this->renderAjax('template-penagihan', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tgl' => $tgl,
                'searchModelDetail' => $searchModelDetail,
                'dataProviderDetail' => $dataProviderDetail,
            ]);
            elseif(isset($_POST['excel-perorang'])):
                $searchModel->load(Yii::$app->request->post());
                $arr=['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
                $bulan=((int) substr($searchModel->PERIODE,5,2)-1);
                $bulan= $arr[$bulan];
                $tgl=$bulan.' '.substr($searchModel->PERIODE,0,4);
                $searchModel->CREATED_AT==null;
                $searchModel->penagihan=true;
                $dataProvider =$searchModel->searchRekap(Yii::$app->request->queryParams);
                $searchModelDetail= new PusharlisSppdDetailSearch();
                $searchModelDetail->TGL=$searchModel->PERIODE;
                $searchModelDetail->PENEMPATAN=$searchModel->PENEMPATAN;
                $dataProviderDetail = $searchModelDetail->search(Yii::$app->request->queryParams);

                $ch = curl_init();

                $headers  = [
                    'Content-Type: application/json'
                ];

                $content = [
                    'PENEMPATAN'=>$searchModel->PENEMPATAN,
                    'TGL'=>$searchModel->PERIODE,
                ];

                curl_setopt($ch, CURLOPT_URL, '192.168.101.29:33829/detail');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json::encode($content));

                $result = curl_exec($ch);
                echo $result;
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
    
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename = rekap-penagihan-detail-export.xls");

                echo $this->renderAjax('template-detail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'tgl' => $tgl,
                ]);
        endif;

        return $this->render('index-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tglAwal'=>$tglAwal,
            'tglAkhir'=>$tglAkhir
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
            
            //jumlah hari
            $dt1 = new \DateTime($model->TGL_BERANGKAT);
            $dt2 = new \DateTime($model->TGL_KEMBALI);
            $interval = $dt1->diff($dt2);
            $hari = $interval->d + 1;
            $malam = $interval->d;
            $malam = $model->STATUS_SPPD == "Pengajuan Lanjut" ? ($malam + 1) : $malam;
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
                Yii::$app->session->setFlash('error', "Perubahan data perjalanan dinas tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->render('_form', [
                    'model' => $model,
                ]);
            endif;
        else:
            $model->STATUS_PENGAJUAN = $key;
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
        $modelLoad = new PusharlisSppd();
        if ($modelLoad->load(Yii::$app->request->post()) ) :
            $model = $this->findModel($modelLoad->ID);
            $model->ALASAN = $modelLoad->ALASAN;
            $model->STATUS_PENGAJUAN = '4';
            $model->UPDATED_AT = date('Y-m-d H:i:s');
            if($model->validate()):
                $model->save(false);
                Yii::$app->session->setFlash('info', "Pengajuan perjalanan dinas berhasil ditolak.");
                return $this->redirect(['index']);
            else:
                Yii::$app->session->setFlash('error', "Pengajuan perjalanan dinas tidak berhasil ditolak : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                return $this->redirect(['index']);
            endif;
        endif;
    }

    /**
     * Creates a new Akademis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPrintToExcel()
    {
        $data = Yii::$app->request->get('data')['params']['PusharlisSppdSearch'];
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename = rekap-PusharlisSppd-export.xls");
        return $this->renderAjax('template', [
            'searchModel' => $data['searchModel'],
            'dataProvider' => $data['dataProvider'],
            'tglAwal'=>$data['tglAwal'],
            'tglAkhir'=>$data['tglAkhir']
        ]);
    }


    /**
     * Lists all Payroll models.
     * @return mixed
     */
    public function actionPrint($searchModel,$dataProvider,$tglAwal,$tglAkhir)
    {
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_LEGAL, 
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename'=>'Rekapitulasi Perjalanan Dinas '.$searchModel->PENEMPATAN,
            'marginTop'=>20,
            'marginLeft'=>15,
            'content' => $this->renderPartial('template',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tglAwal'=>$tglAwal,
                'tglAkhir'=>$tglAkhir
            ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'methods' => [
                'SetTitle' => 'Rekapitulasi Perjalanan Dinas '.$searchModel->PENEMPATAN.' - hapindo.co.id',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['PT. Haleyora Powerindo'],
                'SetWatermarkText'=>['DRAFT'],
                'SetFooter' => ['<strong>Copyright &copy; <a href="http://www.hapindo.co.id/index.php">PT. Haleyora Powerindo</a>.</strong> All rights reserved.'],
                'SetAuthor' => 'Haleyora Powerindo',
                'SetCreator' => 'Haleyora Powerindo',
                'SetKeywords' => 'Haleyora, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);
        // print_r($pdf->render());die;
        return $pdf->render();
        // print_r($dataProvider->getCount());die;
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Admin::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('info', "Data berhasil dihapus.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the PusharlisSppd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PusharlisSppd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PusharlisSppd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
