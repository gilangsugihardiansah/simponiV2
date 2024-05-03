<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\PlnESppd;
use app\models\Pegawai;
use app\models\DVal;
use app\models\PlnEChargeCode;
use app\models\PlnERegion;
use app\models\PlnENegara;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;

\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

class PlnEController extends Controller
{
    public function actionIndex()
    {
        $res['value'] = 0;
        $res['message'] = 'request not found!!!';
        return $res;
    }

    private function setUcapan()
    {
        $waktu=gmdate("H:i",time()+7*3600);
        $t=explode(":",$waktu);
        $jam=$t[0];
        
        $ucapan="Error";

        if(intVal($jam) >= 0 AND intVal($jam) < 10): 
            $ucapan="Selamat Pagi";
        elseif(intVal($jam) >= 10 AND intVal($jam) < 15):
            $ucapan="Selamat Siang";
        elseif(intVal($jam) >= 15 AND intVal($jam) < 18):
            $ucapan="Selamat Sore";
        elseif(intVal($jam) >= 18 AND intVal($jam) <= 24):
            $ucapan="Selamat Malam";
        endif;

        return $ucapan;
    }

    private function sendWhatsApp($phone,$nama_pegawai,$id)
    {
        $username  = "AC01ddd230a2f90e85fbad15e8c3922cc2";
        $password  = "264f302af27cbcc20f48da4670b26b4b";
        if(substr($phone,0,1) == "0"):
            $phone = '62'.substr($phone,1,strlen($phone));
        endif;
        $to  = "whatsapp:".$phone;

        // print_r($this->setUcapan());die;
        // $to  = "whatsapp:6285173305229";
        $body = $this->renderAjax('template_wa',['salam'=>$this->setUcapan(),'nama_pegawai'=>$nama_pegawai,'id'=>$id]);
        $params = [
            'To' => $to,
            'From' => 'whatsapp:6281282284088',
            'MessagingServiceSid' => 'MGb77a2c7d30bed0a0d7c50f1e4e3fba6a',
            'Body'=>  $body,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/AC01ddd230a2f90e85fbad15e8c3922cc2/Messages.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_USERPWD => $username . ":" . $password,
            CURLOPT_POSTFIELDS =>http_build_query($params),
            CURLOPT_HTTPHEADER => [
            'Authorization: Basic QUMwMWRkZDIzMGEyZjkwZTg1ZmJhZDE1ZThjMzkyMmNjMjoyNjRmMzAyYWYyN2NiY2MyMGY0OGRhNDY3MGIyNmI0Yg==',
            'Content-Type: application/x-www-form-urlencoded'
            ],
        ]);
        
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if($response->status == "accepted"):
            return true;
        else:
            return false;
        endif;
    }

    public function actionSppd()
    {
        $request = Yii::$app->request;

        if($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if( isset($bodys['nip']) AND isset($bodys['tgl_berangkat']) AND isset($bodys['tgl_kembali']) AND isset($bodys['jenis_sppd'])  AND isset($bodys['is_lumpsum']) AND isset($bodys['asal']) AND isset($bodys['tujuan']) AND isset($bodys['instansi_tujuan']) AND isset($bodys['uraian_tugas']) AND isset($bodys['id_charge_code']) AND isset($_FILES['evidence']['tmp_name']) ):
                $modelPeg = Pegawai::findOne($bodys['nip']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "PLN E"):
                    $model = new PlnESppd();
                    $model->setAttributes($modelPeg->getAttributes(), false);
                    $model->ID = $model->id;
                    $model->NO_SPK = $modelPeg->spkku->NO_SPK;
                    $model->JABATAN = $modelPeg->spkku->JABATAN;
                    $model->PEKERJAAN = $modelPeg->spkku->PEKERJAAN;
                    $model->PENEMPATAN = $modelPeg->PENEMPATAN;
                    $model->TGL_BERANGKAT = $bodys['tgl_berangkat'];
                    $model->TGL_KEMBALI = $bodys['tgl_kembali'];
                    $model->JENIS_SPPD = $bodys['jenis_sppd'];
                    $model->IS_LUMPSUM = $bodys['is_lumpsum'];
                    $model->WILAYAH = isset($bodys['wilayah']) ? $bodys['wilayah'] : null;
                    $model->ASAL = $bodys['asal'];
                    $model->TUJUAN = $bodys['tujuan'];
                    $model->INSTANSI_TUJUAN = $bodys['instansi_tujuan'];
                    $model->JENIS_TRANPORTASI = isset($bodys['jenis_tranportasi']) ? $bodys['jenis_tranportasi'] : null;
                    $model->URAIAN_TUGAS = $bodys['uraian_tugas'];
                    $model->ID_CHARGE_CODE = $bodys['id_charge_code'];
                    $model->CHARGE_CODE = $model->cc->CHARGE_CODE;
                    $model->VP = $model->cc->ID_VP;
                    $model->MSB = $model->cc->ID_MSB;
                    $model->STATUS_PENGAJUAN = '1';
                    $model->CREATED_AT = date('Y-m-d h:i:s');
                    $model->UPDATED_AT = date('Y-m-d h:i:s');
                    $model->validate();
                    //file evidence
                    $periode = substr($model->TGL_BERANGKAT,0,7);
                    $filename = 'files/pln-e-sppd/'.$periode.'/'.str_replace('/','-',$model->ID).'.jpg';
                    $model->EVIDENCE = 'https://sppd.hapindo.co.id/'.$filename;

                    $this->sendWhatsApp($model->noWa->VALUE,$modelPeg->NAMA,$model->ID);

                    if($model->save()):
                        $this->sendWhatsApp($model->noWa->VALUE,$modelPeg->NAMA,$model->ID);

                        if (!file_exists('/var/www/html/sppdonln/web/files/pln-e-sppd/'.$periode.'/')) :
                            mkdir('/var/www/html/sppdonln/web/files/pln-e-sppd/'.$periode.'/', 0777, true);
                        endif;

                        move_uploaded_file($_FILES['evidence']['tmp_name'],'../web/'.$filename);
                        $res['value'] = 1;
                        $res['message'] = 'sukses';
                        $res['data'] = null;
                        return $res;
                    else:
                        Yii::$app->response->statusCode = 400;
                        $res['value'] = 0;
                        $res['message'] = $model->getErrors();
                        return $res;
                    endif;
                else:
                    Yii::$app->response->statusCode = 400;
                    $res['value'] = 1;
                    $res['message'] = 'Data pegawai tidak ditemukan';
                    return $res;
                endif;
            else:
                Yii::$app->response->statusCode = 400;
                $res['value'] = 0;
                $res['message'] = 'Error request body';
                return $res;
            endif;
        elseif($request->isGet):
            $params = $request->get();

            if(isset($params['nip'])):
                $modelPeg = Pegawai::findOne($params['nip']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "PLN E"):
                    if(isset($params['date'])):
                        $model = PlnESppd::find()->andWhere(['NO_INDUK'=>$params['nip']])->andWhere('CREATED_AT LIKE "'.$params['date'].'%"')->all();
                    else:
                        $model = PlnESppd::find()->andWhere(['NO_INDUK'=>$params['nip']])->all();
                    endif;
                    foreach ($model as $key => $value):
                        $value->STATUS_PENGAJUAN = $value->status->VALUE;
                        $value->MSB = $value->bid->NAMA.' - '.$value->us->NAMA;
                    endforeach;
                    $res['value'] = 1;
                    $res['message'] = 'sukses';
                    $res['data'] = $model;
                    return $res;
                else: 
                    Yii::$app->response->statusCode = 400;
                    $res['value'] = 1;
                    $res['message'] = 'Data Pegawai tidak ditemukan';
                    return $res;
                endif;
            else:
                Yii::$app->response->statusCode = 400;
                $res['value'] = 0;
                $res['message'] = 'Error request params';
                return $res;
            endif;
            Yii::$app->response->statusCode = 400;
            return $res;
        else:
            Yii::$app->response->statusCode = 405;
            $res['value'] = 0;
            $res['message'] = 'Error request method';
            return $res;
        endif;
    }

    public function actionChargeCode()
    {
        $request = Yii::$app->request;

        if($request->isGet):
            
            $model = PlnEChargeCode::find()->all();
            $count = 0;
            $res['value'] = 1;
            $res['message'] = 'sukses';
            $res['total'] = $count;
            foreach ($model as $key => $value):
                $res['data'][$key]['ID'] = $value->ID;
                $res['data'][$key]['CHARGE_CODE'] = $value->CHARGE_CODE;
                $res['data'][$key]['NAMA_PEKERJAAN'] = $value->NAMA_PEKERJAAN;
                $res['data'][$key]['VP'] = $value->vp->NAMA;
                $res['data'][$key]['MSB'] = $value->msb->NAMA;
                $count++;
            endforeach;
            $res['total'] = $count;
            return $res;
        elseif($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if(isset($bodys['id'])):
                $model = PlnEChargeCode::find()->andWhere(['ID'=>$bodys['id']])->all();
                $res = $model;
                return $res;
            else:
                Yii::$app->response->statusCode = 400;
                $res['value'] = 0;
                $res['message'] = 'Error request body';
                return $res;
            endif;
        else:
            Yii::$app->response->statusCode = 405;
            $res['value'] = 0; 
            $res['message'] = 'Error request method';
            return $res;
        endif;
    }

    public function actionRegion()
    {
        $request = Yii::$app->request;

        if($request->isGet):
            
            $model = PlnERegion::find()->all();
            $count = 0;
            $res['value'] = 1;
            $res['message'] = 'sukses';
            $res['total'] = $count;
            foreach ($model as $key => $value):
                $res['data'][$key]['ID'] = $value->ID;
                $res['data'][$key]['REGION'] = $value->REGION;
                $count++;
            endforeach;
            $res['total'] = $count;
            return $res;
        else:
            Yii::$app->response->statusCode = 405;
            $res['value'] = 0; 
            $res['message'] = 'Error request method';
            return $res;
        endif;
    }

    public function actionCountry()
    {
        $request = Yii::$app->request;

        if($request->isGet):
            
            $model = PlnENegara::find()->all();
            $count = 0;
            $res['value'] = 1;
            $res['message'] = 'sukses';
            $res['total'] = $count;
            foreach ($model as $key => $value):
                $res['data'][$key]['ID'] = $value->ID;
                $res['data'][$key]['REGION'] = $value->reg->REGION;
                $res['data'][$key]['COUNTRY'] = $value->NEGARA;
                $count++;
            endforeach;
            $res['total'] = $count;
            return $res;
        else:
            Yii::$app->response->statusCode = 405;
            $res['value'] = 0; 
            $res['message'] = 'Error request method';
            return $res;
        endif;
    }

}

?>
