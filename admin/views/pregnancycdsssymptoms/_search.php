<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptomsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregnancy-cdss-symptoms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    
    <?= $form->field($model, 'symptCategory.cat_name') ?>

    <?= $form->field($model, 'symp_name') ?>

    <?= $form->field($model, 'symp_notes') ?>

    <?= $form->field($model, 'id_order') ?>

    <?= $form->field($model, 'id_category') ?>

    <?php // echo $form->field($model, 'is_multi') ?>

    <?php // echo $form->field($model, 'is_selected') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
