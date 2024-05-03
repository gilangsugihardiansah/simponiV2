<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\PlnESppd;
use app\models\Pegawai;
use yii\helpers\Json;


class PusharlisRatingController extends Controller
{
    public function actionCreate($id)
    {
        $model = PlnESppd::findOne($id);
        if($model->STATUS_PENGAJUAN == "1" OR $model->STATUS_PENGAJUAN == "2"):
            $model->scenario = "rating";

            if ($model->load(Yii::$app->request->post()) ) :
                if($model->validate()):
                    Yii::$app->session->setFlash('info', "Pengajuan perjalanan dinas dengan nomor ".$model->ID." berhasil dirating.");
                    $model->save();
                    return $this->renderAjax('success');
                else:
                    Yii::$app->session->setFlash('error', "Pengajuan SPPD tidak berhasil dirating : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
                    return $this->renderAjax('_form-app', [
                        'model' => $model,
                    ]);
                endif;
            else:
                $model->WIL_LOKAL = $model->WILAYAH;
                $model->WIL_INTER = $model->WILAYAH;
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
