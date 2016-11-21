<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_pregnancycdss_patient_exam".
 *
 * @property string $id
 * @property string $date
 * @property string $pid
 * @property string $user
 * @property string $groupname
 * @property integer $authorized
 * @property integer $activity
 * @property string $encounter
 * @property string $createuser
 * @property string $createdate
 * @property integer $is_firstpregnancy
 * @property string $expect_disease
 * @property string $diseases
 * @property integer $id_finaldisease
 * @property string finaldisease
 * @property string $finaldisease_icd10
 *
 * @property FormPregnancycdssSymptoptByPatient[] $formPregnancycdssSymptoptByPatients
 */
class PregnancyCdssPatientExam extends \yii\db\ActiveRecord
{
    public $formName = 'Pregnancy CDSS Form';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_pregnancycdss_patient_exam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'createdate'], 'safe'],
            [['pid', 'authorized', 'activity', 'encounter', 'is_firstpregnancy', 'id_finaldisease'], 'integer'],
            [['diseases'], 'string'],
            [['user', 'groupname', 'createuser', 'expect_disease', 'finaldisease', 'finaldisease_icd10'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'pid' => 'Pid',
            'user' => 'User',
            'groupname' => 'Groupname',
            'authorized' => 'Authorized',
            'activity' => 'Activity',
            'encounter' => 'Encounter',
            'createuser' => 'Create User',
            'createdate' => 'Create Date',
            'is_firstpregnancy' => 'First Pregnancy',
            'expect_disease' => 'Expect Disease',
            'diseases' => 'Diseases',
            'id_finaldisease' => 'Id FinalDisease',
            'finaldisease' => 'Final Disease',
            'finaldisease_icd10' => 'FinalDisease ICD10',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPregnancyCdssSymptoptByPatients()
    {
        return $this->hasMany(PregnancyCdssSymptoptByPatient::className(), ['id_exam' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatientData()
    {
        return $this->hasOne(PatientData::className(), ['pid' => 'pid']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormsData()
    {
        return $this->hasOne(FormsData::className(), ['form_id' => 'id']);
        //return $this->hasOne(FormsData::className(), ['form_id' => 'id','form_name'=>'formName']);
    }
}
