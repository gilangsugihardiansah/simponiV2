<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SppdSearch represents the model behind the search form about `app\models\Sppd`.
 */
class SppdSearch extends Sppd
{
    public $STATUS_ALL,$STATUS_NOT_REJECT,$NAMA_MANAGER_CABANG,$NAMA_USER,$NOMOR_SURAT,$PERIHAL,$PERIODE,$penagihan;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA','USER', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'JUMLAH_HARI', 'KOTA_ASAL', 'KOTA_TUJUAN', 'INSTANSI_TUJUAN', 'URAIAN_TUGAS','TARIF_SPPD','RATING','TGL_BERANGKAT', 'TGL_KEMBALI','TGL_PENGAJUAN', 'TGL_REKOMENDASI','TGL_APPROVAL', 'TGL_BAYAR', 'UPDATE_AT','STATUS_PENGAJUAN','PENEMPATAN','STATUS_ALL','STATUS_NOT_REJECT','NAMA_ATASAN_PLN','NO_WA_ATASAN_PLN','NAMA_MANAGER_CABANG','NAMA_USER','NOMOR_SURAT','PERIHAL','TGL_REJECTED','PERIODE','penagihan'], 'safe'],
            [['TOTAL'], 'number', 'min' => 0],
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
        $query = Sppd::find();
        
        if(Yii::$app->user->identity->JENIS == "3"): 
            $query->andWhere(['sppd.PENEMPATAN' => Yii::$app->user->identity->UNIT]);
        endif;

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['TGL_PENGAJUAN'=>SORT_DESC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // if(!empty($this->STATUS_NOT_REJECT) && isset($this->STATUS_NOT_REJECT)) :
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Ditolak"]);
        // endif;

        // if(!empty($this->STATUS_ALL) && isset($this->STATUS_ALL)) :
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Disetujui"]);
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Ditolak"]);
        // endif;

        if(!empty($this->TGL_PENGAJUAN) && strpos($this->TGL_PENGAJUAN, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_PENGAJUAN);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_PENGAJUAN', $start_date, $end_date]);
            // print_r($this->TGL_PENGAJUAN);die;
        endif;

        if(!empty($this->TGL_BERANGKAT) && strpos($this->TGL_BERANGKAT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_BERANGKAT);
            $query->andFilterWhere(['between', 'TGL_BERANGKAT', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_KEMBALI) && strpos($this->TGL_KEMBALI, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_KEMBALI);
            $query->andFilterWhere(['between', 'TGL_KEMBALI', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_APPROVAL) && strpos($this->TGL_APPROVAL, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_APPROVAL);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_APPROVAL', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_REJECTED) && strpos($this->TGL_REJECTED, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_REJECTED);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_REJECTED', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_BAYAR) && strpos($this->TGL_BAYAR, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_BAYAR);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_BAYAR', $start_date, $end_date]);
        endif;

        if(!empty($this->UPDATE_AT) && strpos($this->UPDATE_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATE_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATE_AT', $start_date, $end_date]);
        endif;

       

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['like', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'NO_SPK', $this->NO_SPK])
            ->andFilterWhere(['like', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['like', 'PEKERJAAN', $this->PEKERJAAN])
            ->andFilterWhere(['like', 'JUMLAH_HARI', $this->JUMLAH_HARI])
            ->andFilterWhere(['like', 'KOTA_ASAL', $this->KOTA_ASAL])
            ->andFilterWhere(['like', 'KOTA_TUJUAN', $this->KOTA_TUJUAN])
            ->andFilterWhere(['like', 'INSTANSI_TUJUAN', $this->INSTANSI_TUJUAN])
            ->andFilterWhere(['like', 'NAMA_ATASAN_PLN', $this->NAMA_ATASAN_PLN])
            ->andFilterWhere(['like', 'NO_WA_ATASAN_PLN', $this->NO_WA_ATASAN_PLN])
            ->andFilterWhere(['like', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            ->andFilterWhere(['like', 'RATING', $this->RATING])
            ->andFilterWhere(['like', 'TGL_APPROVAL', $this->TGL_APPROVAL])
            ->andFilterWhere(['like', 'TGL_BAYAR', $this->TGL_BAYAR])
            ->andFilterWhere(['not like', 'TOTAL', $this->TOTAL])
            ->andFilterWhere(['like', 'UPDATE_AT', $this->UPDATE_AT]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRekap($params)
    {
        $query = Sppd::find();
        $query->select('NO_INDUK,NAMA,PENEMPATAN,JABATAN,sum(TOTAL) AS TOTAL');
        
        if(Yii::$app->user->identity->JENIS == "3"): 
            $query->andWhere(['sppd.PENEMPATAN' => Yii::$app->user->identity->UNIT]);
        endif;
        $query->groupBy('sppd.NO_INDUK');

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['TGL_PENGAJUAN'=>SORT_DESC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // if(!empty($this->STATUS_NOT_REJECT) && isset($this->STATUS_NOT_REJECT)) :
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Ditolak"]);
        // endif;

        // if(!empty($this->STATUS_ALL) && isset($this->STATUS_ALL)) :
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Disetujui"]);
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Ditolak"]);
        // endif;

        if(!empty($this->TGL_PENGAJUAN) && strpos($this->TGL_PENGAJUAN, '-') !== false and ($this->TGL_PENGAJUAN!=null))  :
            list($start_date, $end_date) = explode(' - ', $this->TGL_PENGAJUAN);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_PENGAJUAN', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_BERANGKAT) && strpos($this->TGL_BERANGKAT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_BERANGKAT);
            $query->andFilterWhere(['between', 'TGL_BERANGKAT', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_KEMBALI) && strpos($this->TGL_KEMBALI, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_KEMBALI);
            $query->andFilterWhere(['between', 'TGL_KEMBALI', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_APPROVAL) && strpos($this->TGL_APPROVAL, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_APPROVAL);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_APPROVAL', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_BAYAR) && strpos($this->TGL_BAYAR, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_BAYAR);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_BAYAR', $start_date, $end_date]);
        endif;

        if(!empty($this->UPDATE_AT) && strpos($this->UPDATE_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATE_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATE_AT', $start_date, $end_date]);
        endif;

        if($this->penagihan==true):
            $query->andFilterWhere(['like', 'TGL_BERANGKAT', $this->PERIODE]);
            $query->andFilterWhere(['NOT', ['TGL_PENGAJUAN'=>NULL]]);
        endif;

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['like', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'NO_SPK', $this->NO_SPK])
            ->andFilterWhere(['like', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['like', 'PEKERJAAN', $this->PEKERJAAN])
            ->andFilterWhere(['like', 'JUMLAH_HARI', $this->JUMLAH_HARI])
            ->andFilterWhere(['like', 'KOTA_ASAL', $this->KOTA_ASAL])
            ->andFilterWhere(['like', 'KOTA_TUJUAN', $this->KOTA_TUJUAN])
            ->andFilterWhere(['like', 'INSTANSI_TUJUAN', $this->INSTANSI_TUJUAN])
            ->andFilterWhere(['like', 'NAMA_ATASAN_PLN', $this->NAMA_ATASAN_PLN])
            ->andFilterWhere(['like', 'NO_WA_ATASAN_PLN', $this->NO_WA_ATASAN_PLN])
            ->andFilterWhere(['like', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            ->andFilterWhere(['like', 'RATING', $this->RATING])
            ->andFilterWhere(['like', 'TGL_APPROVAL', $this->TGL_APPROVAL])
            ->andFilterWhere(['like', 'TGL_BAYAR', $this->TGL_BAYAR])
            ->andFilterWhere(['like', 'UPDATE_AT', $this->UPDATE_AT]);

        return $dataProvider;
    }
}
