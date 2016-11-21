<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_pregnancycdss_deceaces".
 *
 * @property integer $id
 * @property string $dis_name
 * @property string $dis_note
 * @property string $dis_icd10
 * @property double $p
 *
 * @property FormPregnancycdssDiseasesSymptOpt[] $formPregnancycdssDiseasesSymptOpts
 */
class PregnancyCdssDiseases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_pregnancycdss_diseases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p'], 'number'],
            [['dis_name'], 'string', 'max' => 100],
            [['dis_note'], 'string', 'max' => 255],
            [['dis_icd10'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dis_name' => 'Disease Name',
            'dis_note' => 'Dis. Note',
            'dis_icd10' => 'ICD10 Code',
            'p' => 'P',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormPregnancycdssDiseasesSymptOpts()
    {
        return $this->hasMany(PregnancyCdssDiseasesSymptOpt::className(), ['id_diseases' => 'id']);
    }
}
