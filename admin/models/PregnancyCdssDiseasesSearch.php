<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PregnancyCdssDiseases;

/**
 * PregnancyCdssDiseasesSearch represents the model behind the search form about `app\models\PregnancyCdssDiseases`.
 */
class PregnancyCdssDiseasesSearch extends PregnancyCdssDiseases
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['dis_name', 'dis_note', 'dis_icd10'], 'safe'],
            [['p'], 'number'],
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
        $query = PregnancyCdssDiseases::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'p' => $this->p,
        ]);

        $query->andFilterWhere(['like', 'dis_name', $this->dis_name])
            ->andFilterWhere(['like', 'dis_note', $this->dis_note]);

        return $dataProvider;
    }
}
