<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JenisUserSearch represents the model behind the search form about `app\models\JenisUser`.
 */
class JenisUserSearch extends JenisUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'JENIS_USER'], 'safe'],
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
        $query = JenisUser::find();

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

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'JENIS_USER', $this->JENIS_USER]);

        return $dataProvider;
    }
}
