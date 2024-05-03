<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SppdSearch represents the model behind the search form about `app\models\Sppd`.
 */
class SppdDetailSearch extends SppdDetail
{
    // public $STATUS_ALL,$STATUS_NOT_REJECT,$NAMA_MANAGER_CABANG,$NAMA_USER,$NOMOR_SURAT,$PERIHAL,$PERIODE,$penagihan;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA', 'JABATAN', 'PENEMPATAN', 'TUJUAN_SPPD', 'KETERANGAN_SPPD', 'HARI_UANG_SAKU', 'HARI_PENGINAPAN', 'HARI_TOTAL','TGL'], 'safe'],
            [['TOTAL','UANG_SAKU','PENGINAPAN'], 'number', 'min' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SppdDetail::find();
        
        // if(Yii::$app->user->identity->JENIS == "3"): 
        //     $query->andWhere(['sppd.PENEMPATAN' => Yii::$app->user->identity->UNIT]);
        // endif;

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['TGL'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NO_INDUK', $this->NO_INDUK])
            ->andFilterWhere(['like', 'PENEMPATAN', $this->PENEMPATAN])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'JABATAN', $this->JABATAN])
            ->andFilterWhere(['like', 'TUJUAN_SPPD', $this->TUJUAN_SPPD])
            ->andFilterWhere(['like', 'KETERANGAN_SPPD', $this->KETERANGAN_SPPD])
            ->andFilterWhere(['like', 'HARI_UANG_SAKU', $this->HARI_UANG_SAKU])
            ->andFilterWhere(['like', 'HARI_PENGINAPAN', $this->HARI_PENGINAPAN])
            ->andFilterWhere(['like', 'HARI_TOTAL', $this->HARI_TOTAL])
            ->andFilterWhere(['like', 'TGL', $this->TGL])
            ->andFilterWhere(['like', 'TOTAL', $this->TOTAL])
            ->andFilterWhere(['like', 'UANG_SAKU', $this->UANG_SAKU])
            ->andFilterWhere(['like', 'PENGINAPAN', $this->PENGINAPAN]);

        return $dataProvider;
    }
}
