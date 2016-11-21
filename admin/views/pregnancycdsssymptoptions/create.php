<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptOptions */

$this->title = 'Create Pregnancy CDSS Symptom Options';
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy CDSS Symptom Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-sympt-options-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
