<?php

namespace app\controllers;

use Yii;
use app\models\PregnancyCdssPatientExam;
use app\models\PregnancyCdssPatientExamSearch;
use app\models\PregnancyCdssSymptomsSearch;
use app\models\PregnancyCdssSymptOptions;
use app\models\PregnancyCdssSymptOptionsSearch;
use app\models\PregnancyCdssSymptoptByPatient;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use linslin\yii2\curl;

/**
 * PregnancyCdssPatientExamController implements the CRUD actions for PregnancyCdssPatientExam model.
 */
class PregnancyCdssPatientExamController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PregnancyCdssPatientExam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PregnancyCdssPatientExamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PregnancyCdssPatientExam model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PregnancyCdssPatientExam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PregnancyCdssPatientExam();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PregnancyCdssPatientExam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PregnancyCdssPatientExam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PregnancyCdssPatientExam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PregnancyCdssPatientExam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PregnancyCdssPatientExam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDecisiontreeeducationsubmit()
    {
        $searchModel = new PregnancyCdssPatientExamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $submitReport = 'Not implemented';

        $formsDataArray = $dataProvider->getModels();
        
        $symptomsSearchModel = new PregnancyCdssSymptomsSearch();
        $symptomsDataArray = $symptomsSearchModel->find()->where(['is_selected'=>'1'])->all();
        
        $submitArray = array();
        foreach ($formsDataArray as $formsDataObj) {
            if ($formsDataObj->id_finaldisease) {
            //construct row
            $row = array();
            $client_description = array();
            $client_decease = array();
            $client_data = array();
            
            $client_description = array_merge($client_description, ['url'=>$_SERVER['SERVER_NAME'], 'form_name' => 'Pregnancy CDSS Form', 'exam_id'=>intval($formsDataObj->id), 'patient_id'=>intval($formsDataObj->pid)]);
            $client_decease = array_merge($client_decease, ['decease_id'=>$formsDataObj->id_finaldisease, 'decease_name'=>$formsDataObj->finaldisease]);
            $row = array_merge($row,['client_description'=>$client_description]);
            $row = array_merge($row,['client_decease'=>$client_decease]);
            
            foreach ($symptomsDataArray as $symptomsDataObj) {
                //submit ALL symptoms record
                if ($symptomsDataObj->is_multi==1) {
                    //multiple choice symptom
                    $symptOptSearchModel = new PregnancyCdssSymptOptionsSearch();
                    $symptOptDataArray = $symptOptSearchModel->find()->where(['id_symptom'=>$symptomsDataObj->id])->all();
                    foreach ($symptOptDataArray as $symptOptDataObj) {
                        $patientChoice = PregnancyCdssSymptoptByPatient::findOne(['id_exam'=>$formsDataObj->id, 'pid'=>$formsDataObj->pid, 'id_symptom'=>$symptomsDataObj->id, 'id_sympt_opt'=>$symptOptDataObj->id]); 
                        if ($patientChoice) {
                            $patientChoiceName = PregnancyCdssSymptOptions::findOne(['id'=>$patientChoice->id_sympt_opt]);
                            $client_data = array_merge($client_data,[$symptomsDataObj->id=>['symp_id'=>$symptomsDataObj->id,'symp_name'=>$symptomsDataObj->symp_name,'opt_id'=>$patientChoice->id_sympt_opt, 'opt_name'=>$patientChoiceName->opt_name]]);
                        }
                    }
                } else {
                    //single choice symptom
                    $patientChoice = PregnancyCdssSymptoptByPatient::findOne(['id_exam'=>$formsDataObj->id, 'pid'=>$formsDataObj->pid, 'id_symptom'=>$symptomsDataObj->id]);
                    if ($patientChoice) {
                        $patientChoiceName = PregnancyCdssSymptOptions::findOne(['id'=>$patientChoice->id_sympt_opt]);
                        $client_data = array_merge($client_data,[$symptomsDataObj->id=>['symp_id'=>$symptomsDataObj->id,'symp_name'=>$symptomsDataObj->symp_name,'opt_id'=>$patientChoice->id_sympt_opt, 'opt_name'=>$patientChoiceName->opt_name]]);
                    }
                }
            }
            $row = array_merge($row, ['client_data'=>$client_data]);
            //ad new row to array
            $submitArray[]= $row;
            //$submitArray[]=['exam_id'=>intval($formsDataObj->id), 'patient_id'=>intval($formsDataObj->pid), 'decease'=>$formsDataObj->id_finaldisease];
            }
        }
        if ($submitArray) {
        //convert to json
        $submitArrayjson = Json::encode($submitArray);
        $subarrsize = sizeof($submitArray);
        //Init curl
        $curl = new curl\Curl();
        //post http://contactmgr.loc/
        $submitReport = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                http_build_query(array(
                    'submitArrayjson' => $submitArrayjson
                )
            ))
            ->post('http://contactmgr.loc/site/yii2curltest');
         }   
        return $this->render('dectreesubmit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'submitReport' => $submitReport,
            //'formsDataArray' => $formsDataArray,
            //'symptomsDataArray' => $symptomsDataArray,
            'submitArray' => $submitArray,
            'submitArrayjson' => $submitArrayjson,
            'subarrsize' => $subarrsize,
        ]);
    }
}
