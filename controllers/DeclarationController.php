<?php

namespace app\controllers;
use yii\helpers\ArrayHelper;
use app\models\VendorCard;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class DeclarationController extends \yii\web\Controller
{
    public function behaviors()
    {
       return [ 
          
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','submit'],
                'rules' => [
                    [
                        'actions' => ['index', 'submit'],
                        'allow' => true,
                        'roles' => ['@'],
                        // 'matchCallback' => function($rule,$action){
                        //    // return (Yii::$app->session->has('HRUSER') || !Yii::$app->user->isGuest);
                        // },
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', ],
                ],
            ],

            

        ];

    }
 

    public function actionIndex()
    {
        $model = new VendorCard();
        $service = Yii::$app->params['ServiceName']['VendorCard'];

        $filter = [
            'PortalId' => Yii::$app->user->identity->id,
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        $model = $this->loadtomodel($result[0],$model);

        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())){
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(is_object($result)){
                $this->SubmitProfile($model->No);
            }else{
                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);
            }

        }

        return $this->render('index', ['model'=>$model]);
    }

    public function SubmitProfile($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'appNo' => $ApplicationNo,
        ];

        $SubmissionResult = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSubmitApplication');
        
        if(!is_string($SubmissionResult)){
            Yii::$app->session->setFlash('success', 'Profile Successfully Submitted');
            return $this->goHome();
        }else{
            Yii::$app->session->setFlash('error', 'The Following Error Occured while Trying to Submit Your Profile  : '. $SubmissionResult);
            return $this->goHome();
        }

    }

    public function actionUpdate($VendorNo, $BankId)
    {
        $model = new VendorCard();
        $service = Yii::$app->params['ServiceName']['SupplierBankAccounts'];
        $filter = ['Supplier_No' => $VendorNo, 'Code'=>$BankId ];
        $PartnerDetails = \Yii::$app->navhelper->getData($service, $filter);
        Yii::$app->navhelper->loadmodel($PartnerDetails[0],$model);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'model' => $model,
                'Banks' => ArrayHelper::map($this->getBanks(),'Code','Name'),
                'Cities' => ArrayHelper::map($this->getPostalCodes(),'Code','Name'),
            ]);
        }


        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())){
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(is_object($result)){
                Yii::$app->session->setFlash('success','Bank Data Succesfully Updates');
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);
            }

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
