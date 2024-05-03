<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\Sppd;
use app\models\Pegawai;
use yii\helpers\Json;


class RatingController extends Controller
{
    public function actionCreate($id)
    {
        $model = Sppd::findOne($id);
        if($model->STATUS_PENGAJUAN == "Pengajuan"):
            $model->scenario = "rating";

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

                $model->STATUS_PENGAJUAN = "Dikonfirmasi";
                $model->TGL_APPROVAL = date('Y-m-d H:i:s');
                $model->UPDATE_AT = date('Y-m-d H:i:s');

                Yii::$app->session->setFlash('info', "Pengajuan perjalanan dinas dengan nomor ".$model->ID." berhasil di konfirmasi.");
                
                if($model->validate()):
                    $model->save();
                    return $this->renderAjax('success');
                else:
                    Yii::$app->session->setFlash('error', "Pengajuan SPPD tidak berhasil di konfirmasi : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                    return $this->renderAjax('_form-app', [
                        'model' => $model,
                    ]);
                endif;
            else:
                return $this->renderAjax('_form-app', [
                    'model' => $model,
                ]);
            endif;
        else: 
            return $this->renderAjax('error', [
                'model' => $model,
            ]);
        endif;
    }

}

?>
