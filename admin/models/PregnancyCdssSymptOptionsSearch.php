<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PregnancyCdssSymptOptions;

/**
 * PregnancyCdssSymptOptionsSearch represents the model behind the search form about `app\models\PregnancyCdssSymptOptions`.
 */
class PregnancyCdssSymptOptionsSearch extends PregnancyCdssSymptOptions
{
    public function attributes()
    {
    // add related fields to searchable attributes
    return array_merge(parent::attributes(), ['symptom.symp_name']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_symptom', 'id_order', 'is_selected'], 'integer'],
            [['opt_name', 'symptom.symp_name'], 'safe'],
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
        $query = PregnancyCdssSymptOptions::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // join with relation `symptom` that is a relation to the table `form_pregnancycdss_symptom`
        // and set the table alias to be `symptCategory` (upd: table name get from model class by method)
        $query->joinWith(['symptom' => function($query) { $query->from(['symptom' => PregnancyCdssSymptoms::tableName()]); }]);
        
        // enable sorting for the related column
        $dataProvider->sort->attributes['symptom.symp_name'] = [
            'asc' => ['symptom.symp_name' => SORT_ASC],
            'desc' => ['symptom.symp_name' => SORT_DESC],
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
                
        $query->andFilterWhere([
            'id' => $this->id,
            'id_symptom' => $this->id_symptom,
            self::tableName() . '.id_order' => $this->id_order,
            self::tableName() . '.is_selected' => $this->is_selected,
        ]);

        //$query->andFilterWhere(['like', 'symptom.symp_name', $this->getAttribute('symptom.symp_name')]);
        
        $query->andFilterWhere(['like', 'opt_name', $this->opt_name]);

        return $dataProvider;
    }
}
