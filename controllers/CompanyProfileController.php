<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use app\models\VerifyEmailForm;
use app\models\VendorCard;


class CompanyProfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', ],
                'rules' => [
                    [
                        'actions' => ['logout', 'index',],
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

    public function beforeAction($action){
        if(Yii::$app->user->isGuest){
            $this->layout = 'guest';
            $this->goHome();
        }
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true; // or false to not run the action
    }


    public function actionIndex()
    {
        $model = new VendorCard();
        $service = Yii::$app->params['ServiceName']['VendorCard'];
        if(Yii::$app->recruitment->HasProfileOnDynamics(Yii::$app->user->identity->id)){
            $filter = [
                'PortalId' => Yii::$app->user->identity->id,
            ];
            $result = Yii::$app->navhelper->getData($service, $filter);
            $model = $this->loadtomodel($result[0],$model);  

            return $this->render('view', ['model'=>$model]);
        }
        //No Profile Detected. Let's Create Them One
        $model->E_Mail = Yii::$app->user->identity->email;
        $model->PortalId = Yii::$app->user->identity->id;
        $model->Phone_No = Yii::$app->user->identity->companyPhoneNo;
        $result = Yii::$app->navhelper->postData($service,$model);
        
        if(isset($result->No)){ //Added Sucesfully
            //Load to Model
            $model = $this->loadtomodel($result,$model);  
            return $this->render('view', ['model'=>$model]);
        }

    }


    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }



}
