<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LemburSearch represents the model behind the search form about `app\models\Lembur`.
 */
class LemburSearch extends Lembur
{
    public $APP;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NO_INDUK','NAMA','ID_DATA_SPK','NO_SPK','ID_UNIT','UNIT_PLN','PENEMPATAN','JABATAN','JENIS_LEMBUR','PEKERJAAN_LEMBUR','ALAMAT','URAIAN_TUGAS_LEMBUR','EVIDENCE_LEMBUR','JAM_AWAL_LEMBUR','JAM_AKHIR_LEMBUR','UPAH_PENGKALI','JUMLAH_JAM','TOTAL_UPAH_LEMBUR','STATUS_PENGAJUAN','USER','USER_APP','CREATED_AT','UPDATED_AT','TANGGAL_APPROVAL','TGL_REJECTED','APP'], 'safe'],
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
        $query = Lembur::find();
        
        if(Yii::$app->user->identity->JENIS == "7" || Yii::$app->user->identity->JENIS == "8"): 
            if(Yii::$app->user->identity->JENIS == "7"): 
                $query->andWhere(['lembur.USER_APP' => Yii::$app->user->identity->ID]);
            elseif(Yii::$app->user->identity->JENIS == "8"): 
                if(!empty($this->APP) && $this->APP == "APP") :
                    $query->andWhere(['lembur.USER_APP' => Yii::$app->user->identity->ID]);
                endif;
            endif;
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

        // if(!empty($this->STATUS_ALL) && isset($this->STATUS_ALL)) :
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Disetujui"]);
        //     $query->andFilterWhere(['!=', 'STATUS_PENGAJUAN', "Ditolak"]);
        // endif;

        if(!empty($this->TGL_PENGAJUAN) && strpos($this->TGL_PENGAJUAN, '-') !== false) :
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

        if(!empty($this->TANGGAL_APPROVAL) && strpos($this->TANGGAL_APPROVAL, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TANGGAL_APPROVAL);
            $query->andFilterWhere(['between', 'TANGGAL_APPROVAL', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_REJECTED) && strpos($this->TGL_REJECTED, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_REJECTED);
            $query->andFilterWhere(['between', 'TGL_REJECTED', $start_date, $end_date]);
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

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'ID_DATA_SPK', $this->ID_DATA_SPK])
            ->andFilterWhere(['like', 'NO_SPK', $this->NO_SPK])
            ->andFilterWhere(['like', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['like', 'JABATAN', $this->JABATAN])
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
