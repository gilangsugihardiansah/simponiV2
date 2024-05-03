<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PlnEChargeCodeSearch represents the model behind the search form about `app\models\PlnEChargeCode`.
 */
class PlnEChargeCodeSearch extends PlnEChargeCode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','CHARGE_CODE','NAMA_PEKERJAAN','ID_VP','ID_MSB'], 'safe'],
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
        $query = PlnEChargeCode::find();

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['ID'=>SORT_DESC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'ID', $this->ID])
        ->andFilterWhere(['=', 'CHARGE_CODE', $this->CHARGE_CODE])
        ->andFilterWhere(['=', 'NAMA_PEKERJAAN', $this->NAMA_PEKERJAAN])
        ->andFilterWhere(['=', 'ID_VP', $this->ID_VP])
        ->andFilterWhere(['=', 'ID_MSB', $this->ID_MSB]);

        return $dataProvider;
    }
}
