<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PregnancyCdssSymptoms;

/**
 * PregnancyCdssSymptomsSearch represents the model behind the search form about `app\models\PregnancyCdssSymptoms`.
 */
class PregnancyCdssSymptomsSearch extends PregnancyCdssSymptoms
{
    //public $symptCategory;
    
    public function attributes()
    {
    // add related fields to searchable attributes
    return array_merge(parent::attributes(), ['symptCategory.cat_name']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_order', 'id_category', 'is_multi', 'is_selected'], 'integer'],
            [['symp_name', 'symp_notes', 'symptCategory.cat_name'], 'safe'],
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
        $query = PregnancyCdssSymptoms::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // join with relation `symptCategory` that is a relation to the table `form_pregnancycdss_sympt_category`
        // and set the table alias to be `symptCategory` (upd: table name get from model class by method)
        $query->joinWith(['symptCategory' => function($query) { $query->from(['symptCategory' => PregnancyCdssSymptCategory::tableName()]); }]);
        
        // enable sorting for the related column
        $dataProvider->sort->attributes['symptCategory.cat_name'] = [
            'asc' => ['symptCategory.cat_name' => SORT_ASC],
            'desc' => ['symptCategory.cat_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            self::tableName() . '.id_order' => $this->id_order,
            'id_category' => $this->id_category,
            'is_multi' => $this->is_multi,
            self::tableName() . '.is_selected' => $this->is_selected,
        ]);

        $query->andFilterWhere(['like', 'symptCategory.cat_name', $this->getAttribute('symptCategory.cat_name')]);
        
        $query->andFilterWhere(['like', 'symp_name', $this->symp_name])
            ->andFilterWhere(['like', 'symp_notes', $this->symp_notes]);

        return $dataProvider;
    }
}
