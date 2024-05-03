<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\DVal;
use app\models\AstroReimburse;
use app\models\Pegawai;
use app\models\ChangePassword;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;

\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

class AstroController extends Controller
{
    public function actionIndex()
    {
        $res['value'] = 0;
        $res['message'] = 'request not found!!!';
        return $res;
    }

    public function actionReimburse()
    {
        $request = Yii::$app->request;

        if($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if( isset($bodys['nip']) AND isset($bodys['keterangan']) AND isset($bodys['tgl_service']) AND isset($bodys['no_pol']) AND isset($bodys['nominal']) ):
                $modelPeg = Pegawai::findOne($bodys['nip']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "ASTRO"):
                    if($modelPeg->STATUS_PEGAWAI == "FULL TIME"):
                        $model = new AstroReimburse();
                        $model->setAttributes($modelPeg->getAttributes(), false);
                        $model->ID = mt_rand(1000000, 9999999).'-'.uniqid('reim_', true).'-'.mt_rand(10000, 99999);
                        $model->NO_SPK = $modelPeg->spkku->NO_SPK;
                        $model->JABATAN = $modelPeg->spkku->JABATAN;
                        $model->PEKERJAAN = $modelPeg->spkku->PEKERJAAN;
                        $model->PENEMPATAN = $modelPeg->PENEMPATAN;
                        $model->KETERANGAN = $bodys['keterangan'];
                        $model->TGL_SERVICE = $bodys['tgl_service'];
                        $model->NO_POL = $bodys['no_pol'];
                        $model->NOMINAL = $bodys['nominal'];
                        $model->CREATED_AT = date('Y-m-d h:i:s');
                        $model->UPDATED_AT = date('Y-m-d h:i:s');
                        $model->STATUS_PENGAJUAN = '0';

                        $periode = substr($model->CREATED_AT,0,7);
                        $filename = 'files/astro/reimburse/'.$periode.'/'.str_replace('/','-',$model->ID).'.jpg';
                        $model->EVIDENCE = 'https://sppd.hapindo.co.id/'.$filename;

                        if($model->validate() && $model->save()):

                            if (!file_exists('/var/www/html/sppdonln/web/files/astro/reimburse/'.$periode.'/')) :
                                mkdir('/var/www/html/sppdonln/web/files/astro/reimburse/'.$periode.'/', 0777, true);
                            endif;

                            move_uploaded_file($_FILES['evidence']['tmp_name'],'../web/'.$filename);
                            $res['value'] = 1;
                            $res['message'] = 'sukses';
                            $res['data'] = null;
                            return $res;
                        else:
                            $res['value'] = 0;
                            $res['message'] = $model->getErrors();
                            return $res;
                        endif;
                    else:
                        Yii::$app->response->statusCode = 400;
                        $res['value'] = 0;
                        $res['message'] = 'Maaf, Anda belum bisa melakukan reimburse';
                        return $res;
                    endif;
                else:
                    Yii::$app->response->statusCode = 400;
                    $res['value'] = 0;
                    $res['message'] = 'Data pegawai tidak ditemukan';
                    return $res;
                endif;
            else:
                $res['value'] = 0;
                $res['message'] = 'Error request body';
                return $res;
            endif;
        elseif($request->isGet):
            $params = $request->get();

            if(isset($params['nip']) AND isset($params['date'])):
                $modelPeg = Pegawai::findOne($params['nip']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "ASTRO" AND $modelPeg->STATUS_PEGAWAI == "FULL TIME"):
                    $model = AstroReimburse::find()->andWhere(['NO_INDUK'=>$params['nip']])->andWhere('CREATED_AT LIKE "'.$params['date'].'%"')->all();
                    $res['value'] = 1;
                    $res['message'] = 'sukses';
                    $res['data'] = $model;
                    return $res;
                else: 
                    $res['value'] = 1;
                    $res['message'] = 'Data Pegawai tidak ditemukan';
                    return $res;
                endif;
            else:
                $res['value'] = 0;
                $res['message'] = 'Error request params';
                return $res;
            endif;
            Yii::$app->response->statusCode = 203;
            return $res;
        else:
            $res['value'] = 0;
            $res['message'] = 'Error request method';
            return $res;
        endif;
    }

    public function actionDynamicVal()
    {
        $request = Yii::$app->request;

        if($request->isGet):
            
            $model = DVal::find()->all();
            $count = 0;
            $res['value'] = 1;
            $res['message'] = 'sukses';
            $res['total'] = $count;
            foreach ($model as $key => $value):
                $res['data'][$key]['id'] = $value->ID;
                $res['data'][$key]['key'] = $value->KEY;
                $res['data'][$key]['value'] = $value->VALUE;
                $res['data'][$key]['decription'] = $value->DESCRIPTION;
                $count++;
            endforeach;
            $res['total'] = $count;
            return $res;
        elseif($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if(isset($bodys['key']) ):
                $model = DVal::find()->andWhere(['KEY'=>$bodys['key']])->one();
                $res = $model;
                return $res;
            else:
                $res['value'] = 0;
                $res['message'] = 'Error request body';
                return $res;
            endif;
        else:
            $res['value'] = 0; 
            $res['message'] = 'Error request method';
            return $res;
        endif;
    }

}

?>
