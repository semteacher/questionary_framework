<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssPatientExam */

$this->title = 'Create Pregnancy Cdss Patient Exam';
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy Cdss Patient Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-patient-exam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
