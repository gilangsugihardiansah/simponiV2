<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AstroReimburseSearch represents the model behind the search form about `app\models\AstroReimburse`.
 */
class AstroReimburseSearch extends AstroReimburse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA', 'NO_KTP', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'PENEMPATAN', 'KETERANGAN', 'TGL_SERVICE', 'NO_POL','USER','STATUS_PENGAJUAN','CREATED_AT','TGL_APPROVED','TGL_REJECTED','UPDATED_AT'], 'safe'],
            [['NOMINAL'], 'number', 'max' => 0],
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
        $query = AstroReimburse::find();

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

        if(!empty($this->TGL_SERVICE) && strpos($this->TGL_SERVICE, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_SERVICE);
            $query->andFilterWhere(['between', 'TGL_SERVICE', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_APPROVED) && strpos($this->TGL_APPROVED, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_APPROVED);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query->andFilterWhere(['between', 'TGL_APPROVED', $start_date, $end_date]);
        endif;

        if(!empty($this->TGL_REJECTED) && strpos($this->TGL_REJECTED, '-') !== false) :
            list($start_date, $end_date) = explode(' - ', $this->TGL_REJECTED);
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
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
            ->andFilterWhere(['like', 'NO_KTP', $this->NO_KTP])
            ->andFilterWhere(['like', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'NO_SPK', $this->NO_SPK])
            ->andFilterWhere(['like', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['like', 'PEKERJAAN', $this->PEKERJAAN])
            ->andFilterWhere(['like', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['like', 'KETERANGAN', $this->KETERANGAN])
            ->andFilterWhere(['like', 'NO_POL', $this->NO_POL])
            ->andFilterWhere(['=', 'NOMINAL', $this->NOMINAL])
            ->andFilterWhere(['=', 'STATUS_PENGAJUAN', $this->STATUS_PENGAJUAN])
            ->andFilterWhere(['like', 'USER', $this->USER]);

        return $dataProvider;
    }
}
