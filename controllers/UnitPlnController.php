<?php

namespace app\controllers;

use Yii;
use app\models\UnitPlnSearch;
use app\models\Pegawai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * UnitPlnController implements the CRUD actions for UnitPln model.
 */
class UnitPlnController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6"):
                $action = ['index','get-unit'];
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
                'only' => ['index','get-unit'],
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
     * Lists all UnitPln models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitPlnSearch();
        $dataProvider =$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KsoJabatanBaru model.
     * @param string $id
     * @return mixed
     */
    public function actionGetUnit($id)
    {
        $modelcount = Pegawai::find()
        ->select('pegawai.PENEMPATAN')
        ->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')
        ->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND data_spk.APP = "'.$id.'"')
        ->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])
        ->groupBy('dbsimponi.pegawai.PENEMPATAN')
        ->count();
        $model = Pegawai::find()
        ->select('pegawai.PENEMPATAN')
        ->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')
        ->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND data_spk.APP = "'.$id.'"')
        ->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])
        ->groupBy('dbsimponi.pegawai.PENEMPATAN')->all();
        //print_r($model);die;
        if($modelcount > 0 ):
            foreach ($model as $value):
                echo "<option value='".$value->PENEMPATAN."' >".$value->PENEMPATAN."</option>";
            endforeach;
        else:
            echo "<option value='' >Pilih</option>";
        endif;
    }
}
