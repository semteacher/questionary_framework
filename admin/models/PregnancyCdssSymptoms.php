<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_pregnancycdss_symptoms".
 *
 * @property string $id
 * @property string $symp_name
 * @property string $symp_notes
 * @property integer $id_order
 * @property integer $id_category
 * @property integer $is_multi
 * @property integer $is_selected
 *
 * @property PregnancyCdssSymptOptions[] $pregnancyCdssSymptOptions
 * @property PregnancyCdssSymptCategory $symptCategory
 */
class PregnancyCdssSymptoms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_pregnancycdss_symptoms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_order', 'id_category', 'is_multi', 'is_selected'], 'integer'],
            [['symp_name'], 'string', 'max' => 50],
            [['symp_notes'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symp_name' => 'Symp Name',
            'symp_notes' => 'Symp Notes',
            'id_order' => 'Id Order',
            'id_category' => 'Id Category',
            'is_multi' => 'Is Multi',
            'is_selected' => 'Is Selected',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPregnancyCdssSymptOptions()
    {
        return $this->hasMany(PregnancyCdssSymptOptions::className(), ['id_symptom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSymptCategory()
    {
        return $this->hasOne(PregnancyCdssSymptCategory::className(), ['id' => 'id_category']);
    }
}
