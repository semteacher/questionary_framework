<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PregnancyCdssSymptoms */

$this->title = $model->symp_name;
$this->params['breadcrumbs'][] = ['label' => 'Pregnancy CDSS Symptoms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-symptoms-view">

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
            //'id_category',
            [
            'attribute' => 'symptCategory.cat_name'
            ],
            'symp_name',
            'symp_notes',
            [
            'attribute' => 'is_multi',
            'format' => 'boolean'
            ],            
            [
            'attribute' => 'is_selected',
            'format' => 'boolean'
            ],
            'id_order',
        ],
    ]) ?>

</div>
