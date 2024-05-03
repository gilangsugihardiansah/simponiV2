<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LemburSearch represents the model behind the search form about `app\models\PusharlisLembur`.
 */
class PusharlisLemburSearch extends PusharlisLembur
{
    public $STATUS_APP;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NO_INDUK','NAMA','ID_DATA_SPK','NO_SPK','ID_UNIT','UNIT_PLN','PENEMPATAN','JABATAN','JENIS_LEMBUR','PEKERJAAN_LEMBUR','ALAMAT','URAIAN_TUGAS_LEMBUR','EVIDENCE_LEMBUR','JAM_AWAL_LEMBUR','JAM_AKHIR_LEMBUR','UPAH_PENGKALI','JUMLAH_JAM','TOTAL_UPAH_LEMBUR','STATUS_PENGAJUAN','USER','USER_APP','CREATED_AT','UPDATED_AT','TANGGAL_APPROVAL','TGL_REJECTED','STATUS_APP'], 'safe'],
            [['TOTAL_UPAH_LEMBUR'], 'number', 'max' => 0],
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
        $query = PusharlisLembur::find();
        
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

        if(!empty($this->STATUS_APP) && isset($this->STATUS_APP)) :
            $query->andFilterWhere(['OR',['STATUS_PENGAJUAN'=> "2"],['STATUS_PENGAJUAN'=> "3"]]);
        endif;

        if(!empty($this->JAM_AWAL_LEMBUR) && strpos($this->JAM_AWAL_LEMBUR, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->JAM_AWAL_LEMBUR);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'JAM_AWAL_LEMBUR', $start_date, $end_date]);
        endif;

        if(!empty($this->JAM_AKHIR_LEMBUR) && strpos($this->JAM_AKHIR_LEMBUR, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->JAM_AKHIR_LEMBUR);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'JAM_AKHIR_LEMBUR', $start_date, $end_date]);
        endif;

        if(!empty($this->CREATED_AT) && strpos($this->CREATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'CREATED_AT', $start_date, $end_date]);
        endif;

        if(!empty($this->UPDATED_AT) && strpos($this->UPDATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATED_AT', $start_date, $end_date]);
        endif;

        $query->andFilterWhere(['=', 'ID', $this->ID])
            ->andFilterWhere(['=', 'WBS', $this->WBS])
            ->andFilterWhere(['=', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['=', 'NAMA', $this->NAMA])
            ->andFilterWhere(['=', 'JENIS_LEMBUR', $this->JENIS_LEMBUR])
            ->andFilterWhere(['=', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['=', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['=', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            // ->andFilterWhere(['like', 'PEKERJAAN', $this->PEKERJAAN])
            // ->andFilterWhere(['like', 'JUMLAH_HARI', $this->JUMLAH_HARI])
            // ->andFilterWhere(['like', 'KOTA_ASAL', $this->KOTA_ASAL])
            // ->andFilterWhere(['like', 'KOTA_TUJUAN', $this->KOTA_TUJUAN])
            // ->andFilterWhere(['like', 'INSTANSI_TUJUAN', $this->INSTANSI_TUJUAN])
            // ->andFilterWhere(['like', 'NAMA_ATASAN_PLN', $this->NAMA_ATASAN_PLN])
            // ->andFilterWhere(['like', 'NO_WA_ATASAN_PLN', $this->NO_WA_ATASAN_PLN])
            // ->andFilterWhere(['like', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            // ->andFilterWhere(['like', 'RATING', $this->RATING])
            // ->andFilterWhere(['like', 'TGL_APPROVAL', $this->TGL_APPROVAL])
            // ->andFilterWhere(['like', 'TGL_BAYAR', $this->TGL_BAYAR])
            ->andFilterWhere(['like', 'UPDATED_AT', $this->UPDATED_AT]);

        return $dataProvider;
    }
}
