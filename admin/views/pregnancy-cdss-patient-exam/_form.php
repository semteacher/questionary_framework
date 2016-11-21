<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssPatientExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-patient-exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'pid')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'user')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'groupname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'authorized')->textInput() ?>

    <?= $form->field($model, 'activity')->textInput() ?>

    <?= $form->field($model, 'encounter')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'createuser')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'createdate')->textInput() ?>

    <?= $form->field($model, 'is_firstpregnancy')->textInput() ?>

    <?= $form->field($model, 'expect_disease')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'diseases')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_finaldisease')->textInput() ?>

    <?= $form->field($model, 'finaldisease')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'finaldisease_icd10')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
