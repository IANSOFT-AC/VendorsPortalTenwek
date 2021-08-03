<?php

namespace app\controllers;
use yii\helpers\ArrayHelper;
use app\models\BankDetails;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class TendersController extends \yii\web\Controller
{
    public function behaviors()
    {
       return [ 
           'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['get-tenders'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','update'],
                'rules' => [
                    [
                        'actions' => ['index', 'create','update'],
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
                    'delete' => ['post'],
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
    
    public function actionCreate()
    {
        $model = new BankDetails();
        $service = Yii::$app->params['ServiceName']['SupplierBankAccounts'];

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'Banks' => ArrayHelper::map($this->getBanks(),'Code','Name'),
                'Cities' => ArrayHelper::map($this->getPostalCodes(),'Code','Name'),

            ]);
        }

        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())){
            $CompanyProfileData = Yii::$app->recruitment->getCompanyApplicationNo();
           

            $model->Supplier_No = $CompanyProfileData[0]->No;
            $result = Yii::$app->navhelper->postData($service,$model);
            if(is_object($result)){
                Yii::$app->session->setFlash('success','Partner Succesfully Added');
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);
            }

        }

    }



    public function actionIndex()
    {
        return $this->render('index');
    }


    
    public function actionGetTenders(){
        $service = Yii::$app->params['ServiceName']['AdvertisedTenderList'];
        $AdvertisedTenders = \Yii::$app->navhelper->getData($service);
        // echo '<pre>';
        // print_r($Partners);
        // exit;
        $result = [];
        $count = 0;

        if(!is_object($AdvertisedTenders)){
            foreach($AdvertisedTenders as $AdvertisedTender){
                if(!empty($AdvertisedTender->Title)){
                    ++$count;

                    $EditLink = 
                         \yii\helpers\Html::button('Edit',
                            [  'value' => \yii\helpers\Url::to(['tenders/view',
                                'VendorNo'=> @$AdvertisedTender->Supplier_No , 'BankId'=>$AdvertisedTender->Code
                                ]),
                                'title' => 'View Tender Details',
                                'class' => 'btn btn-outline-info push-right showModalButton',
                                ]
                            ); 

                    $result['data'][] = [
                        'index' => $count,
                        'Title', $AdvertisedTender->Title,
                        'Key' => $AdvertisedTender->Key,
                        'Tender_Opening_Date' => !empty($AdvertisedTender->Name)?$AdvertisedTender->Tender_Opening_Date:'',
                        'Creation_Date' => !empty($AdvertisedTender->Creation_Date)?$AdvertisedTender->Creation_Date:'',
                        'Action' => $EditLink 
                    ];
                }
    
            }
        }
        

        return $result;
    }


}
