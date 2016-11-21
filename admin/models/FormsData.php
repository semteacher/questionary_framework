<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property string $id
 * @property string $date
 * @property string $encounter
 * @property string $form_name
 * @property string $form_id
 * @property string $pid
 * @property string $user
 * @property string $groupname
 * @property integer $authorized
 * @property integer $deleted
 * @property string $formdir
 */
class FormsData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['encounter', 'form_id', 'pid', 'authorized', 'deleted'], 'integer'],
            [['form_name', 'formdir'], 'string'],
            [['user', 'groupname'], 'string', 'max' => 255]
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
            'encounter' => 'Encounter',
            'form_name' => 'Form Name',
            'form_id' => 'Form ID',
            'pid' => 'Pid',
            'user' => 'User',
            'groupname' => 'Groupname',
            'authorized' => 'Authorized',
            'deleted' => 'Deleted',
            'formdir' => 'Formdir',
        ];
    }
    
    //override find() method to process only rows which are related to the Pregnancy CDSS Form (non-deleted only) 
    public static function find()
    {
        return parent::find()->where(['form_name' => 'Pregnancy CDSS Form', 'deleted'=>'0']);
    }
}
