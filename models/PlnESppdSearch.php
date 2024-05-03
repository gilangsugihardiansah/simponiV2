<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PlnESppdSearch represents the model behind the search form about `app\models\PlnESppd`.
 */
class PlnESppdSearch extends PlnESppd
{
    public $STATUS_APP;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA','USER','PENEMPATAN', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'TGL_BERANGKAT', 'TGL_KEMBALI', 'JUMLAH_HARI','JENIS_SPPD','IS_LUMPSUM', 'WILAYAH', 'ASAL', 'TUJUAN', 'INSTANSI_TUJUAN','JENIS_TRANPORTASI', 'URAIAN_TUGAS','TARIF_SPPD' ,'ID_CHARGE_CODE', 'CHARGE_CODE', 'VP', 'MSB', 'STATUS_PENGAJUAN', 'CREATED_AT', 'UPDATED_AT','STATUS_APP'], 'safe'],
            [['KONSUMSI', 'LAUNDRY', 'TRANPORTASI', 'UANG_SAKU', 'TOTAL', 'KURS_DOLAR', 'NOMINAL'], 'number', 'min' => 0],
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
        $query = PlnESppd::find();
        if(Yii::$app->user->identity->JENIS == "13"): 
            $query->andWhere(['MSB'=>Yii::$app->user->identity->UNIT]);
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
            $query->andFilterWhere(['OR',['STATUS_PENGAJUAN'=> "1"],['STATUS_PENGAJUAN'=> "2"]]);
        endif;

        if(!empty($this->TGL_BERANGKAT) && strpos($this->TGL_BERANGKAT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_BERANGKAT);
            $query->andFilterWhere(['between', 'TGL_BERANGKAT', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_KEMBALI) && strpos($this->TGL_KEMBALI, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_KEMBALI);
            $query->andFilterWhere(['between', 'TGL_KEMBALI', $start_date, $end_date]);
        endif;

        if(!empty($this->CREATED_AT) && strpos($this->CREATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'CREATED_AT', $start_date, $end_date]);
            // print_r($this->CREATED_AT);die;
        endif;

        if(!empty($this->TGL_REKOMENDASI) && strpos($this->TGL_REKOMENDASI, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_REKOMENDASI);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_REKOMENDASI', $start_date, $end_date]);
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

        if(!empty($this->UPDATED_AT) && strpos($this->UPDATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATED_AT', $start_date, $end_date]);
        endif;

       

        $query->andFilterWhere(['=', 'ID', $this->ID])
            ->andFilterWhere(['=', 'CHARGE_CODE', $this->CHARGE_CODE])
            ->andFilterWhere(['=', 'VP', $this->VP])
            ->andFilterWhere(['=', 'MSB', $this->MSB])
            ->andFilterWhere(['=', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['=', 'NAMA', $this->NAMA])
            ->andFilterWhere(['=', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['=', 'JENIS_SPPD', $this->JENIS_SPPD])
            ->andFilterWhere(['=', 'JUMLAH_HARI', $this->JUMLAH_HARI])
            ->andFilterWhere(['=', 'WILAYAH', $this->WILAYAH])
            ->andFilterWhere(['=', 'TUJUAN', $this->TUJUAN])
            ->andFilterWhere(['=', 'IS_LUMPSUM', $this->IS_LUMPSUM])
            ->andFilterWhere(['=', 'JENIS_TRANPORTASI', $this->JENIS_TRANPORTASI])
            ->andFilterWhere(['=', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            ->andFilterWhere(['not like', 'TOTAL', $this->TOTAL]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchReport($params)
    {
        $query = PlnESppd::find();

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['UPDATED_AT'=>SORT_DESC,'CHARGE_CODE'=>SORT_ASC,'NO_INDUK'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($this->UPDATED_AT) && strpos($this->UPDATED_AT, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->UPDATED_AT);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'UPDATED_AT', $start_date, $end_date]);
        endif;

       

        $query->andFilterWhere(['=', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN]);

        return $dataProvider;
    }
}
