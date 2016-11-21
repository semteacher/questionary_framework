<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_pregnancycdss_diseases_sympt_opt".
 *
 * @property string $id
 * @property integer $id_diseases
 * @property string $id_sympt_opt
 * @property double $py
 * @property double $pn
 *
 * @property PregnancyCdssDiseases $deceaces
 * @property PregnancyCdssSymptOptions $symptOpt
 */
class PregnancyCdssDiseasesSymptOpt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_pregnancycdss_diseases_sympt_opt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_diseases', 'id_sympt_opt'], 'integer'],
            [['py', 'pn'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_diseases' => 'Id Diseases',
            'id_sympt_opt' => 'Id Sympt Opt',
            'py' => 'Py',
            'pn' => 'Pn',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiseases()
    {
        return $this->hasOne(PregnancyCdssDiseases::className(), ['id' => 'id_diseases']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSymptOpt()
    {
        return $this->hasOne(PregnancyCdssSymptOptions::className(), ['id' => 'id_sympt_opt']);
    }
}
