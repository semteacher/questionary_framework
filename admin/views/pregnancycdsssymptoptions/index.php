<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PregnancyCdssSymptOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pregnancy CDSS Symptom Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-sympt-options-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pregnancy CDSS Sympt Option', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            //'id_symptom',
            [
            'attribute' => 'symptom.symp_name'           
            ],            
            'opt_name',
            [
            'attribute' => 'is_selected',
            'format' => 'boolean',
            'filter'=>array("0"=>"No","1"=>"Yes"),
            ], 
            'id_order',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
