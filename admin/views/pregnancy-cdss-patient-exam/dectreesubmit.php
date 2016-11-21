<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper; // load classes
use app\models\PregnancyCdssDiseases;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PregnancyCdssPatientExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pregnancy Cdss Patient Exams';
$this->params['breadcrumbs'][] = $this->title;

$dataList_decease=ArrayHelper::map(PregnancyCdssDiseases::find()->asArray()->all(), 'dis_name', 'dis_name');

//var_dump($dataProvider);
//var_dump($formsDataArray);
var_dump($submitArray);
//VarDumper::dump($submitArray);
print_r('<br>');
print_r($submitArrayjson);
print_r('<br>');
//print_r(Json::decode($submitArrayjson));
?>
<div class="pregnancy-cdss-patient-exam-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Submit ALL records with existing final decease to GAE Deceases Tree Service as educational sets', ['decisiontreeeducationsubmit'], ['class' => 'btn btn-success']) ?>
    </p>
        <p>
        <?= Html::encode('Submited: '.$subarrsize.' of data') ?>
    </p>
    <p>
        <?= Html::encode('Response: '.$submitReport) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'date',
            //'pid',
            //'attribute' => 'patientData.lname',
            'attribute' => 'patientData.fullName',
            //'groupname',
            // 'authorized',
            // 'activity',
            // 'encounter',
            // 'createuser',
             'createdate',
             //'is_firstpregnancy',
            [
            'attribute' => 'is_firstpregnancy',
            'format' => 'boolean',
            'filter'=>array("0"=>"No","1"=>"Yes"),
            ], 
             //'expect_disease',
            [
                'attribute' => 'expect_disease',
                'format'=>'text',
                'filter'=>$dataList_decease,
                'value'=>'expect_disease'
            ],             
            // 'diseases:ntext',
            // 'id_finaldisease',
            // 'finaldisease',
            [
                'attribute' => 'finaldisease',
                'format'=>'text',
                'filter'=>$dataList_decease,
                'value'=>'finaldisease'
            ],
            // 'finaldisease_icd10',
            'user',
            [
            'attribute' => 'formsData.deleted',
            'format' => 'boolean',
            'filter'=>array("0"=>"No","1"=>"Yes"),
            ],
            
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {dectreechek}',
             'buttons' => [
	                'dectreechek' => function ($url,$model) {
	                    return Html::a(
                        '<span class="glyphicon glyphicon-user"></span>', 
                       $url);
	                },
                   ],
            ],
        ],
    ]); ?>

</div>
