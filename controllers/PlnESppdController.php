<?php

namespace app\controllers;

use Yii;
use app\models\Pegawai;
use app\models\PlnESppd;
use app\models\PlnESppdSearch;
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
 * PlnESppdController implements the CRUD actions for PlnESppd model.
 */
class PlnESppdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "12"): 
                $action = ['index','index-app','index-report','view'];
            elseif((Yii::$app->user->identity->JENIS == "13")): 
                $action = ['index','view','update','index-app','update-tolak'];
            elseif((Yii::$app->user->identity->JENIS == "14")): 
                $action = ['index','view','update','index-app','index-report','update-tolak'];
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
                'only' => ['index','view','update','index-app','index-report','update-tolak'],
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
     * Lists all PlnESppd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlnESppdSearch();
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
     * Lists all PlnESppd models.
     * @return mixed
     */
    public function actionIndexApp()
    {
        $searchModel = new PlnESppdSearch();
        if(Yii::$app->user->identity->JENIS == "13"):
            $searchModel->STATUS_PENGAJUAN = "1";
        elseif(Yii::$app->user->identity->JENIS == "14"):
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
     * Lists all PlnESppd models.
     * @return mixed
     */
    public function actionIndexReport()
    {
        $searchModel = new PlnESppdSearch();
        $searchModel->STATUS_PENGAJUAN = "3";
        $dataProvider =$searchModel->searchReport(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize=false;

        if(isset($_POST['excel'])):

            $dateRange = Yii::$app->request->post('PlnESppdSearch')['UPDATED_AT'];
            $arrDate = explode(" - ", $dateRange);
            $dateFirst = $arrDate[0].' 00:00:00';
            $dateLast = $arrDate[1].' 23:59:59';

            $dataChargeCode = PlnESppd::find()->select('CHARGE_CODE,MSB')->andWhere(['STATUS_PENGAJUAN'=>'3'])->andWhere(['>=','UPDATED_AT',$dateFirst])->andWhere(['<=','UPDATED_AT',$dateLast])->groupBy('CHARGE_CODE')->all();

            $dataArray[] = null;
            foreach ($dataChargeCode as $key => $value):
                $dataArray[$key] = ['CHARGE_CODE'=>$value->CHARGE_CODE,'BIDANG'=>$value->bid->NAMA,'data'=>PlnESppd::find()->andWhere(['STATUS_PENGAJUAN'=>'3'])->andWhere(['CHARGE_CODE'=>$value->CHARGE_CODE])->andWhere(['>=','UPDATED_AT',$dateFirst])->andWhere(['<=','UPDATED_AT',$dateLast])->all()];
            endforeach;
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename = rekap-data-sppd.xls");
            header("Pragma: no-canche");
            header("Expires: 0");
            echo $this->renderAjax('template', [
                'dataArray' => $dataArray,
                'dateFirst'=>$dateFirst,
                'dateLast'=>$dateLast
            ]);
            // return $this->renderAjax('template', [
            //     'dataArray' => $dataArray,
            //     'dateFirst'=>$dateFirst,
            //     'dateLast'=>$dateLast
            // ]);
        endif;

        return $this->render('index-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single DataHeaderKontrak model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
        if (isset($_POST['expandRowKey'])) :
            return $this->renderAjax('view', [
                'model' => $this->findModel($_POST['expandRowKey']),
            ]);
        else:
            return '<div class="alert alert-danger">No data found</div>';
        endif;
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
            if($model->JENIS_SPPD === "BIASA" OR $model->JENIS_SPPD === "KONSINYERING"): 
                $model->WILAYAH = $model->WIL_LOKAL;
                $model->TUJUAN = $model->TUJUAN_LOKAL;
            elseif($model->JENIS_SPPD === "INTERNASIONAL"): 
                $model->WILAYAH = $model->WIL_INTER;
                $model->TUJUAN = $model->TUJUAN_INTER;
            endif;

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
            $model->WIL_LOKAL = $model->WILAYAH;
            $model->WIL_INTER = $model->WILAYAH;
            $model->TUJUAN_LOKAL = $model->TUJUAN;
            $model->TUJUAN_INTER = $model->TUJUAN;
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
        $modelLoad = new PlnESppd();
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
        $data = Yii::$app->request->get('data')['params']['PlnESppdSearch'];
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename = rekap-PlnESppd-export.xls");
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
     * Finds the PlnESppd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlnESppd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlnESppd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
