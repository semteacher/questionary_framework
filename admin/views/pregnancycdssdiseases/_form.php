<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssDiseases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-diseases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dis_name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'dis_note')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'dis_icd10')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'p')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
