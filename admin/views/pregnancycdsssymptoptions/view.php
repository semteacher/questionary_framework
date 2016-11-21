<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptOptions */

$this->title = $model->opt_name;
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy CDSS Symptom Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-sympt-options-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'id_symptom',
            [
            'attribute' => 'symptom.symp_name'
            ],            
            'opt_name',
            'id_order',
            [
            'attribute' => 'is_selected',
            'format' => 'boolean'
            ],
        ],
    ]) ?>

</div>
