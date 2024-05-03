<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\Sppd;
use app\models\Pegawai;
use app\models\Spk;
use app\controllers\LemburController;
use app\models\Lembur;
use app\models\ChangePassword;
use app\models\DVal;
use app\models\MasterKabupaten;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;

\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

class V1Controller extends Controller
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

            if( isset($bodys['nip']) AND isset($bodys['tgl_berangkat']) AND isset($bodys['tgl_kembali']) AND isset($bodys['kota_asal']) AND isset($bodys['kota_tujuan']) AND isset($bodys['instansi_tujuan']) AND isset($bodys['uraian_tugas']) AND isset($bodys['nama_atasan_pln']) AND isset($bodys['no_wa_atasan_pln']) ):
                $modelPeg = Pegawai::findOne($bodys['nip']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "JATENG"):
                    $model = new Sppd();
                    $model->setAttributes($modelPeg->getAttributes(), false);
                    $model->TGL_APPROVAL = null;
                    $model->ID = $model->id;
                    $model->NO_SPK = $modelPeg->spkku->NO_SPK;
                    $model->JABATAN = $modelPeg->spkku->JABATAN;
                    $model->PEKERJAAN = $modelPeg->spkku->PEKERJAAN;
                    $model->PENEMPATAN = $modelPeg->PENEMPATAN;
                    $model->TGL_BERANGKAT = $bodys['tgl_berangkat'];
                    $model->TGL_KEMBALI = $bodys['tgl_kembali'];
                    $model->KOTA_ASAL = $bodys['kota_asal'];
                    $model->KOTA_TUJUAN = $bodys['kota_tujuan'];
                    $model->INSTANSI_TUJUAN = $bodys['instansi_tujuan'];
                    $model->URAIAN_TUGAS = $bodys['uraian_tugas'];
                    $model->NAMA_ATASAN_PLN = $bodys['nama_atasan_pln'];
                    $model->NO_WA_ATASAN_PLN = $bodys['no_wa_atasan_pln'];
                    $model->TARIF_SPPD = strVal($model->tarif->ID_TARIF);
                    $model->STATUS_PENGAJUAN = 'Pengajuan';
                    $model->TGL_PENGAJUAN = date('Y-m-d h:i:s');
                    $model->UPDATE_AT = date('Y-m-d h:i:s');
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
                    //file evidence
                    $periode = substr($model->TGL_BERANGKAT,0,7);
                    $filename = 'files/sppd/'.$periode.'/'.str_replace('/','-',$model->ID).'.jpg';
                    $model->EVIDENCE = 'https://sppd.hapindo.co.id/'.$filename;

                    if($model->validate() && $model->save()):

                        $this->sendWhatsApp($model->NO_WA_ATASAN_PLN,$modelPeg->NAMA,$model->ID);

                        if (!file_exists('/var/www/html/sppdonln/web/files/sppd/'.$periode.'/')) :
                            mkdir('/var/www/html/sppdonln/web/files/sppd/'.$periode.'/', 0777, true);
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

            if(isset($params['nip']) AND isset($params['date'])):
                $modelPeg = Pegawai::findOne($params['nip']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "JATENG"):
                    $model = Sppd::find()->andWhere(['NO_INDUK'=>$params['nip']])->andWhere('TGL_PENGAJUAN LIKE "'.$params['date'].'%"')->all();
                    foreach ($model as $key => $value):
                        $value->STATUS_PENGAJUAN = ($value->STATUS_PENGAJUAN == "Rekomendasi") ?  "Konfirmasi" : $value->STATUS_PENGAJUAN;
                        $value->STATUS_PENGAJUAN = ($value->TGL_BAYAR !== null AND !empty($value->TGL_BAYAR)) ?  "Dibayarkan" : $value->STATUS_PENGAJUAN;
                    endforeach;
                    Yii::$app->response->statusCode = 200;
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
    public function actionLembur()
    {
        $request = Yii::$app->request;

        if($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if( isset($bodys['NO_INDUK']) AND isset($bodys['JAM_AWAL_LEMBUR']) AND isset($bodys['JAM_AKHIR_LEMBUR']) AND isset($bodys['JENIS_LEMBUR']) AND isset($bodys['PEKERJAAN_LEMBUR'])  AND isset($bodys['LATITUDE']) AND isset($bodys['LONGITUDE']) AND isset($bodys['URAIAN_TUGAS_LEMBUR']) ):
                $modelPeg = Pegawai::findOne($bodys['NO_INDUK']);
                if(isset($modelPeg->NO_INDUK)):
                    $model = new Lembur();
                    $model->setAttributes($modelPeg->getAttributes(), false);
                    $model->ID = $model->id;
                    $model->USER = $modelPeg->USER;
                    $model->NO_SPK = $modelPeg->spkku->NO_SPK;
                    $model->ID_UNIT = $modelPeg->spkku->ID_UNIT;
                    $model->UNIT_PLN = $modelPeg->spkku->UNIT_PLN;
                    $model->JABATAN = $modelPeg->spkku->JABATAN;
                    $model->JENIS_LEMBUR = $bodys['JENIS_LEMBUR'];
                    $model->PEKERJAAN_LEMBUR = $bodys['PEKERJAAN_LEMBUR'];
                    $model->ALAMAT = isset($bodys['ALAMAT'])?$bodys['ALAMAT']:null;
                    $model->LATITUDE = $bodys['LATITUDE'];
                    $model->LONGITUDE = $bodys['LONGITUDE'];
                    $model->URAIAN_TUGAS_LEMBUR = $bodys['URAIAN_TUGAS_LEMBUR'];
                    $model->JAM_AWAL_LEMBUR = $bodys['JAM_AWAL_LEMBUR'];
                    $model->JAM_AKHIR_LEMBUR = $bodys['JAM_AKHIR_LEMBUR'];
                    $model->JUMLAH_JAM = $model->jumker;
                    if($model->JENIS_LEMBUR == "Hari Kerja" AND $model->JUMLAH_JAM > 4):
                        $model->JUMLAH_JAM = 4;
                    endif;
                    $model->UPAH_PENGKALI = ($modelPeg->spkku->UPAH_POKOK);
                    $model->TOTAL_UPAH_LEMBUR = 0;
                    if($model->JENIS_LEMBUR == "Hari Kerja"):
                        $model->TOTAL_UPAH_LEMBUR = $model->lemKer;
                    elseif($model->JENIS_LEMBUR == "Hari Libur"):
                        $model->TOTAL_UPAH_LEMBUR = $model->lemLibNam;
                    elseif($model->JENIS_LEMBUR == "Hari Libur Nasional"):
                        $model->TOTAL_UPAH_LEMBUR = $model->lemLibNasNam;
                    endif;


                    $model->CREATED_AT = date('Y-m-d H:i:s');
                    $model->UPDATED_AT = date('Y-m-d H:i:s');
                    $model->STATUS_PENGAJUAN = 'Pengajuan';
                    $model->USER_APP = $model->atasan;
                    $model->EVIDENCE_LEMBUR = null;

                    if(isset($_FILES['EVIDENCE_LEMBUR']['tmp_name'])):
                        $periode = substr($model->CREATED_AT,0,7);
                        $filename = 'files/lembur/'.$periode.'/'.str_replace('/','-',$model->ID).'-EL.jpg';
                        $model->EVIDENCE_LEMBUR = 'https://sppd.hapindo.co.id/'.$filename;
                    endif;

                    if($model->save()):

                        if(isset($_FILES['EVIDENCE_LEMBUR']['tmp_name'])):
                            if (!file_exists('/var/www/html/sppdonln/web/files/lembur/'.$periode.'/')) :
                                mkdir('/var/www/html/sppdonln/web/files/lembur/'.$periode.'/', 0777, true);
                            endif;
                            move_uploaded_file($_FILES['EVIDENCE_LEMBUR']['tmp_name'],'../web/'.$filename);
                        endif;

                        $res['value'] = 1;
                        $res['message'] = 'sukses';
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
                    $res['data'] = [];
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

            if(isset($params['NO_INDUK'])):
                $modelPeg = Pegawai::findOne($params['NO_INDUK']);
                if(isset($modelPeg->NO_INDUK) AND $modelPeg->spkku->APP == "HP"):

                    $limit = !isset($params['LIMIT']) ? 1 : (intval($params['LIMIT']) < 0 ? 1 : $params['LIMIT']);
                    $offset = !isset($params['OFFSET']) ? 0 : (intval($params['OFFSET']) < 0 ? 0 : $params['OFFSET']);

                    if(isset($params['FIRST_DATE']) AND isset($params['LAST_DATE']) AND $params['FIRST_DATE'] != "" AND $params['LAST_DATE'] != "" ):

                        $fisrtDate = $params['FIRST_DATE'].' 00:00:00';
                        $lastDate = $params['LAST_DATE'].' 23:59:59';

                        $modelCount = Lembur::find()->andWhere(['NO_INDUK'=>$modelPeg->NO_INDUK])->andWhere(['>=','CREATED_AT',$fisrtDate])->andWhere(['<=','CREATED_AT',$lastDate])->count();
                        $model = Lembur::find()->andWhere(['NO_INDUK'=>$modelPeg->NO_INDUK])->andWhere(['>=','CREATED_AT',$fisrtDate])->andWhere(['<=','CREATED_AT',$lastDate])->limit($limit)->offset($offset)->orderBy(['CREATED_AT'=>SORT_DESC])->all();
                    else:
                        $modelCount = Lembur::find()->andWhere(['NO_INDUK'=>$modelPeg->NO_INDUK])->count();
                        $model = Lembur::find()->andWhere(['NO_INDUK'=>$modelPeg->NO_INDUK])->limit($limit)->offset($offset)->orderBy(['CREATED_AT'=>SORT_DESC])->all();
                    endif;
                    if(isset($model[0]) AND !empty($model)):
                        $count = 0;
                        $res['value'] = 1;
                        $res['message'] = 'Successfull';
                        $res['total-current-page'] = $count;
                        $res['total'] = $modelCount;
                        $res['data'] = [];
                        foreach ($model as $key => $value):
                            $res['data'][$key]['ID'] = $value->ID;
                            $res['data'][$key]['JENIS_LEMBUR'] = $value->JENIS_LEMBUR;
                            $res['data'][$key]['PEKERJAAN_LEMBUR'] = $value->PEKERJAAN_LEMBUR;
                            $res['data'][$key]['ALAMAT'] = $value->ALAMAT;
                            $res['data'][$key]['LATITUDE'] = $value->LATITUDE;
                            $res['data'][$key]['LONGITUDE'] = $value->LONGITUDE;
                            $res['data'][$key]['URAIAN_TUGAS_LEMBUR'] = $value->URAIAN_TUGAS_LEMBUR;
                            $res['data'][$key]['JAM_AWAL_LEMBUR'] = $value->JAM_AWAL_LEMBUR;
                            $res['data'][$key]['JAM_AKHIR_LEMBUR'] = $value->JAM_AKHIR_LEMBUR;
                            $res['data'][$key]['JUMLAH_JAM'] = $value->JUMLAH_JAM;
                            $res['data'][$key]['TOTAL_UPAH_LEMBUR'] = $value->TOTAL_UPAH_LEMBUR;
                            $res['data'][$key]['STATUS_PENGAJUAN'] = $value->STATUS_PENGAJUAN;
                            $res['data'][$key]['TANGGAL_APPROVAL'] = $value->TANGGAL_APPROVAL;
                            $res['data'][$key]['TGL_REJECTED'] = $value->TGL_REJECTED;
                            $res['data'][$key]['USER'] = $value->USER;
                            $res['data'][$key]['TANGGAL_PENGAJUAN'] = $value->CREATED_AT;
                            $res['data'][$key]['UPDATED_AT'] = $value->UPDATED_AT;
                            $res['data'][$key]['EVIDENCE_LEMBUR'] = !empty($value->EVIDENCE_LEMBUR) ? $value->EVIDENCE_LEMBUR : null;
                            $res['data'][$key]['EVIDENCE_SPKL'] = LemburController::actionGenerateSpklFromApi($value->ID);
                            $res['data'][$key]['EVIDENCE_REALISASI'] = !empty($value->EVIDENCE_REALISASI) ? $value->EVIDENCE_REALISASI : null;
                            $count++;
                        endforeach;
                        $res['total-current-page'] = $count;
                        return $res;
                    else:
                        $res['value'] = 1;
                        $res['message'] = 'Data Not Found';
                        $res['data'] = [];
                        return $res;
                    endif;
                else: 
                    $res['value'] = 1;
                    $res['message'] = 'Data Pegawai tidak ditemukan';
                endif;
            elseif(isset($params['ID'])):
                $res['value'] = 1;
                $res['message'] = 'Successfull';
                $res['data'] = Lembur::findOne($params['ID']);
                $res['data']['EVIDENCE_SPKL'] = LemburController::actionGenerateSpklFromApi($params['ID']);
                return $res;
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

    public function actionUpload()
    {
        $request = Yii::$app->request;

        if($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if( isset($bodys['ID']) AND isset($_FILES['FILE']['tmp_name']) ):
                $model = Lembur::find()->andWhere(['ID'=>$bodys['ID']])->one();
                if(isset($model->ID) ):
                    $model->scenario = 'realisasi';
                    $periode = substr($model->CREATED_AT,0,7);
                    $filenameRealisasi = 'files/lembur/'.$periode.'/'.str_replace('/','-',$model->ID).'-ER.jpg';
                    $model->EVIDENCE_REALISASI = 'https://sppd.hapindo.co.id/'.$filenameRealisasi;
                    $model->STATUS_PENGAJUAN = 'Selesai';
                    $model->UPDATED_AT = date('Y-m-d H:i:s');

                    if($model->save()):

                        if (!file_exists('/var/www/html/sppdonln/web/files/lembur/'.$periode.'/')) :
                            mkdir('/var/www/html/sppdonln/web/files/lembur/'.$periode.'/', 0777, true);
                        endif;

                        move_uploaded_file($_FILES['FILE']['tmp_name'],'../web/'.$filenameRealisasi);
                        
                        $res['value'] = 1;
                        $res['message'] = 'sukses';
                        return $res;
                    else:
                        Yii::$app->response->statusCode = 400;
                        $res['value'] = 0;
                        $res['message'] = $spkl->getErrors();
                        return $res;
                    endif;
                else:
                    Yii::$app->response->statusCode = 400;
                    $res['value'] = 1;
                    $res['message'] = 'Data lembur tidak ditemukan';
                    $res['data'] = [];
                    return $res;
                endif;
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
                $res['data'][$key]['ID'] = $value->ID;
                $res['data'][$key]['KEY'] = $value->KEY;
                $res['data'][$key]['VALUE'] = $value->VALUE;
                $res['data'][$key]['DESCRIPTION'] = $value->DESCRIPTION;
                $res['data'][$key]['TABLE'] = $value->TABLE;
                $count++;
            endforeach;
            $res['total'] = $count;
            return $res;
        elseif($request->isPost):
            $headers = $request->headers;
            $bodys = $request->bodyParams;

            if(isset($bodys['TABLE'])):
                $model = DVal::find()->andWhere(['TABLE'=>$bodys['TABLE']])->all();
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

    public function actionCity()
    {
        $request = Yii::$app->request;

        if($request->isGet):
            
            $model = MasterKabupaten::find()->all();
            $count = 0;
            $res['value'] = 1;
            $res['message'] = 'sukses';
            $res['total'] = $count;
            foreach ($model as $key => $value):
                $res['data'][$key]['ID'] = $value->id_kabupaten;
                $res['data'][$key]['kota'] = $value->nama_kabupaten;
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
