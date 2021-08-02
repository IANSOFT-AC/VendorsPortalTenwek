<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class VendorCard extends Model
{
    public $No;
    public $Name;
    public $Balance_LCY;
    public $Balance_Due_LCY;
    public $Generated_Vendor_No;
    public $Address;
    public $Address_2;
    public $Post_Code;
    public $City;
    public $Country_Region_Code;
    public $Phone_No;
    public $E_Mail;
    public $Fax_No;
    public $Home_Page;
    public $Supplier_Type;
    public $Application_Date;
    public $AGPO_Certificate;
    public $Trade_Licennse_No;
    public $Certificate_of_Incorporation;
    public $Registration_No;
    public $Registration_Date;
    public $Tax_Compliance_Certificate_No;
    public $Tax_Compliance_Expiry_Date;
    public $VAT_Certificate_No;
    public $PIN_No;
    public $No_of_Businesses_at_one_time;
    public $Registration_Status;
    public $Payment_Terms_Code;
    public $Payment_Method_Code;
    public $PortalId;
    public $Key;
    public $HasAcceptedTermsAndConditions;

    public function rules()
    {
        return [
            [['E_Mail', 'PIN_No', 'Trade_Licennse_No', 'Supplier_Type', 
                 'Phone_No', 'Address', 'VAT_Certificate_No', 'Tax_Compliance_Expiry_Date', 'Tax_Compliance_Certificate_No',
                 'Registration_No', 'Certificate_of_Incorporation', 'Name', 'Key', 'Registration_Date', 'HasAcceptedTermsAndConditions'], 
            'required'],

           ['E_Mail', 'email'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'E_Mail' => 'Organization Email',
            'PIN_No' => 'KRA PIN NO',
            'Trade_Licennse_No' => ' Trade Licence No',
            'Supplier_Type' =>  'Supplier Type',
            'Phone_No' => 'Organization Phone No',
            'Address' => 'Business Location',

            'VAT_Certificate_No' => 'VAT Certificate No',
            'Tax_Compliance_Expiry_Date' => 'Tax Compliance Expiry Date',
            'Trade_Licennse_No' => ' Trade Licence No',
            'Tax_Compliance_Certificate_No' =>  'Tax Compliance Certificate',
            'Registration_No' => 'Business Registration No',
            'Certificate_of_Incorporation' => 'Certificate of Incorporation',
            'Name'=>'Organization Name',
            'HasAcceptedTermsAndConditions'=>'Accept Terms And Conditions'


        ];
    }



}
?>