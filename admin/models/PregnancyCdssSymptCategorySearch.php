<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PregnancyCdssSymptCategory;

/**
 * PregnancyCdssSymptCategorySearch represents the model behind the search form about `app\models\PregnancyCdssSymptCategory`.
 */
class PregnancyCdssSymptCategorySearch extends PregnancyCdssSymptCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_selected'], 'integer'],
            [['cat_name', 'cat_notes'], 'safe'],
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
        $query = PregnancyCdssSymptCategory::find();

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
            self::tableName() . '.is_selected' => $this->is_selected,
        ]);

        $query->andFilterWhere(['like', 'cat_name', $this->cat_name])
            ->andFilterWhere(['like', 'cat_notes', $this->cat_notes]);

        return $dataProvider;
    }
}
