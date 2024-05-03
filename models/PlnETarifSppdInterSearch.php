<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PlnETarifSppdInterSearch represents the model behind the search form about `app\models\PlnETarifSppdInter`.
 */
class PlnETarifSppdInterSearch extends PlnETarifSppdInter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','REGION','KONSUMSI','UANG_SAKU'], 'safe'],
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
        $query = PlnETarifSppdInter::find();

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['REGION'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'ID', $this->ID])
        ->andFilterWhere(['=', 'REGION', $this->REGION]);

        return $dataProvider;
    }
}
