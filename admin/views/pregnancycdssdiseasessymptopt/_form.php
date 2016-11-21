<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; // load classes
use app\models\PregnancyCdssDiseases;
use app\models\PregnancyCdssSymptOptions;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssDiseasesSymptOpt */
/* @var $form yii\widgets\ActiveForm */
$dataList_decease=ArrayHelper::map(PregnancyCdssDiseases::find()->asArray()->all(), 'id', 'dis_name');
$dataList_symptopt=ArrayHelper::map(PregnancyCdssSymptOptions::find()->with(['symptom'])->asArray()->all(), 'id', 'opt_name', 'symptom.symp_name');
?>

<div class="pregnancy-cdss-diseases-sympt-opt-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?=$form->field($model, 'id_diseases')->dropDownList($dataList_decease,
        ['prompt'=>'--- Choose a Disease: ---']) ?>
    
    <?=$form->field($model, 'id_sympt_opt')->dropDownList($dataList_symptopt,
        ['prompt'=>'--- Choose a Symptom Option: ---']) ?>

    <?= $form->field($model, 'py')->textInput() ?>

    <?= $form->field($model, 'pn')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
