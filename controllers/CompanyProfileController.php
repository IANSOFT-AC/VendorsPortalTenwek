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
use yii\helpers\ArrayHelper;


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
        }
        //Check  If Company Is Selected
        $NotGuest = !(Yii::$app->user->isGuest);
        $CompanyIsSelected =false;
        if (!Yii::$app->session->has('SelectedCompany')){
          $CompanyIsSelected =true;
        }

        if (($CompanyIsSelected && $NotGuest)){
            if($action->id == 'select-company'){
                return true;
            }
            $this->redirect(array('site/select-company'));
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
        $SupplierCategories = ArrayHelper::map($this->getSupplierCategories(),'Code','Name') ;
        $PostalCodes = ArrayHelper::map($this->getPostalCodes(),'Code','Name') ;

        // echo '<pre>';
        // print_r(Yii::$app->request->post());
        // exit;


        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())){

            $result = Yii::$app->navhelper->updateData($service,$model);
            if(is_object($result)){
                Yii::$app->session->setFlash('success','Profile Succesfully Updated');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(['index']);
            }

        } 

        if(!Yii::$app->recruitment->HasProfileOnDynamics(Yii::$app->user->identity->id)){           
            //No Profile Detected. Let's Create Them One
            $model->E_Mail = Yii::$app->user->identity->email;
            $model->PortalId = Yii::$app->user->identity->id;
            $model->Phone_No = Yii::$app->user->identity->companyPhoneNo;
            $model->Name = Yii::$app->user->identity->CompanyName;
            $result = Yii::$app->navhelper->postData($service,$model);

            if(is_string($result)){
                Yii::$app->session->setFlash('error',$result);
                return $this->goHome();

            }
        }

        $filter = [
            'PortalId' => Yii::$app->user->identity->id,
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);

        if (Yii::$app->session->has('SelectedCompany')){
            $model = $this->loadtomodel($result[0],$model);  
        }

        return $this->render('update', ['model'=>$model, 'SupplierCategories'=>$SupplierCategories, 'PostalCodes'=>$PostalCodes]);  

    }

    public function getSupplierCategories(){
        $service = Yii::$app->params['ServiceName']['SupplierCategory'];

        $res = [];
        $SupplierCategories = \Yii::$app->navhelper->getData($service);
        foreach($SupplierCategories as $SupplierCategory){
            if(!empty($SupplierCategory->Category_Code))
            $res[] = [
                'Code' => $SupplierCategory->Category_Code,
                'Name' => $SupplierCategory->Description
            ];
        }

        return $res;
    }

    public function getPostalCodes(){
        $service = Yii::$app->params['ServiceName']['PostalCodes'];

        $res = [];
        $PostalCodes = \Yii::$app->navhelper->getData($service);
        foreach($PostalCodes as $PostalCode){
            if(!empty($PostalCode->Code))
            $res[] = [
                'Code' => $PostalCode->Code,
                'Name' => $PostalCode->City
            ];
        }

        return $res;
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
