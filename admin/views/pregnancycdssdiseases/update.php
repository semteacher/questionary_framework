<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssDiseases */

$this->title = 'Update Pregnancy CDSS Deceace: ' . ' ' . $model->dis_name;
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy CDSS Diseases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pregnancy-cdss-diseases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
