<?php

namespace app\controllers;
use yii\helpers\ArrayHelper;
use app\models\SupplierAttachement;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


class AttachementsController extends \yii\web\Controller
{
    public function behaviors()
    {
       return [ 
           'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['get-attachements',],
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
        $model = new SupplierAttachement();
        $service = Yii::$app->params['ServiceName']['SupplierPartnerDetails'];

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'Attachmentmodel' => $model,
                'CompanyData'  => Yii::$app->recruitment->getCompanyApplicationNo(),
                'Countries' => ArrayHelper::map($this->getCountries(),'Code','Name'),
                'Cities' => ArrayHelper::map($this->getPostalCodes(),'Code','Name'),
            ]);
        }

        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())){

            // $model->File_path = UploadedFile::getInstance($model, 'imageFile');
            $model->File_path = UploadedFile::getInstanceByName('File_path');

            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // exit();

            $result = $model->Upload($model);

            if(isset($result->Key)){//Sucess
                Yii::$app->session->setFlash('success','Attachement Uploaded Succesfully' );
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }else{
                Yii::$app->session->setFlash('error','Error Uploading Attachement : '.$result );
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
            

        }

    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate($VendorNo, $PartnerId)
    {
        $model = new PartnerDetails();
        $service = Yii::$app->params['ServiceName']['SupplierPartnerDetails'];
        $filter = ['Supplier_No' => $VendorNo, 'Partner_ID_No'=>$PartnerId ];
        $PartnerDetails = \Yii::$app->navhelper->getData($service, $filter);
        Yii::$app->navhelper->loadmodel($PartnerDetails[0],$model);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'model' => $model,
                'Countries' => ArrayHelper::map($this->getCountries(),'Code','Name'),
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

    public function actionDelete($VendorNo, $PartnerId)
    {
        $model = new PartnerDetails();
        $service = Yii::$app->params['ServiceName']['SupplierPartnerDetails'];
        $filter = ['Supplier_No' => $VendorNo, 'Partner_ID_No'=>$PartnerId ];
        $PartnerDetails = \Yii::$app->navhelper->getData($service, $filter);
        Yii::$app->navhelper->loadmodel($PartnerDetails[0],$model);
        $result = Yii::$app->navhelper->deleteData($service,$model->Key);

        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Partner Deleted Successfully.' );
            return $this->redirect(Yii::$app->request->referrer);
        }else{
            Yii::$app->session->setFlash('error','Unable To delete Partner. '.$result );
            return $this->redirect(Yii::$app->request->referrer);

        }

        return $this->render('update');
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];
        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Name))
            $res[] = [
                'Code' => $c->Code,
                'Name' => $c->Name
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


    
    public function actionGetAttachements(){
        $CompanyData  = Yii::$app->recruitment->getCompanyApplicationNo();
        $service = Yii::$app->params['ServiceName']['SupplierAttachements'];
        $filter = ['Supplier_No' => $CompanyData[0]->No];
        $SupplierAttachements = \Yii::$app->navhelper->getData($service,$filter);
        // echo '<pre>';
        // print_r($Partners);
        // exit;
        $result = [];
        $count = 0;

        if(!is_object($SupplierAttachements)){
            foreach($SupplierAttachements as $SupplierAttachement){
                if(!empty($SupplierAttachement->Name)){
                    ++$count;

                    $EditLink = 
                         \yii\helpers\Html::button('Edit',
                            [  'value' => \yii\helpers\Url::to(['attachements/update',
                                'VendorNo'=> @$SupplierAttachement->Supplier_No , 'PartnerId'=>$SupplierAttachement->Name
                                ]),
                                'title' => 'Edit Details',
                                'class' => 'btn btn-outline-info push-right showModalButton',
                                ]
                            ); 

                    $Deletelink =  \yii\helpers\Html::a('Remove',['delete',
                        'VendorNo'=> @$SupplierAttachement->Supplier_No , 'PartnerId'=>$SupplierAttachement->Name ],
                            ['class'=>'btn btn-outline-danger push-left', 'data'=>[
                             'confirm'=>'Are You Sure You Want To Remove the Attachement?',
                             'method'=>'post'
                         ]]
                    );

                    $result['data'][] = [
                        'index' => $count,
                        'Key' => $SupplierAttachement->Key,
                        'Name' => !empty($SupplierAttachement->Name)?$SupplierAttachement->Name:'',
                        'File_path' => !empty($SupplierAttachement->File_path)?$SupplierAttachement->File_path:'',
                        'Action' => $EditLink .' '. $Deletelink
                    ];
                }
    
            }
        }
        

        return $result;
    }


}
