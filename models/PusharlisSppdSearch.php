<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PusharlisSppdSearch represents the model behind the search form about `app\models\PusharlisSppd`.
 */
class PusharlisSppdSearch extends PusharlisSppd
{
    public $STATUS_APP,$STATUS_NOT_REJECT,$NAMA_MANAGER_CABANG,$NAMA_USER,$NOMOR_SURAT,$PERIHAL,$PERIODE,$penagihan;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA','USER', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'JUMLAH_HARI', 'KOTA_ASAL', 'KOTA_TUJUAN', 'INSTANSI_TUJUAN', 'URAIAN_TUGAS','TARIF_PusharlisSppd','RATING','TGL_BERANGKAT', 'TGL_KEMBALI','CREATED_AT', 'TGL_REKOMENDASI', 'UPDATED_AT','STATUS_PENGAJUAN','PENEMPATAN','STATUS_APP','STATUS_NOT_REJECT','NAMA_ATASAN_PLN','NO_WA_ATASAN_PLN','NAMA_MANAGER_CABANG','NAMA_USER','NOMOR_SURAT','PERIHAL','TGL_REJECTED','PERIODE','penagihan','WBS','STATUS_SPPD','ALASAN'], 'safe'],
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
        $query = PusharlisSppd::find();
        
        if(Yii::$app->user->identity->JENIS == "3"): 
            $query->andWhere(['PusharlisSppd.PENEMPATAN' => Yii::$app->user->identity->UNIT]);
        endif;

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['CREATED_AT'=>SORT_DESC]],
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

        if(!empty($this->STATUS_APP) && isset($this->STATUS_APP)) :
            $query->andFilterWhere(['OR',['STATUS_PENGAJUAN'=> "1"],['STATUS_PENGAJUAN'=> "2"]]);
        endif;

        if(!empty($this->CREATED_AT) && strpos($this->CREATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'CREATED_AT', $start_date, $end_date]);
            // print_r($this->CREATED_AT);die;
        endif;

        if(!empty($this->TGL_BERANGKAT) && strpos($this->TGL_BERANGKAT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_BERANGKAT);
            $query->andFilterWhere(['between', 'TGL_BERANGKAT', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_KEMBALI) && strpos($this->TGL_KEMBALI, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_KEMBALI);
            $query->andFilterWhere(['between', 'TGL_KEMBALI', $start_date, $end_date]);
        endif;

        if(!empty($this->UPDATED_AT) && strpos($this->UPDATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATED_AT', $start_date, $end_date]);
        endif;

       

        $query->andFilterWhere(['=', '=', $this->ID])
            ->andFilterWhere(['=', 'WBS', $this->WBS])
            ->andFilterWhere(['=', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['=', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['=', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'NO_SPK', $this->NO_SPK])
            ->andFilterWhere(['=', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['like', 'PEKERJAAN', $this->PEKERJAAN])
            ->andFilterWhere(['like', 'JUMLAH_HARI', $this->JUMLAH_HARI])
            ->andFilterWhere(['like', 'KOTA_ASAL', $this->KOTA_ASAL])
            ->andFilterWhere(['=', 'KOTA_TUJUAN', $this->KOTA_TUJUAN])
            ->andFilterWhere(['like', 'INSTANSI_TUJUAN', $this->INSTANSI_TUJUAN])
            ->andFilterWhere(['=', 'NAMA_ATASAN_PLN', $this->NAMA_ATASAN_PLN])
            ->andFilterWhere(['=', 'NO_WA_ATASAN_PLN', $this->NO_WA_ATASAN_PLN])
            ->andFilterWhere(['=', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            ->andFilterWhere(['like', 'RATING', $this->RATING])
            ->andFilterWhere(['like', 'STATUS_SPPD', $this->STATUS_SPPD])
            ->andFilterWhere(['not like', 'TOTAL', $this->TOTAL])
            ->andFilterWhere(['like', 'UPDATED_AT', $this->UPDATED_AT]);

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
        $query = PusharlisSppd::find();
        $query->select('NO_INDUK,NAMA,PENEMPATAN,JABATAN,sum(TOTAL) AS TOTAL');
        
        if(Yii::$app->user->identity->JENIS == "3"): 
            $query->andWhere(['PusharlisSppd.PENEMPATAN' => Yii::$app->user->identity->UNIT]);
        endif;
        $query->groupBy('PusharlisSppd.NO_INDUK');

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['CREATED_AT'=>SORT_DESC]],
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

        // if(!empty($this->STATUS_APP) && isset($this->STATUS_APP)) :
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Disetujui"]);
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Ditolak"]);
        // endif;

        if(!empty($this->CREATED_AT) && strpos($this->CREATED_AT, '-') !== false and ($this->TGL_PENGAJUAN!=null))  :
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

        if(!empty($this->UPDATED_AT) && strpos($this->UPDATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATED_AT', $start_date, $end_date]);
        endif;

        if($this->penagihan==true):
            $query->andFilterWhere(['like', 'TGL_BERANGKAT', $this->PERIODE]);
            $query->andFilterWhere(['NOT', ['TGL_PENGAJUAN'=>NULL]]);
        endif;

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'WBS', $this->WBS])
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
            ->andFilterWhere(['like', 'UPDATED_AT', $this->UPDATED_AT]);

        return $dataProvider;
    }
}
