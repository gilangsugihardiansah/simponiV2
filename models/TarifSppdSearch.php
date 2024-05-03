<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TarifSppdSearch represents the model behind the search form about `app\models\TarifSppd`.
 */
class TarifSppdSearch extends TarifSppd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','TARIF_AKOMODASI','TARIF_MENGINAP','COMPANY'], 'safe'],
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
        $query = TarifSppd::find();

        if(Yii::$app->user->identity->JENIS != "1"): 
            $query->andWhere(['COMPANY' => Yii::$app->user->identity->valueCompany]);
        endif;

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['ID'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'ID', $this->ID])
        ->andFilterWhere(['=', 'TARIF_AKOMODASI', $this->TARIF_AKOMODASI])
        ->andFilterWhere(['=', 'COMPANY', $this->COMPANY])
            ->andFilterWhere(['=', 'TARIF_MENGINAP', $this->TARIF_MENGINAP]);

        return $dataProvider;
    }
}
