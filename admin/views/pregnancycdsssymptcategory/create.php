<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptCategory */

$this->title = 'Create Pregnancy CDSS Symptom Category';
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy CDSS Symptom Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-sympt-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
