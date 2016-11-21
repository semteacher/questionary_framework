<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssDiseasesSymptOpt */

$this->title = 'Create Pregnancy Cdss Deceases Sympt Opt';
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy Cdss Deceases Sympt Opts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-diseases-sympt-opt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
