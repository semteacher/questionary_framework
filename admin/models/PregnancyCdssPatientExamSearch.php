<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PregnancyCdssPatientExam;

/**
 * PregnancyCdssPatientExamSearch represents the model behind the search form about `app\models\PregnancyCdssPatientExam`.
 */
class PregnancyCdssPatientExamSearch extends PregnancyCdssPatientExam
{
    public function attributes()
    {
    // add related fields to searchable attributes
    return array_merge(parent::attributes(), ['patientData.lname', 'patientData.fullName', 'formsData.deleted']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'authorized', 'activity', 'encounter', 'is_firstpregnancy', 'id_finaldisease'], 'integer'],
            [['date', 'user', 'groupname', 'createuser', 'createdate', 'expect_disease', 'diseases', 'finaldisease', 'finaldisease_icd10', 'patientData.lname', 'patientData.fullName', 'formsData.deleted'], 'safe'],
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
        $query = PregnancyCdssPatientExam::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // join with relation `formsData` that is a relation to the table `forms`
        // and set the table alias to be `formsData` (upd: table name get from model class by method)
        $query->joinWith(['formsData' => function($query) { $query->from(['formsData' => FormsData::tableName()]); }]);
                
        // enable sorting for the related column
        $dataProvider->sort->attributes['formsData.deleted'] = [
            'asc' => ['formsData.deleted' => SORT_ASC],
            'desc' => ['formsData.deleted' => SORT_DESC],
        ];
        
        // join with relation `patientData` that is a relation to the table `patient_data`
        // and set the table alias to be `patientData` (upd: table name get from model class by method)
        $query->joinWith(['patientData' => function($query) { $query->from(['patientData' => PatientData::tableName()]); }]);
        //$query->joinWith(['patientData']);
        
        $dataProvider->sort->attributes['patientData.fullName'] = [
            'asc' => ['patientData.lname' => SORT_ASC],
            'desc' => ['patientData.lname' => SORT_DESC],
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'pid' => $this->pid,
            'authorized' => $this->authorized,
            'activity' => $this->activity,
            'encounter' => $this->encounter,
            'createdate' => $this->createdate,
            'is_firstpregnancy' => $this->is_firstpregnancy,
            'id_finaldisease' => $this->id_finaldisease,
        ]);

        $query->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'groupname', $this->groupname])
            ->andFilterWhere(['like', 'createuser', $this->createuser])
            ->andFilterWhere(['like', 'expect_disease', $this->expect_disease])
            ->andFilterWhere(['like', 'diseases', $this->diseases])
            ->andFilterWhere(['like', 'finaldisease', $this->finaldisease])
            ->andFilterWhere(['like', 'finaldisease_icd10', $this->finaldisease_icd10]);
            
        $query->andFilterWhere(['like', 'patientData.lname', $this->getAttribute('patientData.fullName')]);

        return $dataProvider;
    }
}
