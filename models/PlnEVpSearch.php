<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PlnEVpSearch represents the model behind the search form about `app\models\PlnEVp`.
 */
class PlnEVpSearch extends PlnEVp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NAMA','VP'], 'safe'],
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
        $query = PlnEVp::find();

        // add conditions that should always apply here
        
        $pagination = yii::$app->AllComponent->getPagination($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['NAMA'=>SORT_ASC]],
            'pagination' => $pagination,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'ID', $this->ID])
        ->andFilterWhere(['=', 'NAMA', $this->NAMA])
        ->andFilterWhere(['=', 'VP', $this->VP]);

        return $dataProvider;
    }
}
