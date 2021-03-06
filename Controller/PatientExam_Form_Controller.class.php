<?php

require_once ($GLOBALS['fileroot'] . "/library/forms.inc");

require_once(MODEL_DIR."SymptByPatient_Model.class.php");
require_once(MODEL_DIR."SymptCategory_Model.class.php");
require_once(MODEL_DIR."Symptoms_Model.class.php");
require_once(MODEL_DIR."SymptOptions_Model.class.php");
require_once(MODEL_DIR."DiseasesSymptOpt_Model.class.php");
require_once(MODEL_DIR."Diseases_Model.class.php");

require_once(MODEL_DIR."Symptoms2Patients_Model.class.php");

require_once(VIEW_DIR."SymptByPatient_Form2Report.class.php");
require_once(VIEW_DIR."SymptByPatient_Form2Print.class.php");

//main controller class
class PatientExam_Form_Controller {

    public $form_folder;
    public $gaeScriptName;
    public $form_idexam;
    public $form_pid;
    public $returnurl;
    public $form_mode;
    public $table_name;
    public $form_encounter;
    public $form_userauthorized;
    public $is_firstpregnancy;
    public $createdate;
    public $expectdiseaseid;
    public $id_finaldisease;
    public $finaldisease;
    public $expectdiseasename;
    public $symptbypatient;

    function PatientExam_Form_Controller() {
        $this->form_folder = FORM_FOLDER;
        $this->gaeScriptName = GAE_SCRIPT_NAME;
        $this->form_name = FORM_NAME;
        $this->table_name = PATIENTEXAM_DBTABLE;
        $this->form_encounter = $_SESSION['encounter'];
        $this->form_pid = $_SESSION['pid'];
        $this->form_userauthorized = $_SESSION['userauthorized'];
        $this->returnurl =$GLOBALS['form_exit_url'];
        $this->is_firstpregnancy = NULL;
        $this->createdate = NULL;
        $this->id_finaldisease = 0;
        $this->finaldisease = NULL;
        $this->expectdiseaseid = 0;
        $this->expectdiseasename = NULL;
    }
    
    public function default_action() {
        $this->form_name = "Pregnancy CDSS (default) Form";
        //get all form options (nested mode)
        $SymptCategory = SymptCategory_Model::all();
        //display form
        require_once(VIEW_DIR.'SymptByPatient2_Form.html');
        return;
	}

    public function new_action() {
        //check gender
        $gender = getPatientData($_SESSION['pid'], 'sex');
        if ($gender[sex]=='Female'){
            $this->form_name = "Pregnancy CDSS (new) Form";
            $this->form_mode = "new";
            $this->createdate = date("Y-m-d H:i:s", time());

            //get all form options (nested mode)
            $SymptCategory = SymptCategory_Model::all();
        //get all diseases names
        $Diseases = Diseases_Model::all();
            //display form
            require_once(VIEW_DIR.'SymptByPatient2_Form.html');
        } else{
            //error message
            echo '<script language="javascript">alert("Дана форма не може бути застосована до осіб чоловічої статі!")</script>';
            //redirect to encounter
            @formJump();
        }
        return;
    }

	public function view_action($form_idexam) {
        //show form patient data
        $form_idexam = intval($form_idexam);
        //fetch form data
        $form_data = formFetch($this->table_name, $form_idexam);

		if ($form_data) {
            $this->form_idexam = $form_idexam;
            //var_dump($form_data);
            $this->is_firstpregnancy = $form_data[is_firstpregnancy];
            $this->createdate = $form_data[createdate];
            $this->id_finaldisease = $form_data[id_finaldisease];
           // $this->form_pid = $_SESSION['pid'];
    	}
    	else {
    		//error??
    	}
        $this->form_name = "Pregnancy CDSS (view) Form";
        $this->form_mode = "update";
        //get all form options (nested mode)
    	$SymptCategory = SymptCategory_Model::all();
        //get all diseases names
        $Diseases = Diseases_Model::all();
        //var_dump($SymptCategory);
        //var_dump($Diseases);
        //display form
        require_once(VIEW_DIR.'SymptByPatient2_Form.html');
        //$report_form = new SymptByPatient_Form($this, $SymptCategory);
        return;

	}
    
    protected function getCurrDiseasesMultiTable_action($form_data) {
    //set diseases names
            $curr_diseases_multi = array();
            $curr_diseases_multi = unserialize($form_data[diseases]);
            $diseases = new Diseases2_Model();
            foreach ($curr_diseases_multi as $disease_id=>$dec_symmary) {
                if ($diseases->Load('id='.$disease_id)){
                    $dec_symmary[dis_name] = $diseases->dis_name;
                    $curr_diseases_multi[$disease_id][dis_name] = $diseases->dis_name;
                } else {
                    //db error
                    $dec_symmary[dis_name] = "Інший діагноз";
                    $curr_diseases_multi[$disease_id][dis_name] = "Інший діагноз";
                }
            }
        return $curr_diseases_multi;
    }

    public function report_action($form_idexam) {
        //show form report on the encounter page
        $form_idexam = intval($form_idexam);
        //fetch form data
        $form_data = formFetch($this->table_name, $form_idexam);
        if ($form_data) {
            $this->id_finaldisease = $form_data[id_finaldisease];
            $this->finaldisease = $form_data[finaldisease];
            //set diseases names
            $currDiseasesMulti = $this->getCurrDiseasesMultiTable_action($form_data);            
            //display form
            $report_form = new SymptByPatient_Form2Report($form_data, $currDiseasesMulti, $this->form_folder, $this->gaeScriptName);
        }
        return;
    }
            
    public function gaeDecisionTreeAjsx_action($form_idexam) {
        //show form report on the encounter page
        $form_idexam = intval($form_idexam);
        //fetch form data
        $form_data = formFetch($this->table_name, $form_idexam);
        
        //construct row of the result`s table
        $submitArray = array();
        $row = array();
        $client_description = array();
        $client_disease = array();
        $client_data = array();
        
        //prepare array with form data
        $client_description = array_merge($client_description, ['url'=>$_SERVER['SERVER_NAME'], 'form_name' => $this->form_name, 'exam_id'=>$form_idexam, 'patient_id'=>$this->form_pid]);
        $row = array_merge($row,['client_description'=>$client_description]);
        $row = array_merge($row,['client_disease'=>$client_disease]);
        
        //prepare array with symptoms list
        $Symptoms = Symptoms_Model::all();
        $symptoptbyperson = new SymptByPatient2_Model();//prepare tmp record
        $tmpsymptoptdata = new SymptOptions2_Model();//prepare tmp record
        //process all symptoms:
        foreach ($Symptoms as $key=>$Symptom) {
            //check symptom type:
            if (Symptoms_Model::is_multy($Symptom->id)) {
                //Symptom can have multiple options
                foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                //load EACH symptom options by this patient
                    if ($symptoptbyperson->Load('(id_exam='.$form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')AND(id_sympt_opt='.$SympOption->id.')')) {
                        if ($tmpsymptoptdata->Load('id='.$symptoptbyperson->id_sympt_opt)) {
                            //add to the row of the resulted array
                            $client_data = array_merge($client_data,[$Symptom->id=>['symp_id'=>$Symptom->id,'symp_name'=>$Symptom->symp_name,'opt_id'=>$symptoptbyperson->id_sympt_opt, 'opt_name'=>$tmpsymptoptdata->opt_name]]);
                        }
                    }
                }
            } else {
                //load SINGLE symptom option by this patient
                if ($symptoptbyperson->Load('(id_exam='.$form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')')) {
                    if ($tmpsymptoptdata->Load('id='.$symptoptbyperson->id_sympt_opt)) {
                        //add to the row of the resulted array
                        $client_data = array_merge($client_data,[$Symptom->id=>['symp_id'=>$Symptom->id,'symp_name'=>$Symptom->symp_name,'opt_id'=>$symptoptbyperson->id_sympt_opt, 'opt_name'=>$tmpsymptoptdata->opt_name]]);
                    }                
                }
            }
            //Var_dump($Symptom->id);            
            //var_dump($symptoptbyperson);   
        }
        $row = array_merge($row, ['client_data'=>$client_data]);
        //ad new row to array
        $submitArray[]= $row;
        //convert to json
        $submitArrayjson = json_encode($submitArray);
        return $submitArrayjson;
    }
    
    public function decisiontreegae_action($form_idexam) {
        //show form report on the encounter page
        $form_idexam = intval($form_idexam);
        //fetch form data
        $form_data = formFetch($this->table_name, $form_idexam);

        //TODO: process GAE submission there....
        //construct row
        $submitArray = array();
        $row = array();
        $client_description = array();
        $client_disease = array();
        $client_data = array();
        //prepare array with form data
        $client_description = array_merge($client_description, ['url'=>$_SERVER['SERVER_NAME'], 'form_name' => $this->form_name, 'exam_id'=>$form_idexam, 'patient_id'=>$this->form_pid]);
        $row = array_merge($row,['client_description'=>$client_description]);
        $row = array_merge($row,['client_disease'=>$client_disease]);
        //var_dump($client_description);
        //prepare array with symptoms list
        $Symptoms = Symptoms_Model::all();
        //process all symptoms:
        foreach ($Symptoms as $key=>$Symptom) {
            $symptoptbyperson = new SymptByPatient2_Model();//prepare tmp record
            //check symptom type:
            if (Symptoms_Model::is_multy($Symptom->id)) {
                //Symptom can have multiple options
                foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                //TODO:???????????????????????????????????????????????????????
                    //load EACH symptom options by this patient
                    $symptoptbyperson->Load('(id_exam='.$form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')AND(id_sympt_opt='.$SympOption->id.')');
                }
            } else {
                //load single symptom option by this patient
                $symptoptbyperson->Load('(id_exam='.$form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')');
                $tmpsymptoptdata = new SymptOptions2_Model();//prepare tmp record
                $tmpsymptoptdata->Load('id='.$symptoptbyperson->id_sympt_opt);
                
                $client_data = array_merge($client_data,[$Symptom->id=>['symp_id'=>$Symptom->id,'symp_name'=>$Symptom->symp_name,'opt_id'=>$symptoptbyperson->id_sympt_opt, 'opt_name'=>$tmpsymptoptdata->opt_name]]);
            }
            //Var_dump($Symptom->id);            
            //var_dump($symptoptbyperson);   
        }
        $row = array_merge($row, ['client_data'=>$client_data]);
        //ad new row to array
        $submitArray[]= $row;
        //convert to json
        $submitArrayjson = json_encode($submitArray);
var_dump($submitArray); 
        //TODO: submit array to GAE....
        $url = 'http://contactmgr.loc/site/yii2curltest';
// The submitted form data, encoded as query-string-style
// name-value pairs
$c = curl_init($url);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELDS, $submitArrayjson);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
var_dump($page);
        die;
        
        //redirect back to encounter....
        header('Location: '.$GLOBALS['webroot'] .$this->returnurl);
        

        
        
        if ($form_data) {
            $this->id_finaldisease = $form_data[id_finaldisease];
            $this->finaldisease = $form_data[finaldisease];
            //set diseases names
            $currDiseasesMulti = $this->getCurrDiseasesMultiTable_action($form_data);            
            $curr_diseases_multi = array();
            $curr_diseases_multi = unserialize($form_data[diseases]);
            $diseases = new Diseases2_Model();
            foreach ($curr_diseases_multi as $disease_id=>$dec_symmary) {
                if ($diseases->Load('id='.$disease_id)){
                    $dec_symmary[dis_name] = $diseases->dis_name;
                    $curr_diseases_multi[$disease_id][dis_name] = $diseases->dis_name;
                } else {
                    //db error
                    $dec_symmary[dis_name] = "Інший діагноз";
                    $curr_diseases_multi[$disease_id][dis_name] = "Інший діагноз";
                }
            }
            //display form
            $report_form = new SymptByPatient_Form2Report($form_data, $curr_diseases_multi);
        } else {
            return;
        }
        return;
    }

    public function print_action($form_idexam) {
        //print patient form exam data
        $form_idexam = intval($form_idexam);
        //get patient data
        $patient = getPatientData($_SESSION['pid']);
        //var_dump($patient);
        //fetch form data
        $form_data = formFetch($this->table_name, $form_idexam);
        //var_dump($form_data);
        if ($form_data) {
            $currDiseasesMulti = $this->getCurrDiseasesMultiTable_action($form_data);

            //get patient exam data
            $symptcat = new SymptCategory2_Model;
            $symprom = new Symptoms2_Model;
            $sympt_opt = new SymptOptions2_Model;
            $symptbypatientarr = array();
            $symptbypatient = SymptByPatient_Model::find($form_idexam);
            //set diseases names
            $diseases = new Diseases2_Model();
            foreach ($symptbypatient as $key=>$SymptByPatientModel) {
                $symptcat->Load('id='.$SymptByPatientModel->id_sympt_cat);
                $symprom->Load('id='.$SymptByPatientModel->id_symptom);
                $sympt_opt->Load('id='.$SymptByPatientModel->id_sympt_opt);                
                $symptbypatientarr[$key][id_sympt_cat]=$SymptByPatientModel->id_sympt_cat;
                $symptbypatientarr[$key][sympt_cat_name]=$symptcat->cat_name;
                $symptbypatientarr[$key][id_symptom]=$SymptByPatientModel->id_symptom;
                $symptbypatientarr[$key][symptom_name]=$symprom->symp_name;
                $symptbypatientarr[$key][id_sympt_opt]=$SymptByPatientModel->id_sympt_opt;
                $symptbypatientarr[$key][sympt_opt_name]=$sympt_opt->opt_name;
                //print diseases if exist
                if ($diseases->Load('id='.$SymptByPatientModel->id_diseases)) {
                    $symptbypatientarr[$key][id_diseases]=$SymptByPatientModel->id_diseases;
                    $symptbypatientarr[$key][dis_name]=$diseases->dis_name;
                }
            }
            //display form
            $report_form = new SymptByPatient_Form2Print($this, $patient, $form_data, $currDiseasesMulti, $symptbypatientarr);
        } else {
            return;
        }
        return;
    }
	
    public function probability_diseases_action($symptom_array){
        //prepare default diseases array
        $curr_disease_multi = array();
        $disease = new Diseases2_Model();
        $diseases_arr = $disease->Find('');

        foreach ($diseases_arr as $dec){
            //default - each disease probability =1
            $curr_disease_multi[$dec->id][py]=1;
            $curr_disease_multi[$dec->id][pn]=1;
            $curr_disease_multi[$dec->id][count]=0;
        }
        $expectdiseasecount = 0;

        //process form submissions
        $diseasesymptopt = new DiseasesSymptOpt2_Model();
        foreach ($symptom_array as $sympt_id=>$sympt_options) {
            foreach ($sympt_options as $key=>$id_sympt_opt) {
                if ($diseasesymptopt->Load('id_sympt_opt='.$id_sympt_opt))
                {
                    $curr_disease_multi[$diseasesymptopt->id_diseases][py]=$curr_disease_multi[$diseasesymptopt->id_diseases][py]*$diseasesymptopt->py;
                    $curr_disease_multi[$diseasesymptopt->id_diseases][pn]=$curr_disease_multi[$diseasesymptopt->id_diseases][pn]*$diseasesymptopt->pn;
                    $curr_disease_multi[$diseasesymptopt->id_diseases][count]=$curr_disease_multi[$diseasesymptopt->id_diseases][count]+1;
                    //define most expected disease
                    if ($curr_disease_multi[$diseasesymptopt->id_diseases][count] > $expectdiseasecount) {
                        $this->expectdiseaseid = $diseasesymptopt->id_diseases;
                        $expectdiseasecount = $curr_disease_multi[$diseasesymptopt->id_diseases][count];
                    }
                }
            }
        }
        //Get most expected disease name
        $disease->Load('id='.$this->expectdiseaseid);
        $this->expectdiseasename = $disease->dis_name;
        //Get final disease name (if exist)
        if  ($this->id_finaldisease > 0) {
            $disease->Load('id='.$this->id_finaldisease);
            $this->finaldisease = $disease->dis_name;
        } else {
            $this->finaldisease = '';
        }
        
        return $curr_disease_multi;
    }
    
    public function save_action_process() {

        $this->form_idexam = $_POST['id'];
        if ($_POST['pid']) {$this->form_pid = $_POST['pid'];}else{$this->form_pid = $_SESSION['pid'];}
        if ($_POST['isfirstpregnancyhd']) {$this->is_firstpregnancy = intval($_POST['isfirstpregnancyhd']);}else{$this->is_firstpregnancy = NULL;}
        if ($_POST['finaldiseasedd']) {$this->id_finaldisease = intval($_POST['finaldiseasedd']);}else{$this->is_firstpregnancy = 0;}
        if ($_POST['createdate']) {$this->createdate = $_POST['createdate'];}else{$this->createdate = NULL;}
        $this->form_encounter = $_SESSION['encounter'];
        $this->form_userauthorized = $_SESSION['userauthorized'];

        //get disease - probability method
        $curr_disease_multi = array();
        $curr_disease_multi = $this->probability_diseases_action($_POST['symptom_options']);
        $ser_curr_disease_multi=serialize($curr_disease_multi);

        //save new/update patient form data
        if ($_GET["mode"] == "new") {

            /* NOTE - for customization you can replace $_POST with your own array
             * of key=>value pairs where 'key' is the table field name and
             * 'value' is whatever it should be set to
             * ex)   $newrecord['parent_sig'] = $_POST['sig'];
             *       $newid = formSubmit($table_name, $newrecord, $_GET["id"], $userauthorized);
             */

            /* save the data into the form's own table */
            $newid = formSubmit($this->table_name, array('encounter'=>$this->form_encounter, 'createuser'=>$_SESSION['authUser'], 'createdate'=>$this->createdate, 'is_firstpregnancy'=>$this->is_firstpregnancy, 'expect_disease'=> $this->expectdiseasename,'diseases'=>$ser_curr_disease_multi, 'id_finaldisease'=>$this->id_finaldisease, 'finaldisease'=>$this->finaldisease), $_GET["id"], $this->form_userauthorized);

            $this->form_idexam = $newid;
            /* link the form to the encounter in the 'forms' table */
            addForm($this->form_encounter, $this->form_name, $newid, $this->form_folder, $this->form_pid, $this->form_userauthorized);
        }
        elseif ($_GET["mode"] == "update") {
            /* update existing record */
            $success = formUpdate($this->table_name, array('encounter'=>$this->form_encounter, 'is_firstpregnancy'=>$this->is_firstpregnancy, 'expect_disease'=> $this->expectdiseasename, 'diseases'=>$ser_curr_disease_multi, 'id_finaldisease'=>$this->id_finaldisease, 'finaldisease'=>$this->finaldisease), $_GET["id"], $this->form_userauthorized);
        } else {
            //TODO: throw error
            return;
        }

        //save new/update patient details
        //prepare tmp record
        $diseasesymptopt = new DiseasesSymptOpt2_Model();
        $symptoptbyperson = new SymptByPatient2_Model();
        //process all symptoms:
        $Symptoms = Symptoms_Model::all();
        foreach ($Symptoms as $key=>$Symptom) {
            //process all symptom options:
            foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                //is it symptom option in POST?
                $key = array_search($SympOption->id,$_POST['symptom_options'][$Symptom->id]);
                //is it symptom option in database?                
                if (SymptByPatient_Model::isselected($this->form_idexam, $this->form_pid, $Symptom->id, $SympOption->id)) {
                    if ($key === false || is_null($key)){
                        //CASE_1: symptom option is in database but not in POST: it is unselected and will be DELETED
                        $symptoptbyperson->Load('(id_exam='.$this->form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')AND(id_sympt_opt='.$SympOption->id.')');
                        $symptoptbyperson->delete();
                    } else {
                        //CASE_2: symptom option is in database and in POST: it will be UPADTED                
                        $symptoptbyperson->Load('(id_exam='.$this->form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')AND(id_sympt_opt='.$SympOption->id.')');
                        if ($diseasesymptopt->Load('id_sympt_opt='.$symptoptbyperson->id_sympt_opt)) {                
                            //add stat. information about possible disease by this symptom option (if exist)
                            $symptoptbyperson->id_diseases = $diseasesymptopt->id_diseases;
                            $symptoptbyperson->py = $diseasesymptopt->py;
                            $symptoptbyperson->pn = $diseasesymptopt->pn;
                        }
                        //save changes to DB
                        $symptoptbyperson->save();
                    }
                } else {
                    if (is_int($key)) {
                        //CASE_3: symptom option is NOT in database but it is in POST: it will be ADDED
                        $symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->id_exam = $this->form_idexam;
                        $symptoptbyperson->pid  = $this->form_pid;
                        $symptoptbyperson->user = $_SESSION['authUser'];
                        $symptoptbyperson->id_symptom = $Symptom->id;
                        $symptoptbyperson->id_sympt_cat = $Symptom->id_category;
                        $symptoptbyperson->id_order = $Symptom->id_order;
                        $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][$key];

                        if ($diseasesymptopt->Load('id_sympt_opt='.$symptoptbyperson->id_sympt_opt)) {
                            //add stat. information about possible disease by this symptom option (if exist)
                            $symptoptbyperson->id_diseases = $diseasesymptopt->id_diseases;
                            $symptoptbyperson->py = $diseasesymptopt->py;
                            $symptoptbyperson->pn = $diseasesymptopt->pn;
                        }
                        //save changes to DB
                        $symptoptbyperson->save();                
                    } else {
                        //CASE_3: symptom option is NOT in database and is NOT in POST: it will be SKIPPED
                    }
                }
            }
        }
//die;
		return;
	} 
}

?>