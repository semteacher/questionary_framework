<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Session;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        //check session
        $session = Yii::$app->session;
        if (!$session->isActive) {
            // open a session if need
            $session->open();
        }

        //TODO:require to implement the User model based on the OpenEMR 'user' table
        //if (!\Yii::$app->user->isGuest) {
        $openemr_user = '';
        $session_user = '';
        if (isset($_GET['authUser'])){
            $openemr_user = $_GET['authUser'];
        }
        if (isset($session['openEMRauthUser'])){
            $session_user = $session['openEMRauthUser'];
        }
        
        if ($openemr_user=='admin'){
                $session['openEMRauthUser'] = $openemr_user;
                $this->setAppName();
                return $this->render('index');
                //return PregnancyCdssDeceacesController::actionIndex();
                //return PregnancyCdssDeceacesController->render('index');
        } elseif ($session_user=='admin'){
                $this->setAppName();
                return $this->render('index');
            } else {
                //return $this->render('index');
                return $this->actionLogin();
            }  
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeceaces()
    {
        return $this->redirect(Url::to(['/pregnancycdssdiseases/index']));
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function setAppName()
    {
        //check session
        $session = Yii::$app->session;
        if ($session->isActive) {
            $facility = Yii::$app->db->createCommand('SELECT facility FROM users WHERE username="'.$session['openEMRauthUser'].'"')->queryOne();
            print_r($facility);
            Yii::$app->name = $facility['facility'];
        } else {
            Yii::$app->name = 'empty';
        }
    }
}
