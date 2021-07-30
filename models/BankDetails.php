<?php
namespace app\models;
use Yii;
use yii\base\Model;

class BankDetails extends Model
    {

        public $Supplier_No;
        public $Code;
        public $Name;
        public $Address;
        public $City;
        public $Post_Code;
        public $Contact;
        public $Bank_Branch_No;
        public $Bank_Account_No;
        public $E_Mail;
        public $SWIFT_Code;
        public $Key;


        public function rules()
        {
            return [
                [['Code', 
                     'City', 'Post_Code', 'Contact',  'Bank_Account_No', 'SWIFT_Code',], 
                'required'],
    
                ['Bank_Account_No', 'string',  'min'=>7],
    
            ];
        }
    
    
        public function attributeLabels()
        {
            return [
                'Code' => 'Bank Name',
                'Post_Code' => 'Bank Postal Address',
                'Contact' => 'Bank Contact Phone Number',
                'Bank_Branch_No' =>  'Bank Branch',
                'Bank_Account_No' => 'Bank Account No',
                'SWIFT_Code' => 'Bank Swift Code',
            ];
        }


    }

?>
