<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssDiseasesSymptOptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-diseases-sympt-opt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_diseases') ?>

    <?= $form->field($model, 'id_sympt_opt') ?>

    <?= $form->field($model, 'py') ?>

    <?= $form->field($model, 'pn') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
