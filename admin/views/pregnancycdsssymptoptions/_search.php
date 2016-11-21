<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptOptionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-sympt-options-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?//= $form->field($model, 'id_symptom') ?>
    
    <?= $form->field($model, 'symptom.symp_name') ?>

    <?= $form->field($model, 'opt_name') ?>

    <?= $form->field($model, 'id_order') ?>

    <?= $form->field($model, 'is_selected') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
