<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PregnancyCdssSymptomsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pregnancy CDSS Symptoms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregnancy-cdss-symptoms-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pregnancy CDSS Symptoms', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            //'id_category',
            [
            'attribute' => 'symptCategory.cat_name'
            //'attribute' => 'id_category',
            //'value' => 'symptCategory.cat_name'            
            ],
            'symp_name',
            [
            'attribute' => 'is_multi',
            'format' => 'boolean',
            'filter'=>array("0"=>"No","1"=>"Yes"),
            ],              
            [
            'attribute' => 'is_selected',
            'format' => 'boolean',
            'filter'=>array("0"=>"No","1"=>"Yes"),
            ],           
            'symp_notes',
            'id_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
