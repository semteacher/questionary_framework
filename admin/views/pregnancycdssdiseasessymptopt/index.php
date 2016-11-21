<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper; // load classes
use app\models\PregnancyCdssDiseases;
use app\models\PregnancyCdssSymptoms;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PregnancyCdssDiseasesSymptOptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pregnancy CDSS: Diseases per Symptom Option';
$this->params['breadcrumbs'][] = $this->title;

$dataList_disease=ArrayHelper::map(PregnancyCdssDiseases::find()->asArray()->all(), 'id', 'dis_name');
$dataList_symptom=ArrayHelper::map(PregnancyCdssSymptoms::find()->asArray()->all(), 'id', 'symp_name');
?>
<div class="pregnancy-cdss-diseases-sympt-opt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pregnancy CDSS Diseases per Symptom Option', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'id_diseases',
                'label'=>'Disease Name',
                'format'=>'text',
                'filter'=>$dataList_disease,
                'value'=>'diseases.dis_name'
            ],
            [
                'attribute' => 'symptOpt.id_symptom',
                'label'=>'Symptom Name',
                'format'=>'text',
                'filter'=>$dataList_symptom,
                'value' => 'symptOpt.symptom.symp_name'
            ],
            [
                'attribute' => 'symptOpt.opt_name'
            ],
            'py',
            'pn',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
