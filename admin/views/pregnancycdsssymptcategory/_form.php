<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-sympt-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'cat_notes')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'is_selected')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
