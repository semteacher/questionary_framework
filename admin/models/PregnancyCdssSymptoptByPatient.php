<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_pregnancycdss_symptopt_by_patient".
 *
 * @property string $id
 * @property string $id_exam
 * @property string $pid
 * @property string $user
 * @property string $id_symptom
 * @property string $id_sympt_opt
 * @property integer $id_diseases
 * @property double $py
 * @property double $pn
 * @property integer $id_sympt_cat
 * @property integer $id_order
 *
 * @property FormPregnancycdssPatientExam $idExam
 */
class PregnancyCdssSymptoptByPatient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_pregnancycdss_symptopt_by_patient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_exam', 'pid', 'id_symptom', 'id_sympt_opt', 'id_diseases', 'id_sympt_cat', 'id_order'], 'integer'],
            [['py', 'pn'], 'number'],
            [['user'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_exam' => 'Id Exam',
            'pid' => 'Pid',
            'user' => 'User',
            'id_symptom' => 'Id Symptom',
            'id_sympt_opt' => 'Id Sympt Opt',
            'id_diseases' => 'Id Diseases',
            'py' => 'Py',
            'pn' => 'Pn',
            'id_sympt_cat' => 'Id Sympt Cat',
            'id_order' => 'Id Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdExam()
    {
        return $this->hasOne(PregnancyCdssPatientExam::className(), ['id' => 'id_exam']);
    }
}
