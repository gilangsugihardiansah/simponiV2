<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\PusharlisSppd;
use app\models\Pegawai;
use yii\helpers\Json;


class PusharlisRatingController extends Controller
{
    public function actionCreate($id)
    {
        $model = PusharlisSppd::findOne($id);
        if($model->STATUS_PENGAJUAN == "1" OR $model->STATUS_PENGAJUAN == "2"):
            $model->scenario = "rating";

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

                $model->UPDATED_AT = date('Y-m-d H:i:s');

                Yii::$app->session->setFlash('info', "Pengajuan perjalanan dinas dengan nomor ".$model->ID." berhasil dirating.");
                
                if($model->validate()):
                    $model->save();
                    return $this->renderAjax('success');
                else:
                    Yii::$app->session->setFlash('error', "Pengajuan SPPD tidak berhasil dirating : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
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
            Yii::$app->session->setFlash('error', "Pengajuan SPPD tidak bisa dirating, dikarenakan sudah direkomendasi/disetujui oleh atasan!!!");
            return $this->renderAjax('error', [
                'model' => $model,
            ]);
        endif;
    }

}

?>
