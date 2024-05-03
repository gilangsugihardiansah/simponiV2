<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UnitPlnSearch represents the model behind the search form about `app\models\Pegawai`.
 */
class UnitPlnSearch extends Pegawai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PENEMPATAN'], 'safe'],
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
        $query = Pegawai::find()
        // ->select('pegawai.PENEMPATAN')
        ->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')
        ->andWhere(['dbsimponi.pegawai.STATUS_APPROVAL' => '1'])
        ->groupBy('dbsimponi.pegawai.PENEMPATAN');

        if(Yii::$app->user->identity->JENIS != "1"): 
            $query->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND dbsimponi.data_spk.APP ="'.Yii::$app->user->identity->valueCompany.'"');
        else:
            $query->rightJoin('data_spk', 'data_spk.ID_DATA_SPK = pegawai.ID_DATA_SPK AND (dbsimponi.data_spk.APP ="JATENG" OR dbsimponi.data_spk.APP ="PUSHARLIS")');
        endif;

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['PENEMPATAN'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'PENEMPATAN', $this->PENEMPATAN]);

        return $dataProvider;
    }
}
