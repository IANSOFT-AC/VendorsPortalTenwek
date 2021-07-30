<?php

namespace app\controllers;
use yii\helpers\ArrayHelper;
use app\models\SupplierCategories;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;

class SupplierCategoriesController extends \yii\web\Controller
{
    public function behaviors()
    {
       return [ 
           'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['get-supplier-categories', 'sub-bank-branches'],
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
    public function actionCreate()
    {
        $model = new SupplierCategories();
        $service = Yii::$app->params['ServiceName']['SupplierCategories'];

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

    public function actionBankBranches() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getBankBranches($cat_id); 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate($VendorNo, $BankId)
    {
        $model = new BankDetails();
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

    public function actionDelete($VendorNo, $PartnerId)
    {
        $model = new BankDetails();
        $service = Yii::$app->params['ServiceName']['SupplierBankAccounts'];
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


    public function getBanks(){
        $service = Yii::$app->params['ServiceName']['KenyaBanks'];
        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Bank_Name))
            $res[] = [
                'Code' => $c->Bank_Code,
                'Name' => $c->Bank_Name
            ];
        }

        return $res;
    }
    

    
    public static function getBankBranches($Bank){
        $service = Yii::$app->params['ServiceName']['BankBranches'];
        $filter = ['Bank_Code' => $Bank];
        $res = [];
        $Branches = \Yii::$app->navhelper->getData($service, $filter);
        foreach($Branches as $Branch){
            if(!empty($Branch->Name))
            $res[] = [
                'Code' => $Branch->Branch_Code,
                'Name' => $Branch->Branch_Name
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


    
    public function actionGetSupplierCategories(){
        $CompanyData  = Yii::$app->recruitment->getCompanyApplicationNo();
        $service = Yii::$app->params['ServiceName']['SupplierCategories'];
        $filter = ['Supplier_No' => $CompanyData[0]->No];
        $SupplierCategories = \Yii::$app->navhelper->getData($service,$filter);
        // echo '<pre>';
        // print_r($Partners);
        // exit;
        $result = [];
        $count = 0;

        if(!is_object($SupplierCategories)){
            foreach($SupplierCategories as $SupplierCategory){
                if(!empty($SupplierCategory->Code)){
                    ++$count;

                    $EditLink = 
                         \yii\helpers\Html::button('Edit',
                            [  'value' => \yii\helpers\Url::to(['banks/update',
                                'VendorNo'=> @$SupplierCategory->Supplier_No , 'Category'=>$SupplierCategory->Category
                                ]),
                                'title' => 'Edit Category Details',
                                'class' => 'btn btn-outline-info push-right showModalButton',
                                ]
                            ); 

                    $Deletelink =  \yii\helpers\Html::a('Remove',['delete',
                        'VendorNo'=> @$SupplierCategory->Supplier_No , 'Category'=>$SupplierCategory->Category ],
                            ['class'=>'btn btn-outline-danger push-left', 'data'=>[
                             'confirm'=>'Are You Sure You Want To Remove the Category?',
                             'method'=>'post'
                         ]]
                    );

                    $result['data'][] = [
                        'index' => $count,
                        'Key' => $SupplierCategory->Key,
                        'Description' => !empty($SupplierCategory->Description)?$SupplierCategory->Description:'',
                        'Category' => !empty($SupplierCategory->Category)?$SupplierCategory->Category:'',
                        'Action' => $EditLink .' '. $Deletelink
                    ];
                }
    
            }
        }
        

        return $result;
    }


}
