<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pegawai;
use yii\db\ActiveQuery;

/**
 * PegawaiSearch represents the model behind the search form about `app\models\Pegawai`.
 */
class PegawaiSearch extends Pegawai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_AKTIF', 'NO_INDUK','NO_INDUK_LAMA', 'ID_REGION', 'ID_UNIT', 'JABATAN','SUB_PEKERJAAN','SPESIFIKASI_PEKERJAAN', 'PEKERJAAN', 'NAMA', 'NAMA_P', 'NO_KTP', 'KELAMIN', 'KAWIN', 'TGL_KAWIN', 'FTGL_LAHIR', 'TP_LAHIR', 'ALAMAT', 'ALAMAT_DSKRG', 'TELP', 'HP', 'EMAIL', 'AGAMA', 'GOL_DAR', 'NPWP', 'NAMA_BANK', 'REKENING', 'UNIT_PLN', 'SPK_SK', 'NO_SPK', 'NO_SK', 'ATAS_NAMA', 'STATUS_PEGAWAI', 'TGL_MASUK', 'STATUS_APPROVAL', 'STATUS_KERJA', 'TGL_KELUAR', 'ASURANSI_KESEHATAN', 'NO_ASURANSI_KESEHATAN','NO_VIRTUAL_ACCOUNT', 'WIL_ASURANSI_KESEHATAN', 'STATUS_PEM_ASKES', 'ASURANSI_TK', 'NO_ASURANSI_TK','NPP', 'WIL_ASURANSI_TK', 'STATUS_PEM_ASTK', 'FOTO', 'PENEMPATAN', 'TGL_AWAL_KONTRAK', 'TGL_AKHIR_KONTRAK', 'NO_KONTRAK','TGL_APPROVAL','PERIODE','PERIODEend','NO_INDUKend','ID_REGIONend','ID_UNITend','JABATANend','NAMAend','STATUS_KERJAend','TGL_AWAL_KONTRAKend','TGL_AKHIR_KONTRAKend','NO_KONTRAKend','NO_REK_DPLK','TINGGI_BADAN','BERAT_BADAN','UKURAN_BAJU','UKURAN_CELANA','UKURAN_SEPATU','UKURAN_SARUNG_TANGAN','UKURAN_TOPI','TGL_TEST','IBU_KANDUNG','NO_CIF','STATUS_PKWT','LOKASI_ARSIP','ID_DATA_SPK','STATUS_ABSEN','USER','DIVISI'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // print_r(yii::$app->session['qwerywhere3']);die;
        
        $query = Pegawai::find()
        ->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')
        ->andWhere(['pegawai.STATUS_APPROVAL' => '1']);
        
        if(Yii::$app->user->identity->JENIS != "1"): 
            $query->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND dbsimponi.data_spk.APP ="'.Yii::$app->user->identity->valueCompany.'"');
        endif;
        if(Yii::$app->user->identity->JENIS == "3" OR Yii::$app->user->identity->JENIS == "10" OR Yii::$app->user->identity->JENIS == "11"): 
            $query->andWhere(['pegawai.PENEMPATAN' => Yii::$app->user->identity->UNIT]);
        endif;
        if(Yii::$app->user->identity->JENIS == "7"): 
            $query->andWhere(Yii::$app->user->identity->queryBawahan);
        endif;

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['NO_SPK'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->joinWith('spkku');

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'pegawai.TGL_KAWIN' => $this->TGL_KAWIN,
        //     'pegawai.FTGL_LAHIR' => $this->FTGL_LAHIR,
        //     'pegawai.TGL_MASUK' => $this->TGL_MASUK,
        //     'pegawai.TGL_KELUAR' => $this->TGL_KELUAR,
        //     'pegawai.TGL_AWAL_KONTRAK' => $this->TGL_AWAL_KONTRAK,
        //     'pegawai.TGL_AKHIR_KONTRAK' => $this->TGL_AKHIR_KONTRAK,
        //     'pegawai.TGL_APPROVAL'=> $this->TGL_APPROVAL,
        //     'pegawai.TGL_TEST'=> $this->TGL_TEST,
        //     'pegawai.STATUS_ABSEN'=> $this->STATUS_ABSEN,
        //     'pegawai.USER'=> $this->USER,
        // ]);

        $query->andFilterWhere(['like', 'pegawai.NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['like', 'data_spk.NO_SPK', $this->NO_SPK])
            ->andFilterWhere(['like', 'data_spk.JABATAN', $this->JABATAN])
            ->andFilterWhere(['like', 'data_spk.PEKERJAAN', $this->PEKERJAAN])
            ->andFilterWhere(['like', 'pegawai.NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'pegawai.NO_KTP', $this->NO_KTP])
            ->andFilterWhere(['like', 'pegawai.PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['like', 'pegawai.KELAMIN', $this->KELAMIN])
            ->andFilterWhere(['like', 'pegawai.KAWIN', $this->KAWIN])
            ->andFilterWhere(['like', 'pegawai.AGAMA', $this->AGAMA]);

        return $dataProvider;
    }

}
