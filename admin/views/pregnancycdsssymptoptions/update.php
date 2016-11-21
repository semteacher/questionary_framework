<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptOptions */

$this->title = 'Update Pregnancy CDSS Symptom Options: ' . ' ' . $model->opt_name;
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy CDSS Symptom Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pregnancy-cdss-sympt-options-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
