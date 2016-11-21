<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssPatientExamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-patient-exam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'groupname') ?>

    <?php // echo $form->field($model, 'authorized') ?>

    <?php // echo $form->field($model, 'activity') ?>

    <?php // echo $form->field($model, 'encounter') ?>

    <?php // echo $form->field($model, 'createuser') ?>

    <?php // echo $form->field($model, 'createdate') ?>

    <?php // echo $form->field($model, 'is_firstpregnancy') ?>

    <?php // echo $form->field($model, 'expect_disease') ?>

    <?php // echo $form->field($model, 'diseases') ?>

    <?php // echo $form->field($model, 'id_finaldisease') ?>

    <?php // echo $form->field($model, 'finaldisease') ?>

    <?php // echo $form->field($model, 'finaldisease_icd10') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
